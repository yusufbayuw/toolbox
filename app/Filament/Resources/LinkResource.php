<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LinkResource\Pages;
use App\Filament\Resources\LinkResource\RelationManagers;
use App\Models\Link;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class LinkResource extends Resource
{
    protected static ?string $model = Link::class;

    protected static ?string $navigationIcon = 'heroicon-o-cube-transparent';

    protected static ?string $modelLabel = 'Link Tree';

    protected static ?string $slug = 'link';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required(),
                Forms\Components\Hidden::make('user_id')
                    ->default(auth()->user()->id),
                Forms\Components\Select::make('theme_id')
                    ->relationship('theme', 'name')
                    ->default(null)
                    ->required(),
                Forms\Components\TextInput::make('url_slug')
                    ->required()
                    ->label('URL')
                    ->prefix(fn() => config('base_urls.base_link') . '/')
                    ->maxLength(255),
                Forms\Components\Repeater::make('links')
                    ->required()
                    ->schema([
                        Forms\Components\TextInput::make('link_name')
                            ->label('Judul')
                            ->required(),
                        Forms\Components\TextInput::make('link_url')
                            ->label('URL')
                            ->url()
                            ->required(),
                        Forms\Components\TextInput::make('link_desc')
                            ->label('Keterangan')
                    ])
                    ->cloneable(),
                Forms\Components\FileUpload::make('logo')
                    ->image()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Judul')
                    ->searchable(),
                Tables\Columns\TextColumn::make('theme.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('url_slug')
                    ->searchable(),
                Tables\Columns\ImageColumn::make('logo')
                    ->simpleLightbox(),
                Tables\Columns\ImageColumn::make('qr_code_image')
                    ->simpleLightbox(),
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
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageLinks::route('/'),
        ];
    }
}
