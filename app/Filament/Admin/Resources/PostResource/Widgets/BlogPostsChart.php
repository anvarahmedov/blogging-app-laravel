<?php

namespace App\Filament\Admin\Resources\PostResource\Widgets;

use Filament\Widgets\ChartWidget;
use Flowframe\Trend\TrendValue;
use App\Models\Post;
use Flowframe\Trend\Trend;

class BlogPostsChart extends ChartWidget
{
    protected static ?string $heading = 'Chart';

    protected static ?string $minHeight = '500';



    protected function getData(): array
    {
        $data = Trend::model(Post::class)
        ->between(
            start: now()->startOfYear(),
            end: now()->endOfYear(),
        )
        ->perMonth()
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

  //  return [
   //     'datasets' => [
     //       [
    //            'label' => 'Blog posts',
    //            'data' => $data->map(fn (TrendValue $value) => $value->aggregate),
   //         ],
   //     ],
   //     'labels' => $data->map(fn (TrendValue $value) => $value->date),
  //  ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
