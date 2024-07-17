<?php

namespace App\Events\Application;

use App\Models\Application;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

/**
 * Specifically only thrown when an application is hired and then needs to be undone
 */
class ApplicationReconsider
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
