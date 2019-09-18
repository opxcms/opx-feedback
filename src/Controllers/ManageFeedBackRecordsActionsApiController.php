<?php

namespace Modules\Opx\FeedBack\Controllers;

use Core\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Exception;
use Modules\Opx\FeedBack\Models\FeedbackRecord;

class ManageFeedBackRecordsActionsApiController extends Controller
{
    /**
     * Delete records with given ids.
     *
     * @param Request $request
     * @return JsonResponse
     *
     * @throws Exception
     */
    public function postDelete(Request $request): JsonResponse
    {
        $ids = $request->all();

        /** @var EloquentBuilder $records */
        $records = FeedbackRecord::query()->whereIn('id', $ids)->get();

        if ($records->count() > 0) {
            /** @var FeedbackRecord $record */
            foreach ($records as $record) {
                $record->delete();
            }
        }

        return response()->json(['message' => 'success']);
    }

    /**
     * Restore records with given ids.
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function postRestore(Request $request): JsonResponse
    {
        $ids = $request->all();

        /** @var EloquentBuilder $records */
        $records = FeedbackRecord::query()->whereIn('id', $ids)->onlyTrashed()->get();

        if ($records->count() > 0) {
            /** @var FeedbackRecord $record */
            foreach ($records as $record) {
                $record->restore();
            }
        }

        return response()->json(['message' => 'success']);
    }

    /**
     * Enable records with given ids.
     *
     * @param Request $request
     *
     * @return  JsonResponse
     */
    public function postEnable(Request $request): JsonResponse
    {
        $ids = $request->all();

        /** @var EloquentBuilder $records */
        $records = FeedbackRecord::query()->whereIn('id', $ids)->get();

        if ($records->count() > 0) {
            /** @var FeedbackRecord $record */
            foreach ($records as $record) {
                if (!(bool)$record->getAttribute('checked')) {
                    $record->setAttribute('checked', true);
                    $record->save();
                }
            }
        }

        return response()->json(['message' => 'success']);
    }

    /**
     * Disable records with given ids.
     *
     * @param Request $request
     *
     * @return  JsonResponse
     */
    public function postDisable(Request $request): JsonResponse
    {
        $ids = $request->all();

        /** @var EloquentBuilder $records */
        $records = FeedbackRecord::query()->whereIn('id', $ids)->get();

        if ($records->count() > 0) {
            /** @var FeedbackRecord $record */
            foreach ($records as $record) {
                if ((bool)$record->getAttribute('checked')) {
                    $record->setAttribute('checked', false);
                    $record->save();
                }
            }
        }

        return response()->json([
            'message' => 'success',
        ]);
    }
}