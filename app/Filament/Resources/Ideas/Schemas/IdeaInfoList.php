<?php

namespace App\Filament\Resources\Ideas\Schemas;

use Filament\InfoLists\Components\TextEntry;
use Filament\Schemas\Schema;

class IdeaInfoList
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('título')
                    ->label('Título de la idea'),
            ]);
    }
}