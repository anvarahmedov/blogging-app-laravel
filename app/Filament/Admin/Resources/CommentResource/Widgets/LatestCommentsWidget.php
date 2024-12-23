<?php

namespace App\Filament\Admin\Resources\CommentResource\Widgets;

use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Model;
use Filament\Widgets\Concerns\InteractsWithPageTable;
use App\Models\Comment;
use Filament\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Actions\DeleteAction;
use Filament\Tables\Actions\BulkAction;
use Filament\Notifications\Collection;
use App\Filament\Admin\Resources\CommentResource;

class LatestCommentsWidget extends BaseWidget

{



    protected int | string | array $columnSpan = 'full';
   // use InteractsWithPageTable;
  //  public function getTablePage(): array {
   //     return [LatestCommentsWidget::class];
  //  }
    public function table(Table $table): Table
    {
        return $table
            ->query(
                Comment::whereDate('created_at', '>', now()->subDays(14)->startOfDay())
            )
            ->columns([
                TextColumn::make('user.name'),
                TextColumn::make('post.title'),
                TextColumn::make('content'),
                TextColumn::make('created_at')->date()->sortable(),
            ])->actions([
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\ViewAction::make('View')->url(fn (Comment $record): string => CommentResource::getUrl('edit', ['record' => $record]))->openUrlInNewTab()
            ]);
    }
}
