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

     /**
     * Before saving the comment, ensure user_id is set to the authenticated user.
     *
     * @param  \Illuminate\Database\Eloquent\Model $record
     * @param  \Filament\Forms\Form $form
     * @return void
     */
    public function beforeSave($record, Form $form)
    {
        dd(auth()->id());
        // Check if user is authenticated
        if (auth()->check()) {
            // Set the user_id to the authenticated user
            $record->user_id = auth()->id();
        } else {
            // Handle case where the user is not authenticated
            throw new \Exception('User not authenticated');
        }
    }

}

