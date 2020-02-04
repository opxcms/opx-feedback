<?php

namespace Modules\Opx\FeedBack\Controllers;

use Core\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\Opx\FeedBack\Events\NewFeedbackRecord;
use Modules\Opx\FeedBack\FormParser;

class FeedBackController extends Controller
{
    /** @var FormParser */
    protected $parser;

    /**
     * FeedBackController constructor.
     */
    public function __construct()
    {
        $externalClass = '\Templates\Opx\FeedBack\FormParser';
        if (class_exists($externalClass)) {
            $this->parser = new $externalClass;
        } else {
            $this->parser = new FormParser();
        }
    }

    /**
     * Handle feedback form data.
     *
     * @param Request $request
     *
     * @return  JsonResponse
     */
    public function handleFeedback(Request $request): JsonResponse
    {
        $name = $request->input('name');
        $payload = $request->input('payload');

        // run form parser
        $record = $this->parser->parse($name, $payload);

        // add record with data
        $record->save();

        // fire event
        event(new NewFeedbackRecord($record));

        return response()->json(['message' => 'ok']);
    }
}