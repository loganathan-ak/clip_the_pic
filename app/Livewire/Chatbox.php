<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Conversation;
use App\Models\User;

class Chatbox extends Component
{
    public $order;
    public $receiver;
    public $sender;
    public $message;
    public $receiverRole = 'superadmin';

   public function mount($order){
    $this->order = $order->id;
    $superadmin = User::where('role', 'superadmin')->first();

    if (!$superadmin) {
        abort(404, 'Superadmin not found.');
    }

    if (auth()->id() === $superadmin->id) {
        $this->receiver = $order->created_by;
        $this->sender = $superadmin->id;
    } elseif (auth()->id() === $order->created_by) {
        $this->receiver = $superadmin->id;
        $this->sender = $order->created_by;
    } else {
        abort(403, 'Unauthorized.');
    }
  }

    public function store()
    {
        $this->validate([
            'message' => 'required',
        ]);

        Conversation::create([
            'order_id' => $this->order,
            'sender_id' => $this->sender,
            'receiver_id' => $this->receiver,
            'message' => $this->message,
        ]);

        $this->message = '';
    }

    public function render()
    {
        return view('livewire.chatbox', [
            'conversations' => Conversation::where('order_id', $this->order)
                ->orderBy('created_at')
                ->get(),
        ]);
    }
}


