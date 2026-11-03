<?php

namespace App\Filament\Resources\Ideas\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;
use Filament\Schemas\Schema;
use App\Helpers\EstadoIdea;
use Filament\Schemas\Components\Utilities\Get;

class IdeaForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('titulo')
                    ->label('Título de la idea')
                    ->helperText('Ingrese un título ilustrativo y breve')
                    ->placeholder('Título de la idea')
                    ->unique()
                    ->required()
                    ->validationMessages([
                        'unique' => 'Ya existe una idea registrada con ese título',
                    ]),
                
                Textarea::make('descripcion')
                    ->label('Describe tu idea')
                    ->helperText('Describe a detalle en qué consiste la idea del proyecto')
                    ->required()
                    ->columnSpanFull(),

                TextInput::make('autor')
                    ->required(),
                
                Select::make('categoria_id')
                    ->relationship('categoria', 'nombre')
                    ->required(),

                Select::make('estado')
                    ->required()
                    ->options(EstadoIdea::opciones())  
                    ->default('registrada')
                    ->hiddenOn('create')
                    ->disabled(fn () => auth()->user()->rol !== 'admin' || auth()->user()->rol !== 'coordinador' )
                    ->live(),
                
                Textarea::make('observacion')
                    ->label('Motivo de rechazo')
                    ->visible(fn (Get $get) => 
                        $get('estado') === 'rechazada'
                    )
                    ->maxLength(200)
                    ->required(),

            ]);
    }
}