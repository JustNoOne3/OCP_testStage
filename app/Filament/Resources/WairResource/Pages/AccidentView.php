<?php

namespace App\Filament\Resources\WairResource\Pages;

use App\Filament\Resources\WairResource;
use Filament\Resources\Pages\Page;
use Filament\Infolists\Infolist;
use Filament\Infolists\Components\TextEntry;
use Filament\Forms\Components\Section;

class AccidentView extends Page
{
    protected static string $resource = WairResource::class;

    protected static string $view = 'filament.resources.wair-resource.pages.accident-view';

    public function infolist(Infolist $infolist): Infolist
    {
        $this->record = Establishment::query()->where('est_id', Auth::user()->est_id)->first();
        return $infolist
            ->record($this->record)
        ->schema([
            
                Section::make()
                    ->schema([
                        TextEntry::make('ar_owner')
                            // ->required()
                            ->label("Name of Owner"),
                        TextEntry::make('ar_nationality')
                            // ->required()
                            ->label("Nationality of Owner"),
                        ]),
                
                Section::make('Accident Report')
                    ->columns(2)
                    ->schema([
                        TextEntry::make('ar_dateTime')
                            ->label("Date and Time of Accident"),
                        TextEntry::make('ar_injury')
                            ->label("Personal Injury"),
                        TextEntry::make('ar_damage')
                            ->label("Property Damage"),
                        Textarea::make('ar_description')
                            ->label("Description of Accident"),
                        TextEntry::make('ar_wasInjured')
                            ->label("Was injured doing regular part of job at time of accident?"),
                        TextEntry::make('ar_ntInjuredReason')
                            ->label("If not, why?"),
                        TextEntry::make('ar_agencyInvolved')
                            ->label("The Agency Involved "),
                        TextEntry::make('ar_agencyPart')
                            ->label("The Agency Part Involved "),
                        TextEntry::make('ar_accidentType')
                            ->label("Accident Type"),
                        TextEntry::make('ar_condition')
                            ->label("Unsafe Mechanical or Physical Condition"),
                        TextEntry::make('ar_unsafeAct')
                            ->label("The Unsafe Act"),
                        TextEntry::make('ar_factor')
                            ->label("Contributing Factor"),
                        ]),
                Section::make('Preventive Measures')
                    ->columns(2)
                    ->schema([
                        TextEntry::make('ar_preventiveMeasure')
                            ->label("Preventive Measures (Taken or Recommended)"),
                        TextEntry::make('ar_safeguard')
                            ->label("Mechanical Guards, Personal Protective Equipment and other Safeguards"),
                            TextEntry::make('ar_useSafeguard')
                            ->label("Were all safeguards in use?"),
                        TextEntry::make('ar_ntSafeguardReason')
                            ->label("If not, why?"),
                        Section::make('Control Instituted')
                            ->columns(2)
                            ->schema([
                                TextEntry::make('ar_engineer')
                                    ->label("Engineering"),
                                TextEntry::make('ar_engineer_cost')
                                    ->label("Cost"),
                                TextEntry::make('ar_administrative')
                                    ->label("Administrative"),
                                TextEntry::make('ar_administrative_cost')
                                    ->label("Cost")
                                    ->integer()
                                    ->minValue(0)
                                    ->default(0),
                                TextEntry::make('ar_ppe')
                                    ->label("PPE")
                                    ->maxLength(255),
                                TextEntry::make('ar_ppe_cost')
                                    ->label("Cost"),
                            ]),
                    ]),
                Section::make('Affected Workers')
                    ->schema([
                        TextEntry::make('ar_workers')
                            ->label('Workers')
                    ]),
                Section::make('Manpower')
                    ->columns(4)
                    ->schema([
                        TextEntry::make('ar_compensation')
                            ->label("Compensation"),
                        TextEntry::make('ar_compensation_amount')
                            ->label("Compensation Amount"),
                        TextEntry::make('ar_medical')
                            ->label("Medical and Hospitalization"),
                        TextEntry::make('ar_burial')
                            ->label("Burial"),
                        TextEntry::make('ar_timeLostDay')
                            ->label("Time Lost on Day of injury"),
                        TextEntry::make('ar_timeLostDay_hours')
                            ->label("Hours:"),
                        TextEntry::make('ar_timeLostDay_mins')
                            ->label("Minutes:"),
                        TextEntry::make('ar_timeLostSubseq')
                            ->label("Time Lost on Subsequent Days"),
                        TextEntry::make('ar_timeLostSubseq_hours')
                            ->label("Hours:"),
                        TextEntry::make('ar_timeLostSubseq_mins')
                            ->label("Minutes:"),
                        TextEntry::make('ar_timeReducedOutput')
                            ->label("Time on light work or reduced output"),
                        TextEntry::make('ar_timeReducedOutput_days')
                            ->label("Days:"),
                        TextEntry::make('ar_timeReducedOutput_percent')
                            ->label("Percentage Output:"),
                    ]),
                Section::make('Machinery and Tools')
                    ->columns(2)
                    ->aside()
                    ->schema([
                        TextEntry::make('ar_machineryDamage')
                            ->label("Damage to Machinery and Tools (Describe)"),
                        TextEntry::make('ar_machineryDamage_repair')
                            ->label("Cost of Repair or Replacement"),
                        TextEntry::make('ar_machineryDamage_time')
                            ->label("Lost Production Time (in hours)"),
                        TextEntry::make('ar_machineryDamage_production')
                            ->label("Cost of Lost production time"),
                    ]),
                Section::make('Materials')
                    ->columns(2)
                    ->aside()
                    ->schema([
                        TextEntry::make('ar_materialDamage')
                            ->label("Damage to Materials (Describe)"),
                        TextEntry::make('ar_materialDamage_repair')
                            ->label("Cost of Repair or Replacement"),
                        TextEntry::make('ar_materialDamage_time')
                            ->label("Lost Production Time (in hours)"),
                        TextEntry::make('ar_materialDamage_production')
                            ->label("Cost of Lost production time"),
                    ]),
                Section::make('Equipment')
                    ->columns(2)
                    ->aside()
                    ->schema([
                        TextEntry::make('ar_equipmentDamage')
                            ->label("Damage to Equipment Tools (Describe)"),
                        TextEntry::make('ar_equipmentDamage_repair')
                            ->label("Cost of Repair or Replacement"),
                        TextEntry::make('ar_equipmentDamage_time')
                            ->label("Lost Production Time (in hours)"),
                        TextEntry::make('ar_equipmentDamage_production')
                            ->label("Cost of Lost production time"),
                    ]),
                Section::make()
                    ->schema([
                        TextEntry::make('ar_safetyOfficer')
                            ->label("OH Personnel / Safety Officer"),
                        Forms\Components\FileUpload::make('ar_safetyOfficer_id')
                            ->label("OH Personnel / Safety Officer ID "),
                        
                    ]),
                Section::make()
                    ->schema([
                        TextEntry::make('ar_employer')
                            ->label("Employer Name"),
                        Forms\Components\FileUpload::make('ar_employer_id')
                            ->label("Employer ID"),
                        
                    ])
                        
               
            
        ]);
    }
}
