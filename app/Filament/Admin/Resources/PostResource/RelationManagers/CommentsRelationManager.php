<?php
namespace App\Filament\Admin\Resources\PostResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;

class CommentsRelationManager extends RelationManager
{
    protected static string $relationship = 'comments';

    public function form(Form $form): Form
    {
        return $form->schema([
            TextInput::make('content')
                ->required()
                ->maxLength(255),
            Select::make('user_id')
                ->relationship('user', 'name')
                ->searchable()
                ->preload()
                ->default(auth()->id()) // Set the default value of user_id to the current authenticated user's ID
                ->required()
                ->hidden(), // Always hide the user_id field
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('comment')
            ->columns([
                Tables\Columns\TextColumn::make('content'),
                TextColumn::make('user.name'),
            ])
            ->filters([
                // Add filters if needed
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([]);
    }

    public function beforeSave($record, Form $form)
    {
        // If the comment is being created, ensure that the user_id is set to the current user
        if (!$record->exists) {
            $record->user_id = auth()->id(); // Always set the user_id to the current authenticated user
        }
    }
}

