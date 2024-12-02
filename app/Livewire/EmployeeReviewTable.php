<?php

namespace App\Livewire;

use Livewire\Component;

use App\Models\TempEmp;
use App\Models\Establishment;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Filament\Actions\CreateAction;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\DeleteAction;
use Filament\Forms;  

class EmployeeReviewTable extends Component implements HasForms,HasTable
{
    use InteractsWithTable;
    use InteractsWithForms;

    public function table(Table $table): Table
    {
        
        return $table
            ->query(TempEmp::query()->where('emp_estabId', Auth::user()->est_id))
            ->columns([
                TextColumn::make('emp_lastName')
                    ->label('Last Name'),
                TextColumn::make('emp_firstName')
                    ->label('First Name'),
                TextColumn::make('emp_middleName')
                    ->label('Middle Name'),
            ])
            ->emptyStateHeading('Empty')
            ->emptyStateDescription('Add a new Record')
            ->emptyStateIcon('heroicon-o-bookmark')
            ->filters([
                // ...
            ])
            ->actions([
                DeleteAction::make()
            ])
            ->bulkActions([
                // ...
            ]);
    }
    public function render()
    {
        return view('livewire.employee-review-table');
    }
}
