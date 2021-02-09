<?php

namespace Modules\Opx\FeedBack\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Modules\Opx\FeedBack\Models\FeedbackForm;
use Modules\Opx\FeedBack\Models\FeedbackRecord;
use Modules\Opx\MailTemplater\OpxMailTemplater;

class FeedbackAdminNotification extends Mailable
{
    use Queueable, SerializesModels;

    /** @var FeedbackRecord */
    protected FeedbackRecord $record;

    /** @var FeedbackForm */
    protected $form;

    /**
     * Create a new message instance.
     *
     * @param FeedbackRecord $record
     *
     */
    public function __construct(FeedbackRecord $record)
    {
        $this->record = $record;
        $this->form = FeedbackForm::query()->where('id', $record->getAttribute('form_id'))->first();
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build(): self
    {
        $from = [
            'address' => $this->form->getAttribute('from_email'),
            'name' => $this->form->getAttribute('from_name'),
        ];

        $receivers = explode(',', $this->form->getAttribute('to_emails'));
        $to = [];

        foreach ($receivers as $receiver) {
            $to[] = trim($receiver);
        }

        $subject = $this->record->getAttribute('title') . ' (' . $this->record->getAttribute('created_at')->format('d/m/Y H:i') . ')';

        $payload = [];
        foreach ($this->record->getAttribute('payload') as $record) {
            if ($record['name'] === 'phone') {
                $value = '<a href="tel:' . preg_replace('/[^+^\d]/', '', $record['value']) . '">' . $record['value'] . '</a>';
            } elseif ($record['name'] === 'email') {
                $value = '<a href="mailto:' . $record['value'] . '">' . $record['value'] . '</a>';
            } else {
                $value = $record['value'];
            }
            $payload[] = [$record['caption'], $value];
        }

        return $this
            ->from($from['address'], $from['name'] ?? null)
            ->to($to)
            ->subject($subject)
            ->html(OpxMailTemplater::make([
                OpxMailTemplater::title($subject),
                OpxMailTemplater::table($payload),
            ], 'clean'));
    }
}