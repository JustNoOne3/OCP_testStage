<?php

namespace App\Livewire;

use Livewire\Component;

use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Infolists\Concerns\InteractsWithInfolists;
use Filament\Infolists\Contracts\HasInfolists;
use Filament\Infolists\Infolist;
use Illuminate\Support\Facades\Auth;
use App\Models\Establishment;
use App\Models\TeleReportHead;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\Grid;

class TeleHeadInfolist extends Component implements HasForms, HasInfolists
{
    use InteractsWithInfolists;
    use InteractsWithForms;

    public function render()
    {
        return view('livewire.tele-head-infolist');
    }

    public function teleHeadInfolist(Infolist $infolist): Infolist
    {
        $ciphering = "AES-128-CTR";
        $iv_length = openssl_cipher_iv_length($ciphering);
        $options = 0;
        $decryption_iv = '1234567891011121';
        $decryption_key = "FkSeGoYe6KI8OAd";
        
        $reportId=openssl_decrypt (session()->get('estabId'), $ciphering, 
            $decryption_key, $options, $decryption_iv);

        $this->record = TeleReportHead::query()->where('id', $reportId)->first();

        return $infolist
            ->record($this->record)
            ->schema([
                Grid::make(2)
                    ->schema([
                        Section::make()
                            ->schema([
                                TextEntry::make('teleHead_estabId')
                                    ->label('Name of Establishment')
                                    ->color('warning')
                                    ->formatStateUsing(fn (string $state): string => (Establishment::query()->where('est_id', $state)->value('est_name'))),
                            ]),
                        Section::make('Worker\'s Covered')
                            ->columnSpan(1)
                            ->columns(2)
                            ->schema([
                                Section::make('Managerial Employees')
                                    ->columns(2)
                                    ->schema([
                                        TextEntry::make('teleHead_manageMale')
                                            ->color('warning')
                                            ->label("Male"),
                                        TextEntry::make('teleHead_manageFemale')
                                            ->color('warning')
                                            ->label("Female"),
                                    ]),
                                Section::make('Supervisory')
                                    ->columns(2)
                                    ->schema([
                                        TextEntry::make('teleHead_superMale')
                                            ->color('warning')
                                            ->label("Male"),
                                        TextEntry::make('teleHead_superFemale')
                                            ->color('warning')
                                            ->label("Female"),
                                    ]),
                                Section::make('Rank and File')
                                    ->columns(2)
                                    ->schema([
                                        TextEntry::make('teleHead_rankMale')
                                            ->color('warning')
                                            ->label("Male"),
                                        TextEntry::make('teleHead_rankFemale')
                                            ->color('warning')
                                            ->label("Female"),
                                    ]),
                                TextEntry::make('teleHead_total')
                                    ->color('warning')
                                    ->label('Total'),
                            ]),
                        Section::make('Special Group of Workers Covered')
                            ->columnSpan(1)
                            ->columns(2)
                            ->schema([
                                Section::make('Persons with Disability')
                                    ->columns(2)
                                    ->schema([
                                        TextEntry::make('teleHead_disabMale')
                                            ->color('warning')
                                            ->label("Male"),
                                        TextEntry::make('teleHead_disabFemale')
                                            ->color('warning')
                                            ->label("Female"),
                                    ]),
                                Section::make('Solo Parent')
                                    ->columns(2)
                                    ->schema([
                                        TextEntry::make('teleHead_soloperMale')
                                            ->color('warning')
                                            ->label("Male"),
                                        TextEntry::make('teleHead_soloperFemale')
                                            ->color('warning')
                                            ->label("Female"),
                                    ]),
                                Section::make('Immunocompromised ')
                                    ->columns(2)
                                    ->schema([
                                        TextEntry::make('teleHead_immunoMale')
                                            ->color('warning')
                                            ->label("Male"),
                                        TextEntry::make('teleHead_immunoFemale')
                                            ->color('warning')
                                            ->label("Female"),
                                    ]),
                                Section::make('With Mental Health Condition')
                                    ->columns(2)
                                    ->schema([
                                        TextEntry::make('teleHead_mentalMale')
                                            ->color('warning')
                                            ->label("Male"),
                                        TextEntry::make('teleHead_mentalFemale')
                                            ->color('warning')
                                            ->label("Female"),
                                    ]),
                                Section::make('Senior Citizen')
                                    ->columns(2)
                                    ->schema([
                                        TextEntry::make('teleHead_seniorMale')
                                            ->color('warning')
                                            ->label("Male"),
                                        TextEntry::make('teleHead_seniorFemale')
                                            ->color('warning')
                                            ->label("Female"),
                                    ]),
                            ]),
                        
                        Section::make('Telecommuting Workplace')
                            ->schema([
                                TextEntry::make('teleHead_workspace')
                                    ->color('warning')
                                    ->label('Select Alternative Workplace'),
                                TextEntry::make('teleHead_workspace_others')
                                    ->color('warning')
                                    ->label('Please Specify'),
                            ]),
                        Section::make('Functional Areas Covered by the Telecommuting Program')
                            ->schema([
                                TextEntry::make('teleHead_areasCovered')
                                    ->color('warning')
                                    ->label('Select Covered Areas'),
                                TextEntry::make('teleHead_areasCovered_others')
                                    ->color('warning')
                                    ->label('Please Specify'),
                            ])

                    ])
            ]);
    }
}
