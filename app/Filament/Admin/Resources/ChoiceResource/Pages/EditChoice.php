<?php

namespace App\Filament\Admin\Resources\ChoiceResource\Pages;

use App\Filament\Admin\Resources\ChoiceResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditChoice extends EditRecord
{
    protected static string $resource = ChoiceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
