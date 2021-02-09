<?php

namespace Modules\Opx\FeedBack\Controllers;

use Core\Foundation\ListHelpers\Filters;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Core\Http\Controllers\APIListController;
use Illuminate\Http\Request;
use Modules\Admin\Authorization\AdminAuthorization;
use Modules\Opx\FeedBack\Models\FeedbackRecord;

class ManageFeedBackRecordsListApiController extends APIListController
{
    protected $caption = 'opx_feed_back::manage.records';
    protected $description;
    protected $source = 'manage/api/module/opx_feed_back/feed_back_records_list/feed_back_records';

    /**
     * Get list of users with sorting, filters and search.
     *
     * @param Request $request
     *
     * @return  JsonResponse
     */
    public function postFeedBackRecords(Request $request): JsonResponse
    {
        if (!AdminAuthorization::can('opx_feed_back::notifications')) {
            return $this->returnNotAuthorizedResponse();
        }

        $filters = $request->input('filters');

        $records = $this->applyFilters($this->makeQuery(), $filters)->paginate(50);

        /** @var Collection $records */
        if ($records->count() > 0) {
            $records->transform(function ($record) {
                /** @var FeedbackRecord $record */
                return $this->makeListRecord(
                    $record->getAttribute('id'),
                    $record->getAttribute('title'),
                    $record->getAttribute('contact_name'),
                    $record->getAttribute('contact_phone'),
                    ['datetime:' . $record->getAttribute('created_at')->toIso8601String(), $record->getAttribute('contact_email')],
                    (bool)$record->getAttribute('checked'),
                    $record->getAttribute('deleted_at') !== null
                );
            });
        }

        $response = $records->toArray();

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
        $query = FeedbackRecord::query()->orderBy('created_at', 'desc');

        return $query;
    }

    protected function getFilters(): ?array
    {
        $filters = Filters::addDeletedFilter();

        $filters['enabled'] = [
            'caption' => 'opx_feed_back::manage.filter_by_read',
            'type' => 'checkbox',
            'enabled' => false,
            'value' => 'disabled',
            'options' => ['enabled' => 'opx_feed_back::manage.filter_value_read', 'disabled' => 'opx_feed_back::manage.filter_value_not_read'],
        ];

        return $filters;
    }

    /**
     * Apply filters to query.
     *
     * @param EloquentBuilder $query
     * @param array $filters
     *
     * @return  EloquentBuilder
     */
    public function applyFilters(EloquentBuilder $query, array $filters): EloquentBuilder
    {
        $query = Filters::processDeletedFilter($query, $filters);
        $query = Filters::processEnabledFilter($query, $filters, 'checked');

        return $query;
    }

    /**
     * Get edit link.
     *
     * @return  string
     */
    protected function getEditLink(): ?string
    {
        return AdminAuthorization::can('opx_feed_back::notifications') ? 'opx_feed_back::feed_back_records_edit' : null;
    }

    /**
     * Get edit link.
     *
     * @return  string
     */
    protected function getEnableLink(): ?string
    {
        return AdminAuthorization::can('opx_feed_back::notifications_disable') ? 'manage/api/module/opx_feed_back/feed_back_records_actions/enable' : null;
    }

    /**
     * Get edit link.
     *
     * @return  string
     */
    protected function getDisableLink(): ?string
    {
        return AdminAuthorization::can('opx_feed_back::notifications_disable') ? 'manage/api/module/opx_feed_back/feed_back_records_actions/disable' : null;
    }

    /**
     * Get edit link.
     *
     * @return  string
     */
    protected function getDeleteLink(): ?string
    {
        return AdminAuthorization::can('opx_feed_back::notifications_delete') ? 'manage/api/module/opx_feed_back/feed_back_records_actions/delete' : null;
    }

    /**
     * Get edit link.
     *
     * @return  string
     */
    protected function getRestoreLink(): ?string
    {
        return AdminAuthorization::can('opx_feed_back::notifications_delete') ? 'manage/api/module/opx_feed_back/feed_back_records_actions/restore' : null;
    }


}