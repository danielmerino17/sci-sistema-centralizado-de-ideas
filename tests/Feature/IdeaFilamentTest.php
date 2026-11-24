<?php

use App\Models\User;
use App\Models\Idea;
use App\Models\Categoria;
use App\Filament\Resources\Ideas\Pages\EditIdea;
use App\Filament\Resources\Ideas\Pages\ListIdeas;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;

uses(RefreshDatabase::class);

beforeEach(function () {

    $this->usuario = User::factory()->create([
        'rol' => 'admin'
    ]);

    $this->actingAs($this->usuario);

    $this->categoria = Categoria::create([
        'nombre' => 'Ciencia',
        'descripcion' => 'Ideas de ciencias',
    ]);

    $this-> idea = Idea::create([
        'titulo' => 'Aplicación de transporte',
        'descripcion' => 'Aplicación para compartir viajes',
        'autor' => 'Ana',
        'estado' => 'registrada',
        'categoria_id' => $this->categoria->id
    ]);

});

test('comprobar datos iniciales', function(){
    $this->assertAuthenticated();
    $this->assertDatabaseHas('ideas', ['id' => 1, 'estado' => 'registrada']);
});

test('editar una idea sin descripción', function() {
    Livewire::test(EditIdea::class, [
        'record' => $this->idea->id
    ])

    ->fillForm([
        'titulo' => 'Aplicación para transporte escolar',
        'descripcion' => ''
    ])
    ->call('save')
    ->assertHasFormErrors([
        'descripcion' => 'required'
    ]);

    $this->assertDatabaseHas('ideas', [
        'id' => 1,
        'titulo' => 'Aplicación de transporte',
        'descripcion' => 'Aplicación para compartir viajes',
    ]);});