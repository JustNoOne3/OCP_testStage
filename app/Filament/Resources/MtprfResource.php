<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MtprfResource\Pages;
use App\Filament\Resources\MtprfResource\RelationManagers;
use App\Models\Mtprf;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MtprfResource extends Resource
{
    protected static ?string $model = Mtprf::class;

    protected static ?string $navigationIcon = 'heroicon-o-video-camera';

    protected static ?string $modelLabel = 'EGL Report';

    protected static ?string $pluralModelLabel = 'EGL Report';

    protected static ?string $navigationLabel = 'Eddie Garcia Law';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('mtprf_companyName')
                    ->maxLength(255),
                Forms\Components\TextInput::make('mtprf_companyType')
                    ->maxLength(255),
                Forms\Components\TextInput::make('mtprf_director')
                    ->maxLength(255),
                Forms\Components\TextInput::make('mtprf_address')
                    ->maxLength(255),
                Forms\Components\TextInput::make('mtprf_representativeOwner')
                    ->maxLength(255),
                Forms\Components\TextInput::make('mtprf_email')
                    ->email()
                    ->maxLength(255),
                Forms\Components\TextInput::make('mtprf_number')
                    ->maxLength(255),
                Forms\Components\TextInput::make('mtprf_movieName')
                    ->maxLength(255),
                Forms\Components\TextInput::make('mtprf_productionManager')
                    ->maxLength(255),
                Forms\Components\TextInput::make('mtprf_pmEmail')
                    ->maxLength(255),
                Forms\Components\TextInput::make('mtprf_pmContactNum')
                    ->maxLength(255),
                Forms\Components\TextInput::make('mtprf_projectDuration')
                    ->maxLength(255),
                Forms\Components\TextInput::make('mtprf_numDays')
                    ->maxLength(255),
                Forms\Components\TextInput::make('mtprf_15male')
                    ->maxLength(255),
                Forms\Components\TextInput::make('mtprf_15female')
                    ->maxLength(255),
                Forms\Components\TextInput::make(' mtprf_18male')
                    ->maxLength(255),
                Forms\Components\TextInput::make('mtprf_18female')
                    ->maxLength(255),
                Forms\Components\TextInput::make('mtprf_19male')
                    ->maxLength(255),
                Forms\Components\TextInput::make('mtprf_19female')
                    ->maxLength(255),
                Forms\Components\TextInput::make('mtprf_60male')
                    ->maxLength(255),
                Forms\Components\TextInput::make('mtprf_60female')
                    ->maxLength(255),
                Forms\Components\TextInput::make('mtprf_total')
                    ->maxLength(255),
                Forms\Components\TextInput::make('mtprf_childPermit')
                    ->maxLength(255),
                Forms\Components\TextInput::make('mtprf_contractorWorker')
                    ->maxLength(255),
                Forms\Components\TextInput::make('mtprf_independentContractor')
                    ->maxLength(255),
                Forms\Components\TextInput::make('mtprf_safetyOfficer')
                    ->maxLength(255),
                Forms\Components\TextInput::make('mtprf_safetyOfficer_contact')
                    ->maxLength(255),
                Forms\Components\TextInput::make('mtprf_firstAide')
                    ->maxLength(255),
                Forms\Components\TextInput::make('mtprf_firstAide_contact')
                    ->maxLength(255),
                Forms\Components\TextInput::make('mtprf_safeHealthCommittee')
                    ->maxLength(255),
                Forms\Components\TextInput::make('mtprf_safeHealthCommittee_contact')
                    ->maxLength(255),
                Forms\Components\TextInput::make('mtprf_hospitalMoa')
                    ->maxLength(255),
                Forms\Components\TextInput::make('mtprf_hospitalMoa_contact')
                    ->maxLength(255),
                Forms\Components\TextInput::make('mtprf_safetyProgram')
                    ->maxLength(255),
                Forms\Components\TextInput::make('mtprf_permits')
                    ->maxLength(255),
                Forms\Components\TextInput::make('mtprf_riskClass')
                    ->maxLength(255),
                Forms\Components\TextInput::make('mtprf_firearms')
                    ->maxLength(255),
                Forms\Components\TextInput::make('mtprf_actionPlan')
                    ->maxLength(255),
                Forms\Components\TextInput::make('mtprf_animalHandling')
                    ->maxLength(255),
                Forms\Components\TextInput::make('mtprf_emergencyTransport')
                    ->maxLength(255),
                Forms\Components\TextInput::make('mtprf_others')
                    ->maxLength(255),
                Forms\Components\TextInput::make('mtprf_decorumCommitee')
                    ->maxLength(255),
                Forms\Components\TextInput::make('mtprf_representative')
                    ->maxLength(255),
                Forms\Components\TextInput::make('mtprf_representativeAgent')
                    ->maxLength(255),
                Forms\Components\TextInput::make('mtprf_representativeSupervisor')
                    ->maxLength(255),
                Forms\Components\TextInput::make('mtprf_representativeRankFile')
                    ->maxLength(255),
                Forms\Components\TextInput::make('mtprf_policy_harrassment')
                    ->maxLength(255),
                Forms\Components\TextInput::make('mtprf_policy_mentalHealth')
                    ->maxLength(255),
                Forms\Components\TextInput::make('mtprf_remarks')
                    ->maxLength(255),
                Forms\Components\TextInput::make('mtprf_gbv_affectedTotal')
                    ->maxLength(255),
                Forms\Components\TextInput::make('mtprf_gbv_affectedMale')
                    ->maxLength(255),
                Forms\Components\TextInput::make('mtprf_gbv_affectedFemale')
                    ->maxLength(255),
                Forms\Components\TextInput::make('mtprf_gbv_affectedLgbtq')
                    ->maxLength(255),
                Forms\Components\TextInput::make('mtprf_gbv_offenderTotal')
                    ->maxLength(255),
                Forms\Components\TextInput::make('mtprf_gbv_offenderMale')
                    ->maxLength(255),
                Forms\Components\TextInput::make('mtprf_gbv_offenderFemale')
                    ->maxLength(255),
                Forms\Components\TextInput::make('mtprf_gbv_offenderLgbtq')
                    ->maxLength(255),
                Forms\Components\TextInput::make('mtprf_preparedBy')
                    ->maxLength(255),
                Forms\Components\TextInput::make('mtprf_designation')
                    ->maxLength(255),
                Forms\Components\TextInput::make('mtprf_submissionDate')
                    ->maxLength(255),
                Forms\Components\TextInput::make('mtprf_estabId')
                    ->maxLength(255),
                Forms\Components\TextInput::make('mtprf_region')
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('mtprf_companyName')
                    ->searchable(),
                Tables\Columns\TextColumn::make('mtprf_companyType')
                    ->searchable(),
                Tables\Columns\TextColumn::make('mtprf_director')
                    ->searchable(),
                Tables\Columns\TextColumn::make('mtprf_address')
                    ->searchable(),
                Tables\Columns\TextColumn::make('mtprf_representativeOwner')
                    ->searchable(),
                Tables\Columns\TextColumn::make('mtprf_email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('mtprf_number')
                    ->searchable(),
                Tables\Columns\TextColumn::make('mtprf_movieName')
                    ->searchable(),
                Tables\Columns\TextColumn::make('mtprf_productionManager')
                    ->searchable(),
                Tables\Columns\TextColumn::make('mtprf_pmEmail')
                    ->searchable(),
                Tables\Columns\TextColumn::make('mtprf_pmContactNum')
                    ->searchable(),
                Tables\Columns\TextColumn::make('mtprf_projectDuration')
                    ->searchable(),
                Tables\Columns\TextColumn::make('mtprf_numDays')
                    ->searchable(),
                Tables\Columns\TextColumn::make('mtprf_15male')
                    ->searchable(),
                Tables\Columns\TextColumn::make('mtprf_15female')
                    ->searchable(),
                Tables\Columns\TextColumn::make(' mtprf_18male')
                    ->searchable(),
                Tables\Columns\TextColumn::make('mtprf_18female')
                    ->searchable(),
                Tables\Columns\TextColumn::make('mtprf_19male')
                    ->searchable(),
                Tables\Columns\TextColumn::make('mtprf_19female')
                    ->searchable(),
                Tables\Columns\TextColumn::make('mtprf_60male')
                    ->searchable(),
                Tables\Columns\TextColumn::make('mtprf_60female')
                    ->searchable(),
                Tables\Columns\TextColumn::make('mtprf_total')
                    ->searchable(),
                Tables\Columns\TextColumn::make('mtprf_childPermit')
                    ->searchable(),
                Tables\Columns\TextColumn::make('mtprf_contractorWorker')
                    ->searchable(),
                Tables\Columns\TextColumn::make('mtprf_independentContractor')
                    ->searchable(),
                Tables\Columns\TextColumn::make('mtprf_safetyOfficer')
                    ->searchable(),
                Tables\Columns\TextColumn::make('mtprf_safetyOfficer_contact')
                    ->searchable(),
                Tables\Columns\TextColumn::make('mtprf_firstAide')
                    ->searchable(),
                Tables\Columns\TextColumn::make('mtprf_firstAide_contact')
                    ->searchable(),
                Tables\Columns\TextColumn::make('mtprf_safeHealthCommittee')
                    ->searchable(),
                Tables\Columns\TextColumn::make('mtprf_safeHealthCommittee_contact')
                    ->searchable(),
                Tables\Columns\TextColumn::make('mtprf_hospitalMoa')
                    ->searchable(),
                Tables\Columns\TextColumn::make('mtprf_hospitalMoa_contact')
                    ->searchable(),
                Tables\Columns\TextColumn::make('mtprf_safetyProgram')
                    ->searchable(),
                Tables\Columns\TextColumn::make('mtprf_permits')
                    ->searchable(),
                Tables\Columns\TextColumn::make('mtprf_riskClass')
                    ->searchable(),
                Tables\Columns\TextColumn::make('mtprf_firearms')
                    ->searchable(),
                Tables\Columns\TextColumn::make('mtprf_actionPlan')
                    ->searchable(),
                Tables\Columns\TextColumn::make('mtprf_animalHandling')
                    ->searchable(),
                Tables\Columns\TextColumn::make('mtprf_emergencyTransport')
                    ->searchable(),
                Tables\Columns\TextColumn::make('mtprf_others')
                    ->searchable(),
                Tables\Columns\TextColumn::make('mtprf_decorumCommitee')
                    ->searchable(),
                Tables\Columns\TextColumn::make('mtprf_representative')
                    ->searchable(),
                Tables\Columns\TextColumn::make('mtprf_representativeAgent')
                    ->searchable(),
                Tables\Columns\TextColumn::make('mtprf_representativeSupervisor')
                    ->searchable(),
                Tables\Columns\TextColumn::make('mtprf_representativeRankFile')
                    ->searchable(),
                Tables\Columns\TextColumn::make('mtprf_policy_harrassment')
                    ->searchable(),
                Tables\Columns\TextColumn::make('mtprf_policy_mentalHealth')
                    ->searchable(),
                Tables\Columns\TextColumn::make('mtprf_remarks')
                    ->searchable(),
                Tables\Columns\TextColumn::make('mtprf_gbv_affectedTotal')
                    ->searchable(),
                Tables\Columns\TextColumn::make('mtprf_gbv_affectedMale')
                    ->searchable(),
                Tables\Columns\TextColumn::make('mtprf_gbv_affectedFemale')
                    ->searchable(),
                Tables\Columns\TextColumn::make('mtprf_gbv_affectedLgbtq')
                    ->searchable(),
                Tables\Columns\TextColumn::make('mtprf_gbv_offenderTotal')
                    ->searchable(),
                Tables\Columns\TextColumn::make('mtprf_gbv_offenderMale')
                    ->searchable(),
                Tables\Columns\TextColumn::make('mtprf_gbv_offenderFemale')
                    ->searchable(),
                Tables\Columns\TextColumn::make('mtprf_gbv_offenderLgbtq')
                    ->searchable(),
                Tables\Columns\TextColumn::make('mtprf_preparedBy')
                    ->searchable(),
                Tables\Columns\TextColumn::make('mtprf_designation')
                    ->searchable(),
                Tables\Columns\TextColumn::make('mtprf_submissionDate')
                    ->searchable(),
                Tables\Columns\TextColumn::make('mtprf_estabId')
                    ->searchable(),
                Tables\Columns\TextColumn::make('mtprf_region')
                    ->searchable(),
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
            'index' => Pages\ListMtprves::route('/'),
            'create' => Pages\CreateMtprf::route('/create'),
            'edit' => Pages\EditMtprf::route('/{record}/edit'),
        ];
    }
}
