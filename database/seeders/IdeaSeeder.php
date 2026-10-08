<?php

namespace Database\Seeders;

use App\Models\Idea;
use Illuminate\Database\Seeder;

class IdeaSeeder extends Seeder
{
    public function run(): void
    {
        Idea::create([
            'titulo' => 'Aplicación para organizar citas veterinarias',
            'descripcion' => 'Sistema para registrar y organizar citas de mascotas.',
            'estado' => 'registrada',
            'autor' => 'Jose',
            'categoria_id' => 1
        ]);
 
       Idea::create([
            'titulo' => 'Plataforma para cursos en línea',
            'descripcion' => 'Sistema para ofrecer cursos y materiales educativos.',
            'estado' => 'en revisión',
            'autor' => 'Pedro',
            'categoria_id' => 2
        ]);

         // Tarea 2 de octubre del 2026 (crear una nueva idea):
        Idea::create ([
            'titulo' => 'Aplicación de seguimiento de hábitos saludables',
            'descripcion' => 'Sistema para registrar y analizar hábitos de salud.',
            'estado' => 'aprobada',
            'autor' => 'Maria',
            'categoria_id' => 3
        ]);

        // Actividad en clase.
        Idea::firstOrCreate([
            'titulo' => 'Plataforma para cursos presenciales',
            'descripcion' => 'Sistema para ofrecer cursos y materiales educativos presenciales.',
            'estado' =>  'registrada',
            'autor' => 'Daniel',
            'categoria_id' => 4
        ]);
    }
}