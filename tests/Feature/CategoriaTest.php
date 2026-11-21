<?php

use App\Models\Idea;
use App\Models\Categoria;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Database\QueryException;

uses(RefreshDatabase::class);

test('usar base da datos de prueba', function () {
    
    expect(config('database.default'))->toBe('sqlite');

    expect(config('database.connections.sqlite.database'))->toBe(':memory:');
    
});


test('registrar una categoria', function () {
    
    Categoria::create([
        'nombre' => 'Ciencia',
        'descripcion' => 'Ideas de ciencias',
    ]);
    
    // dd(Categoria::all());

    $this->assertDatabaseHas('categorias', [
        'nombre' => 'Ciencia',
        'descripcion' => 'Ideas de ciencias',
    ]);
});

test('consultar una categoria', function () {
    
    $categoria = Categoria::create([
        'nombre' => 'Ciencia',
        'descripcion' => 'Ideas de ciencias',
    ]);
    
    $encontrada = Categoria::find($categoria->id);

    expect($encontrada->nombre)->toBe('Ciencia');
});

test('modificar una categoria', function () {
    
    $categoria = Categoria::create([
        'nombre' => 'Ciencia',
        'descripcion' => 'Ideas de ciencias',
    ]);
    
    $categoria->update([
        'nombre' => 'Innovación',
    ]);

    $this->assertDatabaseMissing('categorias', [
        'id' => $categoria->id,
        'nombre' => 'Ciencia',
    ]);
});

test('eliminar una categoria', function () {
    
    $categoria = Categoria::create([
        'nombre' => 'Ciencia',
        'descripcion' => 'Ideas de ciencias',
    ]);

    $categoria->delete();

    $this->assertDatabaseMissing('categorias', [
        'id' => $categoria->id,
    ]);
});

test('una categoría puede tener varias ideas', function () {
    $categoria = Categoria::create([
        'nombre' => 'Tecnología',
        'descripcion' => 'Ideas tecnológicas'
    ]);

    Idea::create([
        'titulo' => 'Aplicación de transporte',
        'descripcion' => 'Aplicación para compartir viajes',
        'autor' => 'Ana',
        'estado' => 'registrada',
        'categoria_id' => $categoria->id
    ]);

    Idea::create([
        'titulo' => 'Sistema de inventario',
        'descripcion' => 'Control de productos',
        'autor' => 'Luis',
        'estado' => 'registrada',
        'categoria_id' => $categoria->id
    ]);
 	expect($categoria->ideas)->toHaveCount(2);
});

// No se puede borrar si tiene ideas asociadas.
test('no se puede borrar una categoria con ideas asociadas', function () {
    $categoria = Categoria::create([
        'nombre' => 'Tecnología',
        'descripcion' => 'Ideas tecnológicas'
    ]);

    Idea::create([
        'titulo' => 'Aplicación de transporte',
        'descripcion' => 'Aplicación para compartir viajes',
        'autor' => 'Ana',
        'estado' => 'registrada',
        'categoria_id' => $categoria->id
    ]);

    Idea::create([
        'titulo' => 'Sistema de inventario',
        'descripcion' => 'Control de productos',
        'autor' => 'Luis',
        'estado' => 'registrada',
        'categoria_id' => $categoria->id
    ]);

    $seRechazo = false;
    try{
        $categoria->delete();
    } catch (QueryException $e){
        $seRechazo = true;
    }

    expect($seRechazo)->toBeTrue();

    $this->assertDatabaseHas('categorias', [
        'id' => $categoria->id
    ]);
});