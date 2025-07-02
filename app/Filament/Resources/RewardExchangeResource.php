<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RewardExchangeResource\Pages;
use App\Filament\Resources\RewardExchangeResource\RelationManagers;
use App\Models\RewardExchange;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class RewardExchangeResource extends Resource
{
    protected static ?string $model = RewardExchange::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Select::make('user_id')
                ->relationship('user', 'name')
                ->searchable()
                ->required()
                ->label('User'),

            Forms\Components\Select::make('reward_id')
                ->relationship('reward', 'name')
                ->searchable()
                ->required()
                ->label('Reward'),

            Forms\Components\TextInput::make('points_used')
                ->numeric()
                ->required()
                ->label('Poin Digunakan'),

            Forms\Components\Select::make('status')
                ->options([
                    'pending' => 'Menunggu',
                    'approved' => 'Disetujui',
                    'rejected' => 'Ditolak',
                    'delivered' => 'Dikirim',
                ])
                ->required()
                ->label('Status'),

            Forms\Components\Textarea::make('notes')
                ->label('Catatan')
                ->rows(3),

            Forms\Components\DateTimePicker::make('exchanged_at')
                ->label('Tanggal Tukar')
                ->required(),
        ]);
    }


    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('User')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('reward.name')
                    ->label('Reward')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('points_used')
                    ->label('Poin Digunakan')
                    ->sortable(),

                Tables\Columns\BadgeColumn::make('status')
                    ->label('Status')
                    ->colors([
                        'pending' => 'warning',
                        'approved' => 'success',
                        'rejected' => 'danger',
                        'delivered' => 'info',
                    ])
                    ->formatStateUsing(fn(string $state) => match ($state) {
                        'pending' => 'Menunggu',
                        'approved' => 'Disetujui',
                        'rejected' => 'Ditolak',
                        'delivered' => 'Dikirim',
                        default => 'Tidak Diketahui',
                    })
                    ->sortable(),

                Tables\Columns\TextColumn::make('exchanged_at')
                    ->label('Tanggal Tukar')
                    ->dateTime()
                    ->sortable(),

                Tables\Columns\TextColumn::make('notes')
                    ->label('Catatan')
                    ->limit(20)
                    ->wrap(),
            ])
            ->filters([])
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
            'index' => Pages\ListRewardExchanges::route('/'),
            'create' => Pages\CreateRewardExchange::route('/create'),
            'edit' => Pages\EditRewardExchange::route('/{record}/edit'),
        ];
    }
}
