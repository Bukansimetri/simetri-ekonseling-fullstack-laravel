<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ChatResource\Pages;
use App\Models\Chat;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ChatResource extends Resource
{
    protected static ?string $model = Chat::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Chat Management';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('sender_id')
                    ->label('Pengirim')
                    ->relationship('sender', 'name')
                    ->searchable()
                    ->required(),

                Select::make('receiver_id')
                    ->label('Penerima')
                    ->relationship('receiver', 'name')
                    ->searchable()
                    ->required(),

                Textarea::make('message')
                    ->label('Pesan')
                    ->rows(4)
                    ->required(),

                Select::make('status')
                    ->options([
                        'open' => 'Open',
                        'closed' => 'Closed',
                        'meet_up' => 'Meet Up',
                    ])
                    ->required()
                    ->default('open'),
            ]);

    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('sender.name')
                    ->label('Dari')
                    ->searchable(),

                TextColumn::make('receiver.name')
                    ->label('Ke')
                    ->searchable(),

                TextColumn::make('message')
                    ->label('Pesan')
                    ->limit(40)
                    ->tooltip(fn ($record) => $record->message),

                BadgeColumn::make('status')
                    ->colors([
                        'primary' => 'open',
                        'success' => 'closed',
                        'warning' => 'meet_up',
                    ])
                    ->label('Status'),

                TextColumn::make('created_at')
                    ->dateTime('d M Y H:i'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
                Tables\Actions\BulkAction::make('bulkClose')
                    ->label('Tutup Semua')
                    ->action(fn ($records) => $records->each->update(['status' => 'closed']))
                    ->requiresConfirmation(),
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
            'index' => Pages\ListChats::route('/'),
            'create' => Pages\CreateChat::route('/create'),
            'edit' => Pages\EditChat::route('/{record}/edit'),
        ];
    }
}
