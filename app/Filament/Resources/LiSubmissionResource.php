<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LiSubmissionResource\Pages;
use App\Filament\Resources\LiSubmissionResource\RelationManagers;
use App\Models\LiSubmission;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class LiSubmissionResource extends Resource
{
    protected static ?string $model = LiSubmission::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-storefront';

    protected static ?string $modelLabel = 'LI Submissions';

    protected static ?string $pluralModelLabel = 'LI Submission';

    protected static ?string $navigationLabel = 'LI Form Submissions';

    protected static ?string $navigationGroup = 'Submissions';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('liSubmit_type')
                    ->maxLength(255),
                Forms\Components\TextInput::make('liSubmit_file')
                    ->maxLength(255),
                Forms\Components\TextInput::make('liSubmit_status')
                    ->maxLength(255),
                Forms\Components\TextInput::make('liSubmit_region')
                    ->maxLength(255),
                Forms\Components\TextInput::make('liSubmit_user')
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('liSubmit_type')
                    ->label('Type of Report')
                    ->searchable(),
                Tables\Columns\TextColumn::make('liSubmit_file')
                    ->label("Report Title")
                    ->searchable(),
                Tables\Columns\TextColumn::make('liSubmit_status')
                    ->label('Status')
                    ->searchable(),
                Tables\Columns\TextColumn::make('liSubmit_region')
                    ->label('Originating Region')
                    ->searchable(),
                Tables\Columns\TextColumn::make('liSubmit_user')
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
            'index' => Pages\ListLiSubmissions::route('/'),
            'create' => Pages\CreateLiSubmission::route('/create'),
            'edit' => Pages\EditLiSubmission::route('/{record}/edit'),
        ];
    }
}
