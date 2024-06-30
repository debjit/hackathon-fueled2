<?php

namespace App\Filament\Pages;

use App\Events\PusherBroadcast;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Forms;
use Illuminate\Broadcasting\Broadcasters\PusherBroadcaster;
use Illuminate\Mail\Events\MessageSent;
use Illuminate\Support\Facades\Broadcast;

class PusherTest extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.pusher-test';

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill();
    }

    public function form(Form $form): Form
    {


        return $form
            ->schema([
                Forms\Components\Actions::make([
                    Action::make('sendEmail')
                        ->form([
                            TextInput::make('subject')->required(),

                        ])
                        ->action(function (array $data) {
                            $recipient = auth()->user();
                            // Mail::to($this->client)
                            //     ->send(new GenericEmail(
                            //         subject: $data['subject'],
                            //         body: $data['body'],
                            //     ));

                            Notification::make()
                                ->title($data['subject'])
                                ->send()
                                ->getBroadcastMessage();
                                Notification::make()
                                ->title('Saved successfully')
                                ->broadcast($recipient);
                                // broadcast(new PusherBroadcast($data['subject'])->toOthers());
                        })
                ])
            ])
            ->statePath('data');
    }
}
