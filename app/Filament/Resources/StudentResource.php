<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StudentResource\Pages;
use App\Models\Student;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class StudentResource extends Resource
{
    protected static ?string $model = Student::class;

    protected static ?string $modelLabel = 'Mahasiswa';

    protected static ?string $navigationIcon = 'heroicon-o-user';

    protected static ?string $navigationLabel = 'Mahasiswa';

    protected static ?string $navigationGroup = 'Kelola Pengguna';

    public static function canCreate(): bool
    {
        return false; // This will remove the "Create" button entirely
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')->label('Nama'),
                Forms\Components\TextInput::make('username')->label('NIM'),
                Forms\Components\TextInput::make('email'),
                Forms\Components\TextInput::make('phone')->label('No. Telfon'),
                Forms\Components\TextInput::make('place_of_birth')->label('Tempat Lahir'),
                Forms\Components\DatePicker::make('date_of_birth')->label('Tanggal Lahir'),
                Forms\Components\Select::make('etnic')
                    ->label('Suku')
                    ->options([
                        'jawa' => 'Jawa',
                        'batak' => 'Batak',
                        'sunda' => 'Sunda',
                    ])
                    ->searchable(),
                Forms\Components\TextInput::make('hobby')->label('Hobi'),
                Forms\Components\Textarea::make('bio')->label('Biografi'),
                Forms\Components\Textarea::make('address')->label('Alamat'),
                Forms\Components\FileUpload::make('image')
                    ->label('Gambar')
                    ->directory('student-images'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image')->label('Gambar'),
                Tables\Columns\TextColumn::make('name')->label('Nama Lengkap'),
                Tables\Columns\TextColumn::make('username')->label('NIM'),
                Tables\Columns\TextColumn::make('email'),
                Tables\Columns\TextColumn::make('phone')->label('No. Telfon'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListStudents::route('/'),
            'create' => Pages\CreateStudent::route('/create'),
            'edit' => Pages\EditStudent::route('/{record}/edit'),
        ];
    }
}
