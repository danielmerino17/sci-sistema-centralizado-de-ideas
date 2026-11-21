<?php

use App\Models\Categoria;
use App\Models\Idea;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

/*
    *BLOQUE 2: Caso de Prueba CP07 - Modificar el estado de una idea
 */
test('CP07. Modificar el estado de una idea', function () {
    $categoria = Categoria::create([
        'nombre' => 'Tecnología',
        'descripcion' => 'Ideas relacionadas con tecnología y software.',
    ]);

    $idea = Idea::create([
        'titulo' => 'Sistema de gestión escolar',
        'descripcion' => 'Plataforma web para control de calificaciones.',
        'estado' => 'registrada',
        'autor' => 'Daniel',
        'categoria_id' => $categoria->id,
    ]);

    // Ejecución (Act): Se modifica únicamente el estado de la idea a 'en revisión'.
    $idea->update([
        'estado' => 'en revisión',
    ]);

    // Verificación (Assert): Se consulta nuevamente el registro desde la BD y se comprueba que sus datos originales permanezcan intactos y que el estado haya cambiado.
    $ideaActualizada = Idea::find($idea->id);

    expect($ideaActualizada->titulo)->toBe('Sistema de gestión escolar')
        ->and($ideaActualizada->descripcion)->toBe('Plataforma web para control de calificaciones.')
        ->and($ideaActualizada->autor)->toBe('Daniel')
        ->and($ideaActualizada->categoria_id)->toBe($categoria->id)
        ->and($ideaActualizada->estado)->toBe('en revisión');

    $this->assertDatabaseHas('ideas', [
        'id' => $idea->id,
        'titulo' => 'Sistema de gestión escolar',
        'estado' => 'en revisión',
    ]);
});

/*
    BLOQUE 3: Caso de Prueba CP08 - Cambiar la categoría de una idea
*/
test('CP08. Cambiar la categoría de una idea', function () {
    $categoriaInicial = Categoria::create([
        'nombre' => 'Educación',
        'descripcion' => 'Ideas relacionadas con educación y aprendizaje.',
    ]);

    $nuevaCategoria = Categoria::create([
        'nombre' => 'Tecnología',
        'descripcion' => 'Ideas relacionadas con tecnología y software.',
    ]);

    $idea = Idea::create([
        'titulo' => 'Plataforma para cursos en línea',
        'descripcion' => 'Sistema para ofrecer cursos y materiales educativos.',
        'estado' => 'registrada',
        'autor' => 'Pedro',
        'categoria_id' => $categoriaInicial->id,
    ]);

    // Ejecución (Act): Se actualiza el identificador de categoría hacia la nueva categoría.
    $idea->update([
        'categoria_id' => $nuevaCategoria->id,
    ]);

    // Verificación (Assert): Se recarga el modelo en memoria y se confirma que apunta a la nueva categoría, tomando '0' en ideas en la anterior y '1' en la nueva.
    $idea->refresh();

    expect($idea->categoria_id)->toBe($nuevaCategoria->id)
        ->and($idea->categoria->nombre)->toBe('Tecnología')
        ->and($categoriaInicial->ideas()->count())->toBe(0)
        ->and($nuevaCategoria->ideas()->count())->toBe(1);
});

/*
    BLOQUE 4: Caso de Prueba CP09 - Eliminar lógicamente una idea (Soft Delete)
*/
test('CP09. Eliminar lógicamente una idea', function () {
    $categoria = Categoria::create([
        'nombre' => 'Salud',
        'descripcion' => 'Ideas relacionadas con salud y bienestar.',
    ]);

    $idea = Idea::create([
        'titulo' => 'Aplicación de seguimiento de hábitos saludables',
        'descripcion' => 'Sistema para registrar y analizar hábitos de salud.',
        'estado' => 'aprobada',
        'autor' => 'Maria',
        'categoria_id' => $categoria->id,
    ]);

    // Ejecución (Act): Se aplica el borrado lógico sobre la instancia de Idea
    $idea->delete();

    // Una consulta normal (Idea::find) debe retornar null.
    expect(Idea::find($idea->id))->toBeNull();

    // La base de datos conserva el registro marcado como eliminado lógicamente.
    $this->assertSoftDeleted('ideas', [
        'id' => $idea->id,
    ]);

    // Al incluir registros eliminados (withTrashed), se verifica que 'deleted_at' tenga fecha.
    $ideaEliminada = Idea::withTrashed()->find($idea->id);
    expect($ideaEliminada)->not->toBeNull()
        ->and($ideaEliminada->deleted_at)->not->toBeNull();
});

/*
    BLOQUE 5: Caso de Prueba CP10 - Registrar una idea con una categoría inexistente
*/
test('CP10. Registrar una idea con una categoría inexistente', function () {
    // Preparación (Arrange): Bandera para detectar si el gestor de BD rechazó la inserción.
    $seRechazo = false;

    // Ejecución (Act): Se intenta crear una idea apuntando a un ID de categoría inexistente (9999).
    try {
        Idea::create([
            'titulo' => 'Idea con categoría inválida',
            'descripcion' => 'Intento de registro con llave foránea inexistente.',
            'estado' => 'registrada',
            'autor' => 'Jose',
            'categoria_id' => 9999,
        ]);
    } catch (QueryException $e) {
        $seRechazo = true;
    }

    // Verificación (Assert): Se confirma que ocurrió el rechazo y que el registro no existe en la tabla.
    expect($seRechazo)->toBeTrue();

    $this->assertDatabaseMissing('ideas', [
        'titulo' => 'Idea con categoría inválida',
        'categoria_id' => 9999,
    ]);
});