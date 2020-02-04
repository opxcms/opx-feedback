<?php

namespace Modules\Opx\FeedBack\Controllers;

use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Core\Http\Controllers\APIListController;
use Modules\Admin\Authorization\AdminAuthorization;
use Modules\Opx\FeedBack\Models\FeedbackForm;

class ManageFeedBackFormsListApiController extends APIListController
{
    protected $caption = 'opx_feed_back::manage.forms';
    protected $description;
    protected $source = 'manage/api/module/opx_feed_back/feed_back_forms_list/feed_back_forms';

    /**
     * Get list of users with sorting, filters and search.
     *
     * @return  JsonResponse
     */
    public function postFeedBackForms(): JsonResponse
    {
        if (!AdminAuthorization::can('opx_feed_back::list')) {
            return $this->returnNotAuthorizedResponse();
        }

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
        $query = FeedbackForm::withTrashed();

        return $query;
    }

    /**
     * Get add link.
     *
     * @return  string
     */
    protected function getAddLink(): ?string
    {
        return AdminAuthorization::can('opx_feed_back::add') ? 'opx_feed_back::feed_back_forms_add' : null;
    }

    /**
     * Get edit link.
     *
     * @return  string
     */
    protected function getEditLink(): ?string
    {
        return AdminAuthorization::can('opx_feed_back::edit') ? 'opx_feed_back::feed_back_forms_edit' : null;
    }

    /**
     * Get enable link.
     *
     * @return  string
     */
    protected function getEnableLink(): ?string
    {
        return AdminAuthorization::can('opx_feed_back::disable') ? 'manage/api/module/opx_feed_back/feed_back_forms_actions/enable' : null;
    }

    /**
     * Get disable link.
     *
     * @return  string
     */
    protected function getDisableLink(): ?string
    {
        return AdminAuthorization::can('opx_feed_back::disable') ? 'manage/api/module/opx_feed_back/feed_back_forms_actions/disable' : null;
    }

    /**
     * Get delete link.
     *
     * @return  string
     */
    protected function getDeleteLink(): ?string
    {
        return AdminAuthorization::can('opx_feed_back::delete') ? 'manage/api/module/opx_feed_back/feed_back_forms_actions/delete' : null;
    }

    /**
     * Get restore link.
     *
     * @return  string
     */
    protected function getRestoreLink(): ?string
    {
        return AdminAuthorization::can('opx_feed_back::delete') ? 'manage/api/module/opx_feed_back/feed_back_forms_actions/restore' : null;
    }
}