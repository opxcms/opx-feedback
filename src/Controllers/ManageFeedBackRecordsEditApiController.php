<?php

namespace Modules\Opx\FeedBack\Controllers;

use Core\Foundation\Templater\Templater;
use Core\Http\Controllers\APIFormController;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\Admin\Authorization\AdminAuthorization;
use Modules\Opx\FeedBack\Models\FeedbackRecord;
use Modules\Opx\FeedBack\OpxFeedBack;

class ManageFeedBackRecordsEditApiController extends APIFormController
{
    public string $editCaption = 'opx_feed_back::manage.edit_record';

    /**
     * Make form edit form.
     *
     * @param Request $request
     *
     * @return  JsonResponse
     */
    public function getEdit(Request $request): JsonResponse
    {
        if(!AdminAuthorization::can('opx_feed_back::notifications')) {
            return $this->returnNotAuthorizedResponse();
        }

        /** @var FeedbackRecord $record */
        $id = $request->input('id');
        $record = FeedbackRecord::withTrashed()->where('id', $id)->firstOrFail();

        // mark as read
        $record->setAttribute('checked', true);
        $record->save();

        $template = $this->makeTemplate($record, 'feedback_record.php');

        return $this->responseFormComponent($id, $template, $this->editCaption);
    }

    /**
     * Fill template with data.
     *
     * @param FeedbackRecord $record
     *
     * @param string $filename
     *
     * @return  Templater
     */
    protected function makeTemplate(FeedbackRecord $record, string $filename): Templater
    {
        $template = new Templater(OpxFeedBack::getTemplateFileName($filename));

        $template->fillValuesFromObject($record);

        $payload = $template->getField('payload');

        $value = '';

        foreach ($payload['value'] ?? [] as $rec) {
            $value .= "{$rec['caption']}: {$rec['value']}\n";
        }

        $payload['value'] = $value;

        $template->setField('payload', $payload);

        return $template;
    }
}