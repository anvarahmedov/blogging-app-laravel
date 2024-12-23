<?php

namespace App\Filament\Admin\Resources\PostResource\Pages;
use App\Filament\Admin\Resources\PostResource;
use App\Filament\Admin\Resources\PostResource\Widgets\BlogPostsChart;
use App\Filament\Admin\Widgets\BlogPostsChart_2;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Admin\Resources\PostResource\Widgets\PostPerMonthChart;
use Filament\Pages\Concerns\ExposesTableToWidgets;

class ListPosts extends ListRecords
{
    use ExposesTableToWidgets;
    protected static string $resource = PostResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    protected function getFooterWidgets(): array
    {
        return [
            PostPerMonthChart::class
        ];
    }


}
