<?php

namespace Modules\Opx\FeedBack\Controllers;

use Core\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Exception;
use Modules\Opx\FeedBack\Models\FeedbackForm;

class ManageFeedBackFormsActionsApiController extends Controller
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
        $ids = $request->all();

        /** @var EloquentBuilder $forms */
        $forms = FeedbackForm::query()->whereIn('id', $ids)->get();

        if ($forms->count() > 0) {
            /** @var FeedbackForm $form */
            foreach ($forms as $form) {
                $form->delete();
            }
        }

        return response()->json(['message' => 'success']);
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
        $ids = $request->all();

        /** @var EloquentBuilder $forms */
        $forms = FeedbackForm::query()->whereIn('id', $ids)->onlyTrashed()->get();

        if ($forms->count() > 0) {
            /** @var FeedbackForm $form */
            foreach ($forms as $form) {
                $form->restore();
            }
        }

        return response()->json(['message' => 'success']);
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
        $ids = $request->all();

        /** @var EloquentBuilder $forms */
        $forms = FeedbackForm::query()->whereIn('id', $ids)->get();

        if ($forms->count() > 0) {
            /** @var FeedbackForm $form */
            foreach ($forms as $form) {
                if (!(bool)$form->getAttribute('enabled')) {
                    $form->setAttribute('enabled', true);
                    $form->save();
                }
            }
        }

        return response()->json(['message' => 'success']);
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
        $ids = $request->all();

        /** @var EloquentBuilder $forms */
        $forms = FeedbackForm::query()->whereIn('id', $ids)->get();

        if ($forms->count() > 0) {
            /** @var FeedbackForm $form */
            foreach ($forms as $form) {
                if ((bool)$form->getAttribute('enabled')) {
                    $form->setAttribute('enabled', false);
                    $form->save();
                }
            }
        }

        return response()->json([
            'message' => 'success',
        ]);
    }
}