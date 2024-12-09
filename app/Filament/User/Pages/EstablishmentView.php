<?php

namespace App\Filament\User\Pages;

use Filament\Pages\Page;
use Filament\Actions;
use App\Models\Establishment;
use Illuminate\Support\Facades\Auth;

use App\Models\Request;
// use App\Models\Establishment;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\Section;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class EstablishmentView extends Page
{
    protected static ?string $navigationIcon = 'heroicon-s-building-office';

    protected static ?string $navigationLabel = 'My Establishment';

    protected ?string $heading = 'Establishment Information';

    protected static string $view = 'filament.user.pages.establishment-view';

    protected function getHeaderActions(): array {

        return [
            Actions\Action::make('acknowledge')
                ->label('View Certificate')
                ->hidden(function(){
                    $est = Establishment::query()->where('est_id', Auth::user()->est_id)->first();
                    
                })
                ->icon('heroicon-s-document-text')
                ->button()
                ->color('secondary')
                ->action(function(){
                    session()->put('est_id', Auth::user()->est_id);
                    return redirect()->route('user-certificate');
                }),
        ];
    }

    public static function getPages(): array
    {
        return [
            'edit' => Pages\EditEstablishment::route('/{record}/edit'),
        ];
    }

}
