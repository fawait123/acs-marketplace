<?php

namespace App\Listeners;

use App\Events\RegisterEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\Notification;

class NotificationListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\RegisterEvent  $event
     * @return void
     */
    public function handle(RegisterEvent $event)
    {
        $user = $event->get();
        Notification::create([
            'title'=>'Register Seller '.$user->name,
            'body'=>$user->name.' Register Seller, Please actively account',
            'from_user'=>$user->id,
            'to_user'=>1
        ]);
    }
}
