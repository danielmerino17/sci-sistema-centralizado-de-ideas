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
use Filament\Actions\Action;
use App\Models\Idea;
use Filament\Notifications\Notification;
use Filament\Forms\Components\Textarea;  // Práctica 23 de octubre de 2026.

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
                    ->wrap()
                    ->sortable(),

                TextColumn::make('descripcion')
                    ->label('Descripción')
                    ->searchable()
                    ->wrap()
                    ->sortable(),

                TextColumn::make('estado')
                    ->label('Estado')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('autor')
                    ->label('Autor')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('categoria.nombre')
                    ->label('Categoría')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),   

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

                // Borrado suave.
                RestoreAction::make(),  // Se restaura la opción.
                ForceDeleteAction::make(),  // Se fuerza la eliminación de la opción.
                
                // Clase 23 de octubre de 2026: Opción de aprobar.
                Action::make('aprobar')
                    ->label('Aprobar')
                    ->color('success')
                    ->requiresConfirmation()
                    ->modalHeading('¿Deseas aprobar esta idea?')
                    ->modalDescription('¿Deseas aprobar esta idea?')
                    ->action(function(Idea $record){
                        $record->update(['estado' => 'aprobada']);

                        Notification::make()
                            ->title('Idea aprobada correctamente')
                            ->success()
                            ->send();
                    })
                    ->visible(fn (Idea $record) => $record->estado != 'aprobada'), // Se corrigió la posición y se agregó la coma

                // Práctica 23 de octubre de 2026: Opción de rechazar.
                Action::make('rechazar')
                    ->label('Rechazar')
                    ->color('danger')
                    ->icon('heroicon-o-x-circle')
                    ->schema([
                        Textarea::make('observacion')
                            ->label('Motivo del rechazo')
                            ->required(),
                    ])
                    ->action(function (Idea $record, array $data): void {
                        $record->update([
                            'estado' => 'rechazada',
                            'observacion' => $data['observacion'],
                        ]);

                        Notification::make()
                            ->title('Idea rechazada correctamente')
                            ->success()
                            ->send();
                    })
                    ->visible(fn (Idea $record) => $record->estado != 'rechazada'),
                
            ])


            ->toolbarActions([
                BulkActionGroup::make([
                   // DeleteBulkAction::make(),
                ]),
            ]);
    }
}
