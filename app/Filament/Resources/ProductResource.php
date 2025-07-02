<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\RelationManagers;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Set;
use Filament\Forms\Get;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-s-cube';

    protected static ?string $navigationGroup = 'Products';
    protected static ?int $navigationSort = 5;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make('Basic Information')
                            ->schema([
                                Forms\Components\Select::make('category_id')
                                    ->relationship('category', 'name')
                                    ->required(),
                                Forms\Components\TextInput::make('name')
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(function (Set $set, $state) {
                                        $set('slug', Product::generateUniqueSlug($state));
                                        if ($state) {
                                            $set('sku', Product::generateSku($state));
                                        }
                                    })
                                    ->required()
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('slug')
                                    ->required()
                                    ->readOnly()
                                    ->dehydrated()
                                    ->maxLength(255),

                                Forms\Components\TextInput::make('sku')
                                    ->maxLength(100)
                                    ->helperText('Kode produk unik. Secara default dibuat otomatis berdasarkan nama produk namun Anda dapat mengubahnya.')
                                    ->unique(ignoreRecord: true),
                                Forms\Components\Toggle::make('is_active')
                                    ->required()
                                    ->helperText('Enable or disable product visibility')
                                    ->default(false)
                                    ->label('Active'),
                                Forms\Components\Toggle::make('has_variants')
                                    ->label('Has Variants')
                                    ->live()
                                    ->helperText('Enable if this product has multiple variants. Click save first to display variant features.')
                                    ->default(false)
                            ]),
                        Forms\Components\Section::make('Description')
                            ->schema([
                                Forms\Components\RichEditor::make('description')
                                    ->required()
                                    ->columnSpanFull(),
                                Forms\Components\TextInput::make('rating')
                                    ->numeric(),
                                Forms\Components\TextInput::make('terjual')
                                    ->numeric(),
                            ]),



                    ]),
                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make('Price & Stock')
                            ->schema([
                                Forms\Components\TextInput::make('price')
                                    ->required()
                                    ->numeric()
                                    ->prefix('Rp'),

                                Forms\Components\TextInput::make('discount')
                                    ->numeric()
                                    ->prefix('%'),
                                Forms\Components\TextInput::make('stock')
                                    ->required()
                                    ->numeric(),
                            ])
                            ->hidden(fn(Get $get) => $get('has_variants')),
                        Forms\Components\Section::make('Product Dimensions')
                            ->schema([
                                Forms\Components\Grid::make()
                                    ->schema([
                                        Forms\Components\TextInput::make('weight')
                                            ->required()
                                            ->numeric()
                                            ->default(0)
                                            ->label('Weight (gram)'),
                                        Forms\Components\TextInput::make('height')
                                            ->required()
                                            ->numeric()
                                            ->default(0)
                                            ->label('Height (cm)'),
                                        Forms\Components\TextInput::make('width')
                                            ->required()
                                            ->numeric()
                                            ->default(0)
                                            ->label('Width (cm)'),
                                        Forms\Components\TextInput::make('length')
                                            ->required()
                                            ->numeric()
                                            ->default(0)
                                            ->label('Length (cm)'),
                                    ])

                            ]),
                        Forms\Components\Section::make('Images')
                            ->schema([
                                Forms\Components\FileUpload::make('images')
                                    ->columnSpanFull()
                                    ->multiple(),
                            ]),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('images')
                    ->circular()
                    ->stacked(),
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('sku')
                    ->searchable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('category.name')
                    ->sortable(),
                Tables\Columns\TextColumn::make('price_display')
                    ->label('Price')
                    ->getStateUsing(function ($record) {
                        if ($record->has_variants) {
                            $minPrice = $record->variants()->min('price') ?? 0;
                            $maxPrice = $record->variants()->max('price') ?? 0;

                            if ($minPrice == $maxPrice) {
                                return 'Rp ' . number_format($minPrice, 0, ',', '.');
                            }

                            return 'Rp ' . number_format($minPrice, 0, ',', '.') . ' - ' .
                                'Rp ' . number_format($maxPrice, 0, ',', '.');
                        }

                        return 'Rp ' . number_format($record->price, 0, ',', '.');
                    })
                    ->sortable(query: function (Builder $query, string $direction): Builder {
                        return $query->orderBy('price', $direction);
                    }),
                Tables\Columns\TextColumn::make('stock_display')
                    ->label('Stock')
                    ->getStateUsing(function ($record) {
                        if ($record->has_variants) {
                            return $record->variants()->sum('stock') ?? 0;
                        }

                        return $record->stock;
                    })
                    ->numeric()
                    ->sortable(query: function (Builder $query, string $direction): Builder {
                        return $query->orderBy('stock', $direction);
                    }),
                Tables\Columns\IconColumn::make('has_variants')
                    ->boolean()
                    ->toggleable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->boolean(),
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
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\VariantsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
