<?php

namespace Database\Seeders;

use App\Models\Course;
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
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'cod' => '07333',
                'name' => 'Tecnologia em Saneamento Ambiental',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'cod' => '07330',
                'name' => 'Tecnologia em Mecatrônica Industrial',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'cod' => '07334',
                'name' => 'Tecnologia em Mecatrônica Industrial',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'cod' => '07331',
                'name' => 'Tecnologia em Alimentos',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'cod' => '07332',
                'name' => 'Tecnologia em Irrigação e Drenagem',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'cod' => '07240',
                'name' => 'Técnico em Eletrotécnica',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'cod' => '07241',
                'name' => 'Técnico em Mecânica',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'cod' => '07243',
                'name' => 'Técnico em Meio Ambiente',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'cod' => '07244',
                'name' => 'Técnico em Panificação',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'cod' => '07245',
                'name' => 'Técnico em Fruticultura',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'cod' => '07408',
                'name' => 'Licenciatura em Física',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'cod' => '07247',
                'name' => 'Técnico em Agroindústria',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'cod' => '07700',
                'name' => 'Especialização em Gestão Ambiental',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'cod' => '07248',
                'name' => 'Técnico em Segurança do Trabalho',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'cod' => '07800',
                'name' => 'Mestrado Nacional Profissional em Ensino de Física',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'cod' => '07709',
                'name' => 'Especialização em Gestão da Qualidade e Segurança dos Alimentos',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'cod' => '07249',
                'name' => 'Técnico em Agropecuária',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'cod' => '07400',
                'name' => 'Licenciatura em Matemática',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'cod' => '07500',
                'name' => 'Bacharelado em Agronomia',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
