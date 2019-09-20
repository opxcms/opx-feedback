<?php

namespace Modules\Opx\FeedBack;

use Core\Foundation\Module\BaseModule;
use Illuminate\Support\Facades\Event;
use Modules\Opx\FeedBack\Events\NewFeedbackRecord;
use Modules\Opx\FeedBack\Listeners\NewFeedbackListener;
use Modules\Opx\FeedBack\Models\FeedbackForm;

class FeedBack extends BaseModule
{
    /** @var string  Module name */
    protected $name = 'opx_feed_back';

    /** @var string  Module path */
    protected $path = __DIR__;

    /**
     * Render form by alias.
     *
     * @param string $alias
     * @param array $options
     *
     * @return  string|mixed
     */
    public function form(string $alias, array $options = [])
    {
        /** @var FeedbackForm $form */
        $form = FeedbackForm::where('alias', $alias)->first();

        if ($form === null) {
            return "Form {$alias} not found.";
        }

        $layout = str_replace('.blade.php', '', $form->getAttribute('form_layout'));

        return $this->view($layout)->with(array_merge($options, ['form' => $form]));
    }

    public function boot(): void
    {
        parent::boot();

        Event::listen(NewFeedbackRecord::class, NewFeedbackListener::class);
    }
}
