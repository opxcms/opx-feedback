<?php

namespace Modules\Opx\FeedBack\Listeners;

use Illuminate\Support\Facades\Mail;
use Modules\Opx\FeedBack\Events\NewFeedbackRecord;
use Modules\Opx\FeedBack\Notifications\FeedbackAdminNotification;

class NewFeedbackListener
{
    /**
     * Handle the event.
     *
     * @param  NewFeedbackRecord $event
     *
     * @return void
     */
    public function handle(NewFeedbackRecord $event): void
    {
        Mail::queue(new FeedbackAdminNotification($event->record));
    }
}