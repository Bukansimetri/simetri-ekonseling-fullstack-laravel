<?php

namespace App\Filament\Resources;

use App\Filament\Resources\HeroSectionResource\Pages;
use App\Models\HeroSection;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class HeroSectionResource extends Resource
{
    protected static ?string $model = HeroSection::class;

    protected static ?string $modelLabel = 'Banner';

    protected static ?string $navigationIcon = 'heroicon-o-bars-2';

    protected static ?string $navigationGroup = 'Kelola Beranda';

    protected static ?string $navigationLabel = 'Banner';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')->label('Judul'),
                Forms\Components\TextInput::make('subtitle')->label('Sub Judul'),
                Forms\Components\TextInput::make('cta_text')->label('Tombol Text'),
                Forms\Components\Toggle::make('is_active'),
                // Forms\Components\FileUpload::make('image')
                //     ->directory('hero-images'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // Tables\Columns\ImageColumn::make('image'),
                Tables\Columns\TextColumn::make('title')->label('Judul'),
                Tables\Columns\TextColumn::make('subtitle')->label('Sub Judul'),
                Tables\Columns\TextColumn::make('cta_text')->label('Tombol Text'),
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
            'index' => Pages\ListHeroSections::route('/'),
            'create' => Pages\CreateHeroSection::route('/create'),
            'edit' => Pages\EditHeroSection::route('/{record}/edit'),
        ];
    }
}
