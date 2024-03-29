<?php

namespace App\Http\Livewire\Modals;

use App\Http\Livewire\Modal;
use App\Models\Setting;
use App\Notifications\CallbackNotification;
use Illuminate\Support\Facades\Notification;

class Callback extends Modal
{
    public $name;
    public $phone;

    public function send()
    {
        $validated = $this->validate([
            'name' => 'required',
            'phone' => 'required',
        ]);

        Notification::route('mail', Setting::where('code', 'email')->first()?->value)
            ->notify(new CallbackNotification($validated));
    }

    public function render()
    {
        return view('livewire.modals.callback');
    }
}
