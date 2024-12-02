<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TavSubmissionResource\Pages;
use App\Filament\Resources\TavSubmissionResource\RelationManagers;
use App\Models\TavSubmission;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TavSubmissionResource extends Resource
{
    protected static ?string $model = TavSubmission::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-storefront';

    protected static ?string $modelLabel = 'TAV Submissions';

    protected static ?string $pluralModelLabel = 'TAV Submission';

    protected static ?string $navigationLabel = 'TAV Form Submissions';
    
    protected static ?string $navigationGroup = 'Submissions';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Forms\Components\TextInput::make('tavSubmit_type')
                //     ->maxLength(255),
                // Forms\Components\TextInput::make('tavSubmit_file')
                //     ->maxLength(255),
                // Forms\Components\TextInput::make('tavSubmit_status')
                //     ->maxLength(255),
                // Forms\Components\TextInput::make('tavSubmit_region')
                //     ->maxLength(255),
                // Forms\Components\TextInput::make('tavSubmit_user')
                //     ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('tavSubmit_type')
                    ->label('Type of Report')
                    ->searchable(),
                Tables\Columns\TextColumn::make('tavSubmit_file')
                    ->label("Report Title")
                    ->searchable(),
                Tables\Columns\TextColumn::make('tavSubmit_status')
                    ->label('Status')
                    ->hidden()
                    ->searchable(),
                Tables\Columns\TextColumn::make('tavSubmit_region')
                    ->label('Originating Region')
                    ->searchable(),
                Tables\Columns\TextColumn::make('tavSubmit_user')
                    ->label('Submitted by')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
            'index' => Pages\ListTavSubmissions::route('/'),
            'create' => Pages\CreateTavSubmission::route('/create'),
            'edit' => Pages\EditTavSubmission::route('/{record}/edit'),
        ];
    }
}
