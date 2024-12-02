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
                ->label('Rule 1020')
                ->hidden(function(){
                    $est = Establishment::query()->where('est_id', Auth::user()->est_id)->first();
                    // if($est){
                    //     if($est->est_certIssuance){
                    //         return false;
                    //     }else{
                    //         return true;
                    //     }
                    // }else{
                    //     return true;
                    // }
                    
                })
                ->icon('heroicon-s-document-text')
                ->button()
                ->color('secondary')
                ->action(function(){
                    session()->put('est_id', Auth::user()->est_id);
                    return redirect()->route('user-certificate');
                }),
            Actions\Action::make('request')
                ->label('Request for Edit')
                ->icon('heroicon-o-chevron-double-right')
                ->color('danger')
                ->modalSubmitActionLabel('Request')
                ->form([
                    Section::make()
                        ->columns(2)
                        ->schema([
                            Forms\Components\TextInput::make('req_field')
                                ->required()
                                ->columnSpan(1)
                                ->label("Field to Edit")
                                ->maxLength(255),
                            Forms\Components\TextInput::make('req_fieldNew')
                                ->required()
                                ->columnSpan(1)
                                ->label("Replace With")
                                ->maxLength(255),
                            ]),
                    Section::make()
                        ->schema([
                            Forms\Components\Textarea::make('req_reason')
                                ->required()
                                ->columnSpan(2)
                                ->label("Reason for Editing")
                                ->maxLength(255),
                            ]),                            
                ])
                ->action(function (array $data) {
                    $uuid = Uuid::uuid4()->toString();
                    $microseconds = substr(explode('.', microtime(true))[1], 0, 6);
                    $uuid = 'req-' . substr($uuid, 0, 12) . '-' . $microseconds;

                    $record = Establishment::query()->where('est_id', Auth::user()->est_id)->first();

                    $req = Request::create([
                        'id' => $uuid,
                        'req_reportId' => $record->id,
                        'req_reportType' => 'Establishment Details',
                        'req_estabId' => $record->est_id,
                        'req_estabName' => $record->est_name,
                        'req_region'  => $record->region_id,
                        'req_field' => $data['req_field'],
                        'req_fieldNew'  => $data['req_fieldNew'],
                        'req_reason'  => $data['req_reason'],
                        'req_status'  => 'Pending',
                    ]);
                    return 
                        Notification::make()
                            ->title('Successfully Sent the Request!')
                            ->icon('heroicon-o-document-text')
                            ->iconColor('success')
                            ->send();
                }),
            
            // Actions\EditAction::make('edit')
            //     ->label('Edit Details')
            //     ->icon('heroicon-s-pencil-square')
            //     ->button()
            //     ->color('warning'),
        ];
    }

    public static function getPages(): array
    {
        return [
            'edit' => Pages\EditEstablishment::route('/{record}/edit'),
        ];
    }

}
