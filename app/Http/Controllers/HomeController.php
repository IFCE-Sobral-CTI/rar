<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Inertia\Response;

class HomeController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Index', []);
    }

    public function postEnrollments(Request $request): RedirectResponse
    {
        $data['student'] = [
            'name' => 'Fulano dos Anzois Pereira',
            'cpf' => '000.222.888-66',
            'rg' => '250035522',
            'birth' => '20/09/2001',
        ];

        $data['enrollments'] = [
            ['enrollment' => 2022365214236, 'course' => 'Tecnologia em Mecatrônica Industrial'],
            ['enrollment' => 2022552214896, 'course' => 'Técnico em Mecânica'],
        ];

        Session::put('data', $data);
        Session::put('token', Str::random(20));
        return to_route('home.enrollments.get', ['token' => Session::get('token')]);
    }

    public function getEnrollments(Request $request): Response
    {
        $data = Session::get('data');

        return Inertia::render('Home/Enrollments', [
            'enrollments' => $data['enrollments'],
            'student' => $data['student'],
            'requirements' => [
                ['id' => 1, 'description' => 'Primeira via'],
                ['id' => 2, 'description' => 'Segunda via'],
                ['id' => 3, 'description' => 'Renovação'],
            ]
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
}
