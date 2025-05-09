<?php

namespace App\Filament\Admin\Resources\PostResource\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\Post;
use Filament\Widgets\LineChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;
use Filament\Widgets\Concerns\InteractsWithPageTable;
use App\Filament\Admin\Resources\PostResource\Pages\ListPosts;
use Filament\Widgets\Widget;


class PostPerMonthChart extends LineChartWidget
{

    use InteractsWithPageTable;
    protected static ?string $heading = 'Chart';

    protected function getTablePage(): string {
        return ListPosts::class;
    }


    protected int | string | array $columnSpan = 'full';



    protected function getData(): array
    {

        $data = Trend::model(Post::class)
            ->between(
                start: now()->startOfYear(),
                end: now()->endOfYear(),
            )
            ->perMonth()
            ->dateColumn('published_at')
            ->count();

        return [
            'datasets' => [
                [
                    'label' => 'Blog posts',
                    'data' => $data->map(fn (TrendValue $value) => $value->aggregate),
                ],
            ],
            'labels' => $data->map(fn (TrendValue $value) => $value->date),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}

