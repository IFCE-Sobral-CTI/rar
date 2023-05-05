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
        $student = $this->getDataOfAD($ad, $request->validated());

        if (!is_array($student)) {
            return to_route('home')->with('flash', [
                'status' => 'warning', 'message' => 'Servidor de dados está temporariamente fora do ar. Por favor, tente novamente mais tarde.'
            ]);
        }

        dd($student);

        try {
            $student = Student::firstOrCreate(
                ['cpf' => $student['cpf']],
                $student
            );
            foreach ($student->enrollments as $enrollment) {
                $student->enrollments()->firstOrCreate(
                    ['number' => $enrollment['number']],
                    $enrollment
                );
            }
        } catch (Exception $e) {
            return to_route('home')->with('flash', ['status' => 'danger', 'message' => $e->getMessage()]);
        }

        $student = Student::with(['enrollments:id,number' => ['course:id,cod,name']])->find($student->id);

        dd($student);

        Session::put('data', $data);
        Session::put('token', Str::random(20));
        return to_route('home.enrollments.get', ['token' => Session::get('token')]);
    }

    public function getEnrollments(Request $request): Response
    {
        $data = Session::get('data');

        return Inertia::render('Home/Enrollments', [
            'listWeekDays' => Weekday::getActiveDays(),
            'enrollments' => $data['enrollments'],
            'student' => $data['student'],
            'requirements' => RequirementType::getActiveTypes()
        ]);
    }

    public function postRequirements(Request $request): RedirectResponse
    {
        return to_route('home.requirements.get', 1);
    }

    public function getRequirements(Request $request): Response
    {
        $requirement = [
            'student' => [
                'name' => 'Fulano dos Anzois Pereira',
                'cpf' => '000.222.888-66',
                'rg' => '250035522',
                'birth' => '20/09/2001',
                'academic_email' => 'fu.la@no.test',
                'personal_email' => 'fu.la@no.test'
            ],
            'enrollment' => [
                'number' => 20223652554,
                'course' => [
                    'cod' => 32560,
                    'name' => 'Técnico em Mecânica'
                ]
            ],
            'weekdays' => [
                ['id' => 1, 'name' => 'Segunda-feira'],
                ['id' => 2, 'name' => 'Terça-feira'],
                ['id' => 4, 'name' => 'Quinta-feira'],
            ]

        ];

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

        return $this->sanitizeActiveDirectoryData($student);
    }

    private function sanitizeActiveDirectoryData(Collection $data): ?array
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
            if ($item->extensionattribute15[0] != 'Ativo') continue;

            // Lança um erro caso não tenha nenhum e-mail
            if (!isset($item->mailNickname[0]) && !isset($item->extensionAttribute4[0])) $error = $item->cn[0];

            if (empty($student)) {
                $student = [
                    'cpf' => self::sanitizeCPF($item->extensionattribute6[0]),
                    'name' => $item->cn[0],
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

        return Course::where('cod', '00000')->fist();
    }
}
