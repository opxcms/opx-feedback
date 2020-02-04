<?php

namespace Modules\Opx\FeedBack\Controllers;

use Core\Http\Controllers\ApiActionsController;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Exception;
use Modules\Opx\FeedBack\Models\FeedbackForm;

class ManageFeedBackFormsActionsApiController extends ApiActionsController
{
    /**
     * Delete forms with given ids.
     *
     * @param Request $request
     * @return JsonResponse
     *
     * @throws Exception
     */
    public function postDelete(Request $request): JsonResponse
    {
        return $this->deleteModels(FeedbackForm::class, $request->all(), 'opx_feed_back::delete');
    }

    /**
     * Restore forms with given ids.
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function postRestore(Request $request): JsonResponse
    {
        return $this->restoreModels(FeedbackForm::class, $request->all(), 'opx_feed_back::delete');
    }

    /**
     * Enable forms with given ids.
     *
     * @param Request $request
     *
     * @return  JsonResponse
     */
    public function postEnable(Request $request): JsonResponse
    {
        return $this->enableModels(FeedbackForm::class, $request->all(), 'enabled', 'opx_feed_back::disable');
    }

    /**
     * Disable forms with given ids.
     *
     * @param Request $request
     *
     * @return  JsonResponse
     */
    public function postDisable(Request $request): JsonResponse
    {
        return $this->disableModels(FeedbackForm::class, $request->all(), 'enabled', 'opx_feed_back::disable');
    }
}