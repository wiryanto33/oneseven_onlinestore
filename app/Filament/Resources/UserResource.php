<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Filters\SelectFilter;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static ?int $navigationSort = 5;

    protected static ?string $navigationLabel = 'Users';

    protected static ?string $pluralModelLabel = 'Users';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Personal Information')
                    ->schema([
                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\TextInput::make('name')
                                    ->label('Full Name')
                                    ->required()
                                    ->maxLength(255)
                                    ->placeholder('Enter full name'),

                                Forms\Components\TextInput::make('email')
                                    ->label('Email Address')
                                    ->email()
                                    ->required()
                                    ->maxLength(255)
                                    ->placeholder('Enter email address')
                                    ->unique(ignoreRecord: true),
                            ]),

                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\TextInput::make('phone')
                                    ->label('Phone Number')
                                    ->tel()
                                    ->placeholder('Enter phone number'),

                                Forms\Components\FileUpload::make('photo')
                                    ->label('Profile Photo')
                                    ->image()
                                    ->avatar()
                                    ->imageEditor()
                                    ->circleCropper()
                                    ->directory('user-photos')
                                    ->maxSize(2048),
                            ]),
                    ])
                    ->columns(1),

                Forms\Components\Section::make('Account Settings')
                    ->schema([
                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\Select::make('member_type')
                                    ->label('Member Type')
                                    ->options([
                                        'distributor' => 'Distributor',
                                        'reseller' => 'Reseller',
                                        'stockist' => 'Stockist',
                                        'retailer' => 'Retailer',
                                        'agent' => 'Agent',
                                        'customer' => 'Customer',
                                    ])
                                    ->required()
                                    ->searchable()
                                    ->placeholder('Select member type'),

                                Forms\Components\TextInput::make('point')
                                    ->label('Points')
                                    ->numeric()
                                    ->default(0)
                                    ->minValue(0)
                                    ->placeholder('Enter points'),
                            ]),

                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\TextInput::make('password')
                                    ->label('Password')
                                    ->password()
                                    ->required(fn(string $context): bool => $context === 'create')
                                    ->minLength(8)
                                    ->placeholder('Enter password')
                                    ->dehydrated(fn($state) => filled($state))
                                    ->dehydrateStateUsing(fn($state) => bcrypt($state)),

                                Forms\Components\DateTimePicker::make('email_verified_at')
                                    ->label('Email Verified At')
                                    ->placeholder('Select verification date'),
                            ]),

                        Forms\Components\Toggle::make('is_admin')
                            ->label('Administrator')
                            ->helperText('Grant administrator privileges to this user')
                            ->default(false),
                    ])
                    ->columns(1),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('photo')
                    ->label('Photo')
                    ->circular()
                    ->defaultImageUrl(fn($record) => 'https://ui-avatars.com/api/?name=' . urlencode($record->name) . '&color=7F9CF5&background=EBF4FF'),

                Tables\Columns\TextColumn::make('name')
                    ->label('Name')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->icon('heroicon-m-envelope'),

                Tables\Columns\TextColumn::make('phone')
                    ->label('Phone')
                    ->searchable()
                    ->copyable()
                    ->icon('heroicon-m-phone')
                    ->placeholder('No phone'),

                Tables\Columns\BadgeColumn::make('member_type')
                    ->label('Member Type')
                    ->colors([
                        'danger' => 'distributor',
                        'warning' => 'reseller',
                        'success' => 'stockist',
                        'primary' => 'retailer',
                        'info' => 'agent',
                        'secondary' => 'customer',
                    ])
                    ->icons([
                        'heroicon-m-building-office' => 'distributor',
                        'heroicon-m-building-storefront' => 'reseller',
                        'heroicon-m-cube' => 'stockist',
                        'heroicon-m-shopping-bag' => 'retailer',
                        'heroicon-m-user-circle' => 'agent',
                        'heroicon-m-user' => 'customer',
                    ])
                    ->sortable(),

                Tables\Columns\TextColumn::make('point')
                    ->label('Points')
                    ->numeric()
                    ->sortable()
                    ->placeholder('0')
                    ->badge()
                    ->color('success'),

                Tables\Columns\IconColumn::make('is_admin')
                    ->label('Admin')
                    ->boolean()
                    ->trueIcon('heroicon-o-shield-check')
                    ->falseIcon('heroicon-o-shield-exclamation'),

                Tables\Columns\TextColumn::make('email_verified_at')
                    ->label('Verified')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->placeholder('Not verified'),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Updated')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('member_type')
                    ->label('Member Type')
                    ->options([
                        'distributor' => 'Distributor',
                        'reseller' => 'Reseller',
                        'stockist' => 'Stockist',
                        'retailer' => 'Retailer',
                        'agent' => 'Agent',
                        'customer' => 'Customer',
                    ])
                    ->multiple()
                    ->searchable(),

                SelectFilter::make('is_admin')
                    ->label('Admin Status')
                    ->options([
                        1 => 'Administrator',
                        0 => 'Regular User',
                    ]),

                Tables\Filters\Filter::make('verified')
                    ->query(fn(Builder $query): Builder => $query->whereNotNull('email_verified_at'))
                    ->label('Verified Users'),

                Tables\Filters\Filter::make('unverified')
                    ->query(fn(Builder $query): Builder => $query->whereNull('email_verified_at'))
                    ->label('Unverified Users'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\BulkAction::make('verify_email')
                        ->label('Verify Email')
                        ->icon('heroicon-m-check-badge')
                        ->action(fn($records) => $records->each(fn($record) => $record->update(['email_verified_at' => now()])))
                        ->requiresConfirmation()
                        ->color('success'),
                ]),
            ])
            ->defaultSort('created_at', 'desc')
            ->striped()
            ->paginated([10, 25, 50, 100]);
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'view' => Pages\ViewUser::route('/{record}'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function getGlobalSearchEloquentQuery(): Builder
    {
        return parent::getGlobalSearchEloquentQuery()->with(['roles']);
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['name', 'email', 'phone'];
    }
}
