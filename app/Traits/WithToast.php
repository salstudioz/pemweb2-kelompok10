<?php
namespace App\Traits;

trait WithToast {
    public function notify($message, $type = 'success') {
        $this->dispatch('notify', [
            'message' => $message,
            'type' => $type
        ]);
    }

    public function toast($message, $type = 'success') {
        $this->notify($message, $type);
    }
}