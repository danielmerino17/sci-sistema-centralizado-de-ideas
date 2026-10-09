<?php

namespace App\Filament\Resources\Categorias\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class CategoriaForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nombre')
                    ->email() // Campo de texto para correo electrónico (true = válido, false = no válido).
                    ->password(false) // Campo de texto normal (false = no oculto    |     true = oculto).
                    ->label('Nombre de categoría')
                    ->helperText('Ingresa el nombre de la categoría') // Ayuda al usuario a entender qué información se espera.
                    ->placeholder('Ej: Categoría') // Texto de ejemplo dentro del campo.
                    // ->disable() // Deshabilita el campo (no editable).
                    
                    ->required(),     // Campo requerido (OGBLIGATORIO).
                Textarea::make('descripcion')
                    ->label('Descripción')
                    ->helperText('Ingresa una descripción de la categoría') // Ayuda al usuario a entender qué información se espera.
                    ->placeholder('Ej: Descripción de la categoría') // Texto de ejemplo dentro del campo.
                    ->default('') // Valor por defecto (vacío).
                    ->required()
                    ->columnSpanFull(),
            ]);
    }
}
