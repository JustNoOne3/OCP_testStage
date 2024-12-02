<?php

namespace App\Filament\BwcFocal\Resources;

use App\Filament\Resources\WairResource\Pages;
use App\Filament\Resources\WairResource\RelationManagers;
use App\Models\Wair;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

use App\Models\Establishment;
use Filament\Tables\Columns\TextColumn;

class WairResource extends Resource
{
    protected static ?string $model = Wair::class;

    protected static ?string $navigationIcon = 'heroicon-o-shield-exclamation';

    protected static ?string $modelLabel = 'Workplace Accident / Illness Report';

    protected static ?string $navigationLabel = 'Workplace Accident / Illness Reports';

    protected static ?string $navigationGroup = 'Reports';

    protected static bool $shouldRegisterNavigation = true;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->query(function() {
                if(Auth::user()->authority == '20'){
                    return Wair::query()->all();
                }else{
                    $est_array = Establishment::query()->where('region_id', Auth::user()->authority)->pluck('est_id');
                    return Wair::query()->whereIn($est_array);
                }
            })
            ->columns([
                TextColumn::make('wairs_reportType')
                    ->label('Report Type')
                    ->color(fn (string $state): string => match ($state) {
                        'No Incident of Illness or Accident Report' => 'success',
                        'Accident Report' => 'warning',
                        'Illness Report' => 'primary',
                        'Accident and Illness Report' => 'danger',
                    }),
                TextColumn::make('created_at')
                    ->label('Date of Submission'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateHeading('Empty')
            ->emptyStateDescription('There is no Report Data yet')
            ->emptyStateIcon('heroicon-o-bookmark');
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListWairs::route('/'),
            'create' => Pages\CreateWair::route('/create'),
            'edit' => Pages\EditWair::route('/{record}/edit'),
        ];
    }
}
