<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('User Information')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\TextInput::make('email')
                            ->email()
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true),

                        Forms\Components\Select::make('role')
                            ->label('Web Role')
                            ->options([
                                'student' => 'Student',
                                'counselor' => 'Counselor',
                                'lab_admin' => 'Lab Admin',
                                'lab_staff' => 'Lab Staff',
                            ])
                            ->required()
                            ->reactive(),

                        Forms\Components\TextInput::make('password')
                            ->password()
                            ->required(fn (string $context): bool => $context === 'create')
                            ->rule(Password::default())
                            ->dehydrated(fn (?string $state): bool => filled($state))
                            ->dehydrateStateUsing(fn (string $state): string => Hash::make($state)),

                        Forms\Components\DateTimePicker::make('email_verified_at')
                            ->label('Email Verified At'),

                        Forms\Components\Select::make('roles')
                            ->label('Admin Role')
                            ->relationship('roles', 'name')
                            ->multiple()
                            ->preload(),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('email')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('role')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'student' => 'success',
                        'counselor' => 'primary',
                        'lab_admin' => 'danger',
                        'lab_staff' => 'warning',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => ucfirst(str_replace('_', ' ', $state)))
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('email_verified_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('role')
                    ->options([
                        'student' => 'Student',
                        'counselor' => 'Counselor',
                        'lab_admin' => 'Lab Admin',
                        'lab_staff' => 'Lab Staff',
                    ]),

                Tables\Filters\Filter::make('verified')
                    ->label('Email Verified')
                    ->query(fn ($query) => $query->whereNotNull('email_verified_at')),
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }

    protected static function afterCreate(User $user): void
    {
        self::handleRoleSpecificCreation($user);
    }

    protected static function afterUpdate(User $user): void
    {
        // Only create if role was changed to student/counselor
        if ($user->wasChanged('role') && in_array($user->role, ['student', 'counselor'])) {
            self::handleRoleSpecificCreation($user);
        }
    }

    protected static function handleRoleSpecificCreation(User $user): void
    {
        switch ($user->role) {
            case 'student':
                $user->student()->firstOrCreate([
                    'user_id' => $user->id,
                    'email' => $user->email,
                ], [
                    'name' => $user->name,
                    // Add other default student fields if needed
                ]);
                break;

            case 'counselor':
                $user->counselor()->firstOrCreate([
                    'user_id' => $user->id,
                    'email' => $user->email,
                ], [
                    'name' => $user->name,
                    // Add other default counselor fields if needed
                ]);
                break;
        }
    }
}
