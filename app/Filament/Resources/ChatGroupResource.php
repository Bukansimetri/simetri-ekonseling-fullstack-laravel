<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ChatGroupResource\Pages;
use App\Models\ChatGroup;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ChatGroupResource extends Resource
{
    protected static ?string $model = ChatGroup::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Chat Management';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->required()
                    ->label('Group Name'),

                Textarea::make('description')
                    ->label('Description')
                    ->rows(3),

                Select::make('users')
                    ->label('Group Members')
                    ->multiple()
                    ->relationship('users', 'name') // relasi many-to-many
                    ->searchable()
                    ->preload()
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('description')
                    ->limit(40),

                TextColumn::make('users_count')
                    ->counts('users')
                    ->label('Member Count'),

                TextColumn::make('created_at')
                    ->dateTime('d M Y')
                    ->sortable(),
            ])
            ->filters([])
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

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->withCount('users');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListChatGroups::route('/'),
            'create' => Pages\CreateChatGroup::route('/create'),
            'edit' => Pages\EditChatGroup::route('/{record}/edit'),
        ];
    }
}
