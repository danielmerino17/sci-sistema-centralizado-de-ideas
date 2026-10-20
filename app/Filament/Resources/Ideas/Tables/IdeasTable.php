<?php

namespace App\Filament\Resources\Ideas\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;    
use Filament\Actions\DeleteAction; 
use Filament\Actions\ViewAction;   
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Actions\RestoreAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Tables\Filters\TrashedFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class IdeasTable
{
    public static function configure(Table $table): Table
    {
        return $table
        
            ->columns([
                TextColumn::make('id')
                    ->label('#'),

                TextColumn::make('titulo')  
                    ->label('Idea')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('descripcion')
                    ->label('Descripción')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('estado')
                    ->label('Estado')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('autor')
                    ->label('Autor')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('categoria.nombre')
                    ->label('Categoría')
                    ->searchable()
                    ->sortable(),   

                TextColumn::make('created_at')
                    ->label('Creado el')
                    ->dateTime()
                    ->sortable()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                
                TextColumn::make('updated_at')
                    ->label('Actualizado el')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('estado')
                    ->label('Filtrar por estado')
                    ->options([
                        'registrada' => 'Registrada',
                        'en revisión' => 'En revisión',
                        'aprobada' => 'Aprobada',
                        'rechazada' => 'Rechazada',
                    ]),
                TrashedFilter::make()  // Filtro para mostrar solo los registros eliminados
            ])
            ->recordActions([
                ViewAction::make(),  // Se visualiza la opción.
                EditAction::make(),     // Se edita la opción.
                DeleteAction::make(),  // Se borra la opción.
                RestoreAction::make(),  // Se restaura la opción.
                ForceDeleteAction::make(),  // Se fuerza la eliminación de la opción.
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
