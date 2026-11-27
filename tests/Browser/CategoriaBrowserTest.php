<?php

use App\Models\User;
use App\Filament\Resources\Categorias\CategoriaResource;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('registrar una categoría desde el navegador', function () {
    // Prueba 1 de la práctica: expect(true)->toBeTrue();
    User::factory()->create([
        'name' => 'Administrador',
        'email' => 'admin.prueba@example.com',
        'password' => bcrypt('password123'),
        'rol' => 'admin'
    ]);

    $pagina = visit('/admin/login');

    // Iniciar sesión
    $pagina
        ->typeSlowly('input[type="email"]', 'admin.prueba@example.com')
        ->typeSlowly('input[type="password"]', 'password123')
        ->press('Entrar')
        ->wait(3);

    // Abrir el listado de categorías
    $pagina
        ->navigate(CategoriaResource::getUrl('index'))
        ->wait(3)
        ->assertPathIs(
            parse_url(CategoriaResource::getUrl('index'), PHP_URL_PATH)
        );

    // Abrir el formulario
    $pagina
        ->navigate(CategoriaResource::getUrl('create'))
        ->wait(2)
        ->assertSee('Crear Categoria')
        ->wait(2);

    // Completar el formulario
    $pagina
        ->typeSlowly('[id="form.nombre"]', 'Tecnología')
        ->typeSlowly('[id="form.descripcion"]', 'Ideas tecnológicas')
        ->assertValue('[id="form.nombre"]', 'Tecnología')
        ->assertValue('[id="form.descripcion"]', 'Ideas tecnológicas');

    // Guardar la categoría
    $pagina
        ->click('button:has-text("Crear")')
        ->assertPathIs(
            parse_url(CategoriaResource::getUrl('index'), PHP_URL_PATH)
        )
        ->assertSee('Categoría creada exitosamente')
        ->wait(5);

    // Comprobar la base de datos
    $this->assertDatabaseHas('categorias', [
        'nombre' => 'Tecnología',
        'descripcion' => 'Ideas tecnológicas'
    ]);

});
