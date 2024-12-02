<?php

namespace App\Filament\User\Widgets;

use Filament\Widgets\Widget;

class MiddleWid extends Widget
{
    protected static string $view = 'filament.user.widgets.middle-wid';

    protected static ?int $sort = 3;

    protected int | string | array $columnSpan = 'full';
}
