<?php

namespace Modules\Opx\FeedBack\Controllers;

use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Core\Http\Controllers\APIListController;
use Modules\Opx\FeedBack\Models\FeedbackForm;

class ManageFeedBackFormsListApiController extends APIListController
{
    protected $caption = 'opx_feed_back::manage.forms';
    protected $description;
    protected $source = 'manage/api/module/opx_feed_back/feed_back_forms_list/feed_back_forms';


    protected $enable = 'manage/api/module/opx_feed_back/feed_back_forms_actions/enable';
    protected $disable = 'manage/api/module/opx_feed_back/feed_back_forms_actions/disable';
    protected $delete = 'manage/api/module/opx_feed_back/feed_back_forms_actions/delete';
    protected $restore = 'manage/api/module/opx_feed_back/feed_back_forms_actions/restore';

    protected $add = 'opx_feed_back::feed_back_forms_add';
    protected $edit = 'opx_feed_back::feed_back_forms_edit';

    /**
     * Get list of users with sorting, filters and search.
     *
     * @return  JsonResponse
     */
    public function postFeedBackForms(): JsonResponse
    {
        $forms = $this->makeQuery()->get();

        /** @var Collection $forms */
        if ($forms->count() > 0) {
            $forms->transform(function ($form) {
                /** @var FeedbackForm $form */
                return $this->makeListRecord(
                    $form->getAttribute('id'),
                    $form->getAttribute('name'),
                    $form->getAttribute('alias'),
                    null,
                    ['from: ' . $form->getAttribute('from_email'), 'to: ' . $form->getAttribute('to_emails')],
                    (bool)$form->getAttribute('enabled'),
                    $form->getAttribute('deleted_at') !== null
                );
            });
        }

        $response = ['data' => $forms->toArray()];

        return response()->json($response);
    }

    /**
     * Make base list query.
     *
     * @return  EloquentBuilder
     */
    protected function makeQuery(): EloquentBuilder
    {
        /** @var EloquentBuilder $query */
        $query = FeedbackForm::query()->withTrashed();

        return $query;
    }
}