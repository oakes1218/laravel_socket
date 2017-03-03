<?php

namespace App\Events;

use App\Events\Event;
use App\Http\Requests\Request;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class MyEventNameHere extends Event implements ShouldBroadcast
{
    use SerializesModels;
    public $data;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($name, $msg ,$result)
    {
        $this->data = array(
            'name' => $name,
            'msg' => $msg,
            'doPlay' => $result
        );
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return ['test-channel'];
    }
}
