<?php

namespace App\Filament\User\Resources;

use App\Filament\User\Resources\RequestResource\Pages;
use App\Filament\User\Resources\RequestResource\RelationManagers;
use App\Models\Request;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Filters\SelectFilter;

use Filament\Forms\Components\Section;
use Illuminate\Support\Facades\Auth;
use Filament\Notifications\Notification;

class RequestResource extends Resource
{
    protected static ?string $model = Request::class;

    protected static ?string $navigationIcon = 'heroicon-o-ticket';

    protected static ?string $modelLabel = 'Request / Tickets';

    protected static ?string $navigationLabel = 'Request / Tickets';

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
            ->query(fn (Request $request) => $request
                    ->where('req_estabId', Auth::user()->est_id)
                )
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('Request ID')
                    ->searchable(),
                Tables\Columns\TextColumn::make('req_reportId')
                    ->label('Report ID')
                    ->searchable(),
                Tables\Columns\TextColumn::make('req_field')
                    ->label('Form Field')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                Tables\Columns\TextColumn::make('req_fieldNew')
                    ->label('Replace With?')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                Tables\Columns\TextColumn::make('req_reason')
                    ->label('Reason')
                    ->limit(70)
                    ->wrap()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                Tables\Columns\TextColumn::make('req_status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Pending' => 'danger',
                        'Resolved' => 'success',
                    })
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Request Date')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Date Updated')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('Status')
                    ->native(false)
                    ->options([
                        'Pending' => 'Pending',
                        'Resolved' => 'Resolved',
                    ])
                    ->attribute('req_status')
            ])
            ->actions([
                Tables\Actions\Action::make('view-req')
                    ->label('View')
                    ->icon('heroicon-o-eye')
                    ->color('primary')
                    ->modalSubmitActionLabel('Done')
                    ->modalCancelAction(false)
                    ->disabledForm()
                    ->fillForm(
                        function (Request $req): array {
                            return [
                                    'id' => $req->id,
                                    'req_reportId' => $req->req_reportId,
                                    'req_estabId' => $req->req_estabId,
                                    'req_estabName' => $req->req_estabName,
                                    'req_region' => $req->req_region,
                                    'req_field' => $req->req_field,
                                    'req_fieldNew' => $req->req_fieldNew,
                                    'req_reason' => $req->req_reason,
                            ];
                        }
                    )
                    ->form([
                        Section::make()
                            ->columns(2)
                            ->schema([
                                Forms\Components\TextInput::make('req_reportId')
                                    ->required()
                                    ->columnSpan(1)
                                    ->label("Report ID")
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('req_estabId')
                                    ->required()
                                    ->columnSpan(1)
                                    ->label("Establishment ID")
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('req_estabName')
                                    ->required()
                                    ->columnSpan(2)
                                    ->label("Establishment Name")
                                    ->maxLength(255),
                                ]),
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
                        Section::make('Resolution')
                            ->description('Comments and Recommendations')
                            ->schema([
                                Forms\Components\Textarea::make('req_resolution')
                                    ->rows(15)
                                    ->required()
                                    ->columnSpan(2)
                                    ->label(" ")
                                    ->maxLength(500)
                                    ->readOnly()
                                ]), 
                    ]),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
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
            'index' => Pages\ListRequests::route('/'),
        ];
    }
}
