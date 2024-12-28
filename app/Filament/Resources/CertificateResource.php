<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CertificateResource\Pages;
use App\Filament\Resources\CertificateResource\RelationManagers;
use App\Models\Certificate;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CertificateResource extends Resource
{
    protected static ?string $model = Certificate::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('jenis')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('prefix_nomor')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\Textarea::make('deskripsi')
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('lokasi')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('tanggal_terbit')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('nama_penandatangan')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('jabatan_penandatangan')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\FileUpload::make('file_tandatangan')
                    ->disk(config('base_urls.default_disk'))
                    ->directory(fn () => 'cert/'.date('Y').'/'.date('m'))
                    ->image()
                    ->required(),
                Forms\Components\FileUpload::make('background_image')
                    ->disk(config('base_urls.default_disk'))
                    ->directory(fn () => 'cert/'.date('Y').'/'.date('m'))
                    ->image()
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('jenis')
                    ->searchable(),
                Tables\Columns\TextColumn::make('prefix_nomor')
                    ->searchable(),
                Tables\Columns\TextColumn::make('lokasi')
                    ->searchable(),
                Tables\Columns\TextColumn::make('tanggal_terbit')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nama_penandatangan')
                    ->searchable(),
                Tables\Columns\TextColumn::make('jabatan_penandatangan')
                    ->searchable(),
                Tables\Columns\ImageColumn::make('file_tandatangan')
                    ->simpleLightbox(),
                Tables\Columns\ImageColumn::make('background_image')
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
            'index' => Pages\ListCertificates::route('/'),
            'create' => Pages\CreateCertificate::route('/create'),
            'edit' => Pages\EditCertificate::route('/{record}/edit'),
        ];
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\ParticipantRelationManager::class,
        ];
    }
}
