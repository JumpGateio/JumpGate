<?php

namespace App\Providers;

use Collective\Html\HtmlBuilder;
use Illuminate\Support\ServiceProvider;

class MacroServiceProvider extends ServiceProvider
{
    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function boot()
    {
        HtmlBuilder::macro('localTime', function ($utcTime, $formattedTime) {
            return '
<local-time datetime="' . $utcTime . '"
            month="short"
            day="numeric"
            year="numeric"
            hour="numeric"
            minute="numeric"
            time-zone-name="short"
>
  '. $formattedTime .'
</local-time>            
            ';
        });

        HtmlBuilder::macro('adminTile', function ($color, $textColor, $icon, $content, $subContent = null) {
            $iconHtml       = '<i class="' . $icon . '"></i>';
            $padding        = 'p-5';
            $subContentHtml = null;

            if (! starts_with($icon, 'fa')) {
                $iconHtml = '<img src="' . $icon . '" />';
            }

            if (! is_null($subContent)) {
                $padding        = 'px-5 pt-4 pb-5';
                $subContentHtml = '<p style="margin-bottom: -20px;">' . $subContent . '</p>';
            }

            $divClasses = [
                'tile',
                'tile-icon',
                $color,
                $textColor,
                $padding,
            ];

            return '
<div class="' . implode(' ', $divClasses) . '" style="min-height: 130px;">
  ' . $iconHtml . '
  <h4 class="tile-icon-title">' . $content . '</h4>
  ' . $subContentHtml . '
</div>
            ';
        });
    }
}
