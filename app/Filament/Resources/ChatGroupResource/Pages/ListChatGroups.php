<?php

namespace App\Filament\Resources\ChatGroupResource\Pages;

use App\Filament\Resources\ChatGroupResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListChatGroups extends ListRecords
{
    protected static string $resource = ChatGroupResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
