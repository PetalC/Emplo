<?php

namespace App\Events\Application;

use App\Models\Application;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ApplicationStatusChanged
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public Application $application;

    /**
     * Create a new event instance.
     */
    public function __construct(Application $application) {
        $this->application = $application;
    }
}
