<?php

namespace App\Listeners;

use App\Events\RegisterAccount;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TestController;

class sendSMSAfterRegisterAccount implements ShouldQueue
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
     * @param  RegisterAccount  $event
     * @return void
     */
    public function handle(RegisterAccount $event)
    {
        //sleep(120);

        $testController = new TestController();
        $testController->testStore();

        /*$userController = new UserController();
        $userController->sendSMS($event->user->phone_number, 1);*/

    }
}
