<?php

namespace App\Filament\Resources\Materials\Schemas;

use Filament\Schemas\Schema;
use Filament\Infolists\Components\TextEntry;

class MaterialInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            TextEntry::make('name')
                ->label(' name'),

            TextEntry::make('price')
                ->label('price'),

            TextEntry::make('status')
                ->label('status'),

            TextEntry::make('created_at')
                ->label('created at ')
                ->date(),
        ]);
    }
}
