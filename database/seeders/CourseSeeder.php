<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\CourseType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Course::insert([
            [
                'cod' => '00000',
                'name' => 'Curso não encontrado',
                'course_type_id' => CourseType::getIdByDescription('Tecnológico'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'cod' => '07333',
                'name' => 'Tecnologia em Saneamento Ambiental',
                'course_type_id' => CourseType::getIdByDescription('Tecnológico'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'cod' => '07330',
                'name' => 'Tecnologia em Mecatrônica Industrial',
                'course_type_id' => CourseType::getIdByDescription('Tecnológico'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'cod' => '07334',
                'name' => 'Tecnologia em Mecatrônica Industrial',
                'course_type_id' => CourseType::getIdByDescription('Tecnológico'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'cod' => '07331',
                'name' => 'Tecnologia em Alimentos',
                'course_type_id' => CourseType::getIdByDescription('Tecnológico'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'cod' => '07332',
                'name' => 'Tecnologia em Irrigação e Drenagem',
                'course_type_id' => CourseType::getIdByDescription('Tecnológico'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'cod' => '07240',
                'name' => 'Técnico em Eletrotécnica',
                'course_type_id' => CourseType::getIdByDescription('Técnico'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'cod' => '07241',
                'name' => 'Técnico em Mecânica',
                'course_type_id' => CourseType::getIdByDescription('Técnico'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'cod' => '07243',
                'name' => 'Técnico em Meio Ambiente',
                'course_type_id' => CourseType::getIdByDescription('Técnico'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'cod' => '07244',
                'name' => 'Técnico em Panificação',
                'course_type_id' => CourseType::getIdByDescription('Técnico'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'cod' => '07245',
                'name' => 'Técnico em Fruticultura',
                'course_type_id' => CourseType::getIdByDescription('Técnico'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'cod' => '07408',
                'name' => 'Licenciatura em Física',
                'course_type_id' => CourseType::getIdByDescription('Licenciatura'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'cod' => '07247',
                'name' => 'Técnico em Agroindústria',
                'course_type_id' => CourseType::getIdByDescription('Técnico'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'cod' => '07700',
                'name' => 'Especialização em Gestão Ambiental',
                'course_type_id' => CourseType::getIdByDescription('Especialização'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'cod' => '07248',
                'name' => 'Técnico em Segurança do Trabalho',
                'course_type_id' => CourseType::getIdByDescription('Técnico'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'cod' => '07800',
                'name' => 'Mestrado Nacional Profissional em Ensino de Física',
                'course_type_id' => CourseType::getIdByDescription('Mestrado'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'cod' => '07709',
                'name' => 'Especialização em Gestão da Qualidade e Segurança dos Alimentos',
                'course_type_id' => CourseType::getIdByDescription('Especialização'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'cod' => '07249',
                'name' => 'Técnico em Agropecuária',
                'course_type_id' => CourseType::getIdByDescription('Técnico'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'cod' => '07400',
                'name' => 'Licenciatura em Matemática',
                'course_type_id' => CourseType::getIdByDescription('Licenciatura'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'cod' => '07500',
                'name' => 'Bacharelado em Agronomia',
                'course_type_id' => CourseType::getIdByDescription('Bacharel'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'cod' => '07501',
                'name' => 'Bacharelado em Engenharia de Controle e Automação',
                'course_type_id' => CourseType::getIdByDescription('Bacharel'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
