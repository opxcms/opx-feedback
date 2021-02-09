<?php

namespace Modules\Opx\FeedBack\Events;

use Illuminate\Queue\SerializesModels;
use Modules\Opx\FeedBack\Models\FeedbackRecord;

class NewFeedbackRecord
{
    use SerializesModels;

    public FeedbackRecord $record;

    /**
     * Create a new feedback event.
     *
     * @param  FeedbackRecord $record
     *
     * @return void
     */
    public function __construct(FeedbackRecord $record)
    {
        $this->record = $record;
    }
}