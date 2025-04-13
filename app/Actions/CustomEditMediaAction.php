<?php

namespace App\Filament\Tiptap;

use Filament\Forms\Components\TextInput;
use FilamentTiptapEditor\Actions\EditMediaAction;

class CustomEditMediaAction extends EditMediaAction
{
    public static function getModalFormSchema(): array
    {
        return [
            TextInput::make('src')
                ->label('Image URL')
                ->required()
                ->disabled(),

            TextInput::make('alt')
                ->label('Alt Text')
                ->maxLength(255),

            TextInput::make('title')
                ->label('Image Title')
                ->maxLength(255),
        ];
    }

    public static function mutateInsertData(array $data): array
    {
        return [
            'type' => 'image',
            'attrs' => [
                'src' => $data['src'],
                'alt' => $data['alt'] ?? '',
                'title' => $data['title'] ?? '',
            ],
        ];
    }
}