<?php

namespace App\Filament\Admin\Resources\ChoiceResource\Pages;

use App\Filament\Admin\Resources\ChoiceResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListChoices extends ListRecords
{
    protected static string $resource = ChoiceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
