<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\PostResource\Pages;
use Illuminate\Support\Facades\Storage;

use App\Filament\Admin\Resources\PostResource\RelationManagers;
use App\Filament\Admin\Resources\PostResource\RelationManagers\CommentsRelationManager;
use App\Filament\Admin\Resources\PostResource\Widgets\PostPerMonthChart;
use App\Filament\Admin\Resources\UserResource\Widgets\UserStatsWidget;
use App\Filament\Admin\Widgets\BlogPostsChart_2;
use App\Models\Post;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;
use Filament\Forms\Components\RichEditor;
use FilamentTiptapEditor\TiptapEditor;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\CheckboxColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;


class PostResource extends Resource
{
    protected static ?string $model = Post::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Main Content')->schema(
                    [
                        TextInput::make('title')->
                required()->minLength(1)->maxLength(150)
                ->afterStateUpdated(function(string $operation, $state, Forms\Set $set) {
                    if($operation === 'edit') {
                        return;
                    }
                    $set('slug', Str::slug($state));
                }),
                TextInput::make('slug')->required()->minLength(1)->unique(ignoreRecord:true)->maxLength(150),
                TiptapEditor::make('body')
                ->required()
                ->directory('posts/media')  // This defines the S3 folder where images will be saved
                ->disk('s3')  // Save to S3
                ->columnSpanFull()
                ->afterStateUpdated(function ($state) {
                    // Ensure the S3 URL is used correctly when displaying in the editor
            
                    // If you need to manipulate the image URL or ensure it's correct, do it here.
                    if ($state) {
                        // Manually generate the full URL from S3, without prepending your domain.
                        $url = Storage::disk('s3')->url($state);
                        return $url;
                    }
                    return $state; // If there's no state, return the original
                }),
                ->columnSpanFull(),
                    ]
                )->columns(2),
                Section::make('Meta')->schema(
                    [
                        FileUpload::make('image')->required()->disk('s3'),
                        DateTimePicker::make('published_at')->default(Carbon::now()),
                        Checkbox::make('featured'),
                        Select::make('user_id')->relationship('author', 'name')
                        ->searchable()
                        ->required(),
                        Select::make('categories')
                        ->multiple()
                        ->relationship('categories', 'title')
                        ->searchable()
                    ]
                    ),

            ]);


    }



    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image')
    ->getStateUsing(function ($record) {
        $path = $record->image;

        if ($path && Storage::disk('s3')->exists($path)) {
            return Storage::disk('s3')->url($path);
        }

        // Use your S3 fallback image
        return 'https://blog-bucket-laravel.s3.amazonaws.com/argentina.png';
    }),
                TextColumn::make('title')->sortable()->searchable(),
                TextColumn::make('slug')->sortable()->searchable(),
                TextColumn::make('author.name')->sortable()->searchable(),
                TextColumn::make('published_at')->date('Y-m-d')->sortable()->searchable(),
                CheckboxColumn::make('featured')
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    //Tables\Actions\BulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            CommentsRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPosts::route('/'),
            'create' => Pages\CreatePost::route('/create'),
            'edit' => Pages\EditPost::route('/{record}/edit'),
        ];
    }

    public static function getWidgets(): array {
        return[
           PostPerMonthChart::class
        ];
    }
}
