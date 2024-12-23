<?php

namespace App\Filament\Resources\PostResource\Pages;

use App\Filament\Admin\Resources\PostResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Admin\Resources\PostResource\Widgets\PostPerMonthChart;
use App\Filament\Admin\Resources\PostResource\Widgets\BlogPostsChart;


class ListPosts extends ListRecords
{
    protected static string $resource = PostResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }


        protected function getHeaderWidgets(): array
    {
        return [
            PostPerMonthChart::class
        ];
    }
}
