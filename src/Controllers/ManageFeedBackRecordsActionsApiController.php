<?php

namespace Modules\Opx\FeedBack\Controllers;

use Core\Http\Controllers\ApiActionsController;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Exception;
use Modules\Opx\FeedBack\Models\FeedbackRecord;

class ManageFeedBackRecordsActionsApiController extends ApiActionsController
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
        return $this->deleteModels(FeedbackRecord::class, $request->all(), 'opx_feed_back::notifications_delete');
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
        return $this->restoreModels(FeedbackRecord::class, $request->all(), 'opx_feed_back::notifications_delete');
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
        return $this->enableModels(FeedbackRecord::class, $request->all(), 'checked','opx_feed_back::notifications_disable');
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
        return $this->disableModels(FeedbackRecord::class, $request->all(), 'checked','opx_feed_back::notifications_disable');
    }
}