<?php

namespace App\Filament\Resources\Client\ChatResource\Pages;

use App\Filament\Resources\Client\ChatResource;
use App\Models\Message;
use Filament\Actions;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Pages\ViewRecord;
use Filament\Notifications\Notification;

class ViewChat extends ViewRecord
{
    protected static string $resource = ChatResource::class;

    protected static string $view = 'filament.resources.client.chat-resource.pages.view-chat';

    public ?array $data = [];

    protected function hasInfolist(): bool
    {
        return false;
    }

    public function form(Form $form): Form
    {
        return $form;
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('markAllRead')
                ->label('Mark All as Read')
                ->icon('heroicon-o-check')
                ->action(function () {
                    $this->record->messages()
                        ->where('sender_id', '!=', auth()->id())
                        ->where('is_read', false)
                        ->update([
                            'is_read' => true,
                            'read_at' => now(),
                        ]);
                    
                    Notification::make()
                        ->success()
                        ->title('All messages marked as read')
                        ->send();
                }),
        ];
    }

    public function mount(int | string $record): void
    {
        $this->record = $this->resolveRecord($record);
        $this->authorizeAccess();
        
        // Mark messages as read when viewing
        $this->record->messages()
            ->where('sender_id', '!=', auth()->id())
            ->where('is_read', false)
            ->update([
                'is_read' => true,
                'read_at' => now(),
            ]);
    }

    protected function getForms(): array
    {
        return [
            'messageForm' => $this->form(
                Forms\Form::make($this)
                    ->schema([
                        Forms\Components\Textarea::make('messageBody')
                            ->label('Type your message')
                            ->required()
                            ->rows(3)
                            ->placeholder('Type your message here...')
                            ->maxLength(1000),
                    ])
                    ->statePath('data')
            ),
        ];
    }

    public function sendMessage(): void
    {
        $data = $this->getForm('messageForm')->getState();

        if (empty($data['messageBody'])) {
            Notification::make()
                ->danger()
                ->title('Message cannot be empty')
                ->send();
            return;
        }

        $message = Message::create([
            'chat_id' => $this->record->id,
            'sender_id' => auth()->id(),
            'body' => $data['messageBody'],
            'is_read' => false,
        ]);

        // Update chat last message time
        $this->record->updateLastMessage();

        // Notify supplier
        $this->record->supplier->user->notify(new \App\Notifications\NewMessageNotification($message));

        $this->data['messageBody'] = '';
        $this->getForm('messageForm')->fill();

        Notification::make()
            ->success()
            ->title('Message sent')
            ->send();
    }

    protected function getViewData(): array
    {
        return [
            'messages' => $this->record->messages()
                ->with('sender')
                ->orderBy('created_at', 'asc')
                ->get(),
        ];
    }
}

