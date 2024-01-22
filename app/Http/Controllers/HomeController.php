<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use App\Models\Requirement;
use App\Models\RequirementType;
use App\Models\Semester;
use App\Models\Student;
use App\Models\Weekday;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Inertia\Response;
use Adldap\AdldapInterface as ADInterface;
use Adldap\Query\Collection;
use App\Http\Requests\StoreStudentOfADRequest;
use App\Models\Course;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class HomeController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Index', [
            'semester' => Semester::where('start', '<=', now())->where('end', '>=', now())->count() > 0
        ]);
    }

    public function postEnrollments(StoreStudentOfADRequest $request, ADInterface $ad): RedirectResponse
    {
        $data = $this->getDataOfAD($ad, $request->validated());

        if (!is_array($data)) {
            return to_route('home')->with('flash', [
                'status' => 'warning', 'message' => 'Servidor de dados está temporariamente fora do ar. Por favor, tente novamente mais tarde.'
            ]);
        }

        try {
            $student = Student::firstOrCreate(
                ['cpf' => $data['student']['cpf']],
                $data['student']
            );

            foreach ($data['enrollments'] as $enrollment) {
                $student->enrollments()->firstOrCreate(
                    ['number' => $enrollment['number']],
                    $enrollment
                );
            }
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return to_route('home')->with('flash', ['status' => 'danger', 'message' => $e->getMessage()]);
        }

        $student->load(['enrollments:id,number' => ['course:id,cod,name']]);

        Session::put('student', $student->id);
        Session::put('token', Str::random(20));
        return to_route('home.enrollments.get', ['token' => Session::get('token')]);
    }

    public function getEnrollments(Request $request): Response
    {
        if (Session::get('token') != $request->token) {
            return to_route('home')->with('flash', [
                'status' => 'warning', 'message' => 'Token inválido. Por favor, tente novamente.'
            ]);
        }

        $student = Student::with(['enrollments:id,number' => ['course:id,cod,name']])->findOrFail(Session::get('student'));

        $enrollments = $student->enrollments()->get()->map(function ($enrollment) {
            return [
                'number' => $enrollment->id,
                'course' => $enrollment->number . ' | ' . $enrollment->course->name,
            ];
        });

        return Inertia::render('Home/Enrollments', [
            'listWeekDays' => Weekday::getActiveDays(),
            'enrollments' => $enrollments,
            'student' => $student,
            'requirements' => RequirementType::getActiveTypes(),
            'token' => $request->token,
        ]);
    }

    public function postRequirements(Request $request): RedirectResponse
    {
        if (Session::get('token') != $request->token) {
            return to_route('home')->with('flash', [
                'status' => 'warning', 'message' => 'Token inválido. Por favor, tente novamente.'
            ]);
        }

        $data = $request->validate([
            'enrollment' => 'required|exists:enrollments,id',
            'weekdays' => 'required|array',
            'weekdays.*' => 'required|exists:weekdays,id',
            'requirement' => 'required|exists:requirement_types,id',
            'justification' => 'nullable|string|min:3|max:255',
        ]);

        /**
         * Verifica se o aluno já possui uma solicitação do mesmo tipo em andamento
         */
        if (Requirement::where('enrollment_id', $data['enrollment'])->where('requirement_type_id', $data['requirement'])->where('semester_id', Semester::where('start', '<=', now())->where('end', '>=', now())->first()->id)->count() > 0) {
            return to_route('home.enrollments.get', $request->token)->with('flash', [
                'status' => 'warning', 'message' => 'Você já possui uma solicitação deste tipo em andamento.'
            ]);
        }

        $requirement = Requirement::create([
            'status' => Requirement::TO_ANALYZE,
            'justification' => $data['justification'],
            'enrollment_id' => $data['enrollment'],
            'requirement_type_id' => $data['requirement'],
            'semester_id' => Semester::where('start', '<=', now())->where('end', '>=', now())->first()->id,
        ]);

        $requirement->weekdays()->attach($data['weekdays']);

        Session::put('requirement', $requirement->id);

        return to_route('home.requirements.get', $request->token);
    }

    public function getRequirements(Request $request): Response
    {
        if (Session::get('token') != $request->token) {
            return to_route('home')->with('flash', [
                'status' => 'warning', 'message' => 'Token inválido. Por favor, tente novamente.'
            ]);
        }

        $requirement = Requirement::with(['enrollment' => ['course', 'student'], 'requirementType', 'semester', 'weekdays'])->findOrFail(Session::get('requirement'));

        return Inertia::render('Home/Requirements', [
            'requirement' => $requirement
        ]);
    }

    public function faq(Request $request): Response
    {
        $query = Faq::select('id', 'question', 'answer')
            ->where('question', 'like', '%'.$request->term.'%')
            ->orWhere('answer', 'like', '%'.$request->term.'%')
            ->orderBy('question', 'ASC')
            ->get();

        return Inertia::render('Faq', [
            'faqs' => $query,
        ]);
    }


    public function getDataOfAD(ADInterface $ad, array $data): string|array
    {
        try {
            $student = $ad->search()
                ->select(['cn', 'description', 'mailNickname', 'extensionAttribute6', 'extensionAttribute7', 'mail', 'extensionAttribute4', 'extensionAttribute15'])
                ->where([['extensionAttribute6', '=', preg_replace('/[^0-9]/', '', $data['cpf']), ['extensionAttribute7' => preg_replace('/[^0-9]/', '', $data['birth'])]]])
                ->get();
        } catch (Exception $e) {
            return $e->getMessage();
        }

        return $this->sanitizeActiveDirectoryData($student, $data);
    }

    private function sanitizeActiveDirectoryData(Collection $data, array $request): ?array
    {
        if (empty($data)) {
            throw ValidationException::withMessages([
                'cpf' => 'Nenhuma matricula encontrada para seu CPF. Por favor procurar a Coordenadoria de Controle Acadêmico para regularização da sua situação.'
            ]);
        }

        $enrollments = [];
        $student = [];

        foreach ($data as $item) {
            // Verifica se a matricula está no padrão atual de 14 dígitos
            if ($item->extensionattribute15[0] != 'Ativo')
                continue;

            // Lança um erro caso não tenha nenhum e-mail
            if (!isset($item->mailNickname[0]) && !isset($item->extensionAttribute4[0]))
                $error = $item->cn[0];

            if (empty($student)) {
                $student = [
                    'cpf' => self::sanitizeCPF($item->extensionattribute6[0]),
                    'rg' => $request['rg'],
                    'birth' => $request['birth'],
                    'name' => $item->description[0],
                    'personal_email' => $item->mailNickname[0] ?? $item->extensionAttribute4[0],
                    'institutional_email' => $item->extensionAttribute4[0] ?? null,
                ];
            }

            $enrollments[] = [
                'number' => $item->cn[0],
                'course_id' => self::getCourse($item->cn[0])->id,
            ];
        }

        return [
            'enrollments' => $enrollments,
            'student' => $student,
        ];
    }

    private static function sanitizeCPF($cpf)
    {
        return sprintf('%d%d%d.%d%d%d.%d%d%d-%d%d', ...str_split($cpf));
    }

    private static function getCourse($data)
    {
        $course = Course::where('cod', substr($data, 5, 5))->first();

        if ($course) {
            return $course;
        }

        return Course::where('cod', '00000')->first();
    }
}
