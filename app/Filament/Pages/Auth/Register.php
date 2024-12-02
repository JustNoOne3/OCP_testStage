<?php
 
namespace App\Filament\Pages\Auth;

use App\Models\Geocode;
use App\Models\Establishment;
use Filament\Forms;  
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Pages\Auth\Register as RegisterPage;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Components\Section;
use Filament\Forms\Get;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Checkbox;

 
class Register extends RegisterPage
{
    protected ?string $maxWidth = '5xl';

    public function mount(): void
    {
        parent::mount();

    }
    
    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()
                    ->schema([
                        Select::make('location')
                            ->required()
                            ->label('Select Region')
                            ->columnSpan(2)
                            ->native(false)
                            ->options([
                                'NCR' => 'National Capital Region (NCR)',
                                'CAR' => 'Cordillera Administrative Region (CAR)',
                                'RO1' => 'Region I (Ilocos Region)',
                                'RO2' => 'Region II (Cagayan Valley)',
                                'RO3' => 'Region III (Central Luzon)',
                                'RO4A' => 'Region IV-A (CALABARZON)',
                                'RO4B' => 'MIMAROPA Region',
                                'RO5' => 'Region V (Bicol Region)',
                                'RO6' => 'Region VI (Western Visayas)',
                                'NIR' => 'Negros Island Region (NIR)',
                                'RO7' => 'Region VII (Central Visayas)',
                                'RO8' => 'Region VIII (Eastern Visayas)',
                                'RO9' => 'Region IX (Zamboanga Peninsula)',
                                'RO10' => 'Region X (Northern Mindanao)',
                                'RO11' => 'Region XI (Davao Region)',
                                'RO12' => 'Region XII (SOCCSKSARGEN)',
                                'RO13' => 'Region XIII (Caraga)',
                                'BARMM' => 'Bangsamoro Autonomous Region in Muslim Mindanao (BARMM)',
                            ]),
                    ]),
                Section::make()
                    ->columns(2)
                    ->schema([
                        TextInput::make('firstname')
                            ->required()
                            ->maxLength(255)
                            ->label('First Name'),
                        TextInput::make('lastname')
                            ->required()
                            ->maxLength(255)
                            ->label('Last Name'),
                            ]),
                Section::make()
                    ->schema([
                        $this->getEmailFormComponent(),
                    ]),
                Section::make()
                    ->columns(2)
                    ->schema([
                        $this->getPasswordFormComponent(),
                        $this->getPasswordConfirmationFormComponent(),
                    ]),
                Section::make()
                    ->schema([
                        Checkbox::make('terms')
                            ->label('By registering for an account, you consent to our collection, use, and disclosure of your personal information as described in our Privacy Policy. You also agree to abide by our Terms of Service, which outline the rules and regulations governing your use of our website and services.')
                            ->accepted()
                    ])
            ]);
                
    }

}