<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Filament\Infolists\Infolist;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\Grid;

class ViewUser extends ViewRecord
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
            Actions\DeleteAction::make(),
        ];
    }

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Section::make('Personal Information')
                    ->schema([
                        Grid::make(3)
                            ->schema([
                                ImageEntry::make('photo')
                                    ->label('Profile Photo')
                                    ->circular()
                                    ->defaultImageUrl(fn($record) => 'https://ui-avatars.com/api/?name=' . urlencode($record->name) . '&color=7F9CF5&background=EBF4FF'),

                                TextEntry::make('name')
                                    ->label('Full Name')
                                    ->weight('bold')
                                    ->size('lg'),

                                TextEntry::make('email')
                                    ->label('Email Address')
                                    ->icon('heroicon-m-envelope')
                                    ->copyable(),
                            ]),

                        Grid::make(2)
                            ->schema([
                                TextEntry::make('phone')
                                    ->label('Phone Number')
                                    ->icon('heroicon-m-phone')
                                    ->copyable()
                                    ->placeholder('No phone number'),

                                TextEntry::make('member_type')
                                    ->label('Member Type')
                                    ->badge()
                                    ->color(fn(string $state): string => match ($state) {
                                        'distributor' => 'danger',
                                        'reseller' => 'warning',
                                        'stockist' => 'success',
                                        'retailer' => 'primary',
                                        'agent' => 'info',
                                        'customer' => 'secondary',
                                        default => 'gray',
                                    }),
                            ]),
                    ])
                    ->columns(1),

                Section::make('Account Information')
                    ->schema([
                        Grid::make(3)
                            ->schema([
                                TextEntry::make('point')
                                    ->label('Points')
                                    ->badge()
                                    ->color('success')
                                    ->placeholder('0'),

                                IconEntry::make('is_admin')
                                    ->label('Administrator')
                                    ->boolean()
                                    ->trueIcon('heroicon-o-shield-check')
                                    ->falseIcon('heroicon-o-shield-exclamation')
                                    ->trueColor('success')
                                    ->falseColor('gray'),

                                TextEntry::make('email_verified_at')
                                    ->label('Email Verified')
                                    ->dateTime()
                                    ->placeholder('Not verified')
                                    ->badge()
                                    ->color(fn($state): string => $state ? 'success' : 'danger')
                                    ->formatStateUsing(fn($state): string => $state ? 'Verified' : 'Not Verified'),
                            ]),

                        Grid::make(2)
                            ->schema([
                                TextEntry::make('created_at')
                                    ->label('Account Created')
                                    ->dateTime()
                                    ->since(),

                                TextEntry::make('updated_at')
                                    ->label('Last Updated')
                                    ->dateTime()
                                    ->since(),
                            ]),
                    ])
                    ->columns(1),
            ]);
    }
}
