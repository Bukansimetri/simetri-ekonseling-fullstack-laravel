<?php

namespace App\Filament\Resources\ChatGroupResource\Pages;

use App\Filament\Resources\ChatGroupResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditChatGroup extends EditRecord
{
    protected static string $resource = ChatGroupResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
