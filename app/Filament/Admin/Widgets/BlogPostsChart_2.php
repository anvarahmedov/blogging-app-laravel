<?php

namespace App\Filament\Admin\Widgets;

use Filament\Widgets\ChartWidget;
use Flowframe\Trend\TrendValue;
use App\Models\Post;
use Flowframe\Trend\Trend;

//class BlogPostsChart_2 extends ChartWidget
//{
   // protected static ?string $heading = 'Chart';

//    protected function getData(): array
   // {
  //      $data = Trend::model(Post::class)
  //      ->between(
   //         start: now()->startOfYear(),
   //         end: now()->endOfYear(),
   //     )
   //     ->perMonth()
   //     ->count();

  //  return [
  //      'datasets' => [
   //         [
     //           'label' => 'Blog posts',
      //          'data' => $data->map(fn (TrendValue $value) => $value->aggregate),
     //       ],
  //      ],
 //       'labels' => $data->map(fn (TrendValue $value) => $value->date),
   // ];
  //  }

  //  protected function getType(): string
  //  {
  //      return 'line';
  //  }
//}
