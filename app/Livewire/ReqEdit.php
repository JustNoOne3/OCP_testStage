<?php

namespace App\Livewire;

use Livewire\Component;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Illuminate\Contracts\View\View;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Components\Section;
use Filament\Forms;  
use Filament\Forms\Get;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Set;
use Closure;
use Filament\Forms\Components\Livewire;
use Filament\Notifications\Notification;
use Illuminate\Contracts\Support\Htmlable;
use Filament\Forms\Components\Textarea;
use App\Livewire\MtprfRepeater;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use App\Models\Request;
use App\Models\Establishment;



class ReqEdit extends Component implements HasForms
{
    use InteractsWithForms;

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill();
    }

    public function create(): void
    {
        $data = $this->form->getState();

        $uuid = Uuid::uuid4()->toString();
        $microseconds = substr(explode('.', microtime(true))[1], 0, 6);
        $uuid = 'req-' . substr($uuid, 0, 12) . '-' . $microseconds;

        $record = Establishment::query()->where('est_id', Auth::user()->est_id)->first();

        $req = Request::create([
            'id' => $uuid,
            'req_reportId' => $record->est_id,
            'req_reportType' => 'Establishment Details',
            'req_estabId' => $record->est_id,
            'req_estabName' => $record->est_name,
            'req_region'  => $record->region_id,
            'req_field' => $data['req_field'],
            'req_fieldNew'  => $data['req_fieldNew'],
            'req_reason'  => $data['req_reason'],
            'req_status'  => 'Pending',
        ]);
        
        Notification::make()
            ->title('Successfully Sent the Request!')
            ->icon('heroicon-o-document-text')
            ->iconColor('success')
            ->send();
        
        redirect('user');
    }

    public function render()
    {
        return view('livewire.req-edit');
    }

    public function form(Form $form): Form {
        return $form
            ->schema([
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
            ->statePath('data');
    }
}
