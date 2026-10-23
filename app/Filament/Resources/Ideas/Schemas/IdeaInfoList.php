<?php

namespace App\Filament\Resources\Ideas\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class IdeaInfoList
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('titulo')
                    ->label('Título de la idea')
                    ->weight('bold')
                    ->size('lg'),
                    
                    // Tarea extra 23 de octubre:
                TextEntry::make('descripcion')
                    ->label('Descripción de la idea')
                    ->columnSpanFull(), // Se usa todo el ancho del modal. 
                TextEntry::make('autor')
                    ->label('Autor de la idea'),
                TextEntry::make('categoria.nombre')
                    ->label('Categoría de la idea'),
                TextEntry::make('estado') 
                    ->label('Estado de la idea')
                    ->badge()
                    ->color('info'), // Color del texto.
                TextEntry::make('created_at')
                    ->label('Fecha de creación')
                    ->date('d/m/Y H:i'), // Muestra día/mes/año y hora:minutos.
                TextEntry::make('updated_at')
                    ->label('Última actualización de la idea'),

            ]);
    }
}