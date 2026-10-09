<?php

namespace App\Filament\Resources\Ideas\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class IdeaForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columnSpanFull()
            ->components([
                TextInput::make('titulo')
                    ->required()
                    ->default('registrada'),
                Textarea::make('autor')
                    ->required(),
                Select::make('categoria_id')
                    ->relationship('categoria', 'nombre')
                    ->requiered(),
            ]);
    }
}
