<?php

namespace Modules\Opx\FeedBack;

use Modules\Opx\FeedBack\Models\FeedbackForm;
use Modules\Opx\FeedBack\Models\FeedbackRecord;
use RuntimeException;

class FormParser
{
    /**
     * Run parsing.
     *
     * @param string $formName
     * @param $payload
     *
     * @return  FeedbackRecord
     */
    public function parse(string $formName, $payload): FeedbackRecord
    {
        $form = FeedbackForm::where('alias', $formName)->first();

        if ($form === null) {
            throw new RuntimeException("Form [{$formName}] not found");
        }

        $method = 'parse' . str_replace(['_', '-'], '', title_case($formName)) . 'Form';

        if (method_exists($this, $method)) {
            return $this->$method($form, $payload);
        }

        return $this->parseDefault($form, $payload);
    }

    /**
     * Default parser.
     *
     * @param FeedbackForm $form
     * @param array $payload
     *
     * @return  FeedbackRecord
     */
    protected function parseDefault(FeedbackForm $form, array $payload): FeedbackRecord
    {
        $record = new FeedbackRecord();

        $record->setAttribute('form_id', $form->getAttribute('id'));
        $record->setAttribute('title', $form->getAttribute('email_title'));
        $record->setAttribute('contact_name', $payload['name'] ?? null);
        $record->setAttribute('contact_email', $payload['email'] ?? null);
        $record->setAttribute('contact_phone', $payload['phone'] ?? null);
        $record->setAttribute('checked', false);
        $record->setAttribute('payload', $this->transformPayload($payload));

        return $record;
    }

    /**
     * Transform payload.
     *
     * @param array $payload
     *
     * @return  array
     */
    protected function transformPayload(array $payload): array
    {
        $transformed = [];

        foreach ($payload as $key=>$value) {
            $transformed[] = [
                'name' => $key,
                'caption' => trans("opx_feed_back::form.feedback_{$key}"),
                'value' => $value,
            ];
        }

        return $transformed;
    }
}