<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AppointmentResource\Pages;
use App\Models\Appointment;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Twilio\Rest\Client;

class AppointmentResource extends Resource
{
    protected static ?string $model = Appointment::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';

    protected static ?string $navigationGroup = 'Schedule Management';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'accepted' => 'Accepted',
                        'rejected' => 'Rejected',
                        'done' => 'Completed',
                    ])
                    ->required(),

                Forms\Components\TextInput::make('link_meeting')
                    ->maxLength(255)
                    ->required()
                    ->helperText('Changing this will send WhatsApp notifications'),

                Forms\Components\Section::make('Appointment Details (Read Only)')
                    ->schema([
                        Forms\Components\TextInput::make('student.name')
                            ->label('Student'),

                        Forms\Components\TextInput::make('student.phone')
                            ->label('Student Phone'),

                        Forms\Components\TextInput::make('counselor.name')
                            ->label('Counselor'),

                        Forms\Components\TextInput::make('counselor.phone')
                            ->label('Counselor Phone'),

                        Forms\Components\DateTimePicker::make('scheduled_at'),
                    ])
                    ->columns(2)
                    ->disabled(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('student.name')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('counselor.name')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('scheduled_at')
                    ->dateTime()
                    ->sortable(),

                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'Pending',
                        'accepted' => 'Accepted',
                        'rejected' => 'Rejected',
                        'done' => 'Completed',
                    }),

                Tables\Columns\TextColumn::make('link_meeting'),
            ])
            ->filters([
                // ... (keep your existing filters)
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->mutateRecordDataUsing(function (array $data, Appointment $record): array {
                        // Store old link before changes
                        $record->old_link_meeting = $record->link_meeting;

                        return $data;
                    })
                    ->after(function (Appointment $record) {
                        // Send WhatsApp if link changed
                        if ($record->wasChanged('link_meeting') && $record->link_meeting != $record->old_link_meeting) {
                            self::sendWhatsAppNotification($record);
                        }
                    }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    protected static function sendWhatsAppNotification(Appointment $appointment)
    {
        try {
            $student = $appointment->student;
            $counselor = $appointment->counselor;
            $newLink = $appointment->link_meeting;

            $message = "🔔 *Appointment Update*\n\n";
            $message .= "Your meeting link has been updated:\n";
            $message .= "*When:* {$appointment->scheduled_at}\n";
            $message .= "*New Link:* {$newLink}\n\n";
            $message .= 'Thank you!';

            $recipients = [];

            // Add student if phone exists
            if ($student->phone) {
                $recipients[] = [
                    'name' => $student->name,
                    'phone' => $student->phone,
                ];
            }

            // Add counselor if phone exists
            if ($counselor->phone) {
                $recipients[] = [
                    'name' => $counselor->name,
                    'phone' => $counselor->phone,
                ];
            }

            if (empty($recipients)) {
                Notification::make()
                    ->title('No WhatsApp notifications sent')
                    ->body('Neither student nor counselor has a phone number saved')
                    ->warning()
                    ->send();

                return;
            }

            $successCount = 0;
            $twilioClient = new Client(
                config('services.twilio.sid'),
                config('services.twilio.token')
            );

            foreach ($recipients as $recipient) {
                $twilioClient->messages->create(
                    "whatsapp:{$recipient['phone']}",
                    [
                        'from' => 'whatsapp:'.config('services.twilio.whatsapp_from'),
                        'body' => $message,
                    ]
                );
                $successCount++;
            }

            Notification::make()
                ->title('WhatsApp notifications sent')
                ->body("Successfully sent to {$successCount} recipient(s)")
                ->success()
                ->send();

        } catch (\Exception $e) {
            Notification::make()
                ->title('Failed to send WhatsApp notifications')
                ->body($e->getMessage())
                ->danger()
                ->send();
        }
    }

    // Contoh di Resource
public static function getEloquentQuery()
{
    return parent::getEloquentQuery()->with(['student', 'counselor']);
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
            'index' => Pages\ListAppointments::route('/'),
            'create' => Pages\CreateAppointment::route('/create'),
            'edit' => Pages\EditAppointment::route('/{record}/edit'),
        ];
    }
}
