<?php

namespace App\Filament\Resources\Materials\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class MaterialForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                //
                TextInput::make('name')->label(' name')->required(),
               
                TextInput::make('price')->label('price')->numeric()->nullable(),
                TextInput::make('quantity')->label('Quantity') ->numeric() ->minValue(0) ->default(0) ->required(),
                Select::make('status')->label('status')->options([
                    'available' => 'available',
                    'Unavailable ' => ' Unavailable',
                ])->default('available'),
 
            ]);
    }
}
