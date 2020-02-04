<?php

namespace Modules\Opx\FeedBack\Controllers;

use Core\Foundation\Templater\Templater;
use Core\Http\Controllers\APIFormController;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\Admin\Authorization\AdminAuthorization;
use Modules\Opx\FeedBack\Models\FeedbackForm;
use Modules\Opx\FeedBack\OpxFeedBack;

class ManageFeedBackFormsEditApiController extends APIFormController
{
    public $addCaption = 'opx_feed_back::manage.add_form';
    public $editCaption = 'opx_feed_back::manage.edit_form';
    public $create = 'manage/api/module/opx_feed_back/feed_back_forms_edit/create';
    public $save = 'manage/api/module/opx_feed_back/feed_back_forms_edit/save';
    public $redirect = '/forms/edit/';

    /**
     * Make form add form.
     *
     * @return  JsonResponse
     */
    public function getAdd(): JsonResponse
    {
        if(!AdminAuthorization::can('opx_feed_back::add')) {
            return $this->returnNotAuthorizedResponse();
        }

        $template = new Templater(OpxFeedBack::getTemplateFileName('feedback_form.php'));

        $template->fillDefaults();

        return $this->responseFormComponent(0, $template, $this->addCaption, $this->create);
    }

    /**
     * Make form edit form.
     *
     * @param Request $request
     *
     * @return  JsonResponse
     */
    public function getEdit(Request $request): JsonResponse
    {
        if(!AdminAuthorization::can('opx_feed_back::edit')) {
            return $this->returnNotAuthorizedResponse();
        }

        /** @var FeedbackForm $form */
        $id = $request->input('id');
        $form = FeedbackForm::withTrashed()->where('id', $id)->firstOrFail();

        $template = $this->makeTemplate($form, 'feedback_form.php');

        return $this->responseFormComponent($id, $template, $this->editCaption, $this->save);
    }

    /**
     * Create new form.
     *
     * @param Request $request
     *
     * @return  JsonResponse
     */
    public function postCreate(Request $request): JsonResponse
    {
        if(!AdminAuthorization::can('opx_feed_back::add')) {
            return $this->returnNotAuthorizedResponse();
        }

        $template = new Templater(OpxFeedBack::getTemplateFileName('feedback_form.php'));

        $template->resolvePermissions();

        $template->fillValuesFromRequest($request);

        if (!$template->validate()) {
            return $this->responseValidationError($template->getValidationErrors());
        }

        $values = $template->getEditableValues();

        $form = $this->updateFormData(new FeedbackForm(), $values);

        // Refill template
        $template = $this->makeTemplate($form, 'feedback_form.php');

        return $this->responseFormComponent($form->getAttribute('id'), $template, $this->editCaption, $this->save, $this->redirect . $form->getAttribute('id'));
    }

    /**
     * Save form.
     *
     * @param Request $request
     *
     * @return  JsonResponse
     */
    public function postSave(Request $request): JsonResponse
    {
        if(!AdminAuthorization::can('opx_feed_back::edit')) {
            return $this->returnNotAuthorizedResponse();
        }

        /** @var FeedbackForm $form */
        $id = $request->input('id');

        $form = FeedbackForm::withTrashed()->where('id', $id)->firstOrFail();

        $template = new Templater(OpxFeedBack::getTemplateFileName('feedback_form.php'));

        $template->resolvePermissions();

        $template->fillValuesFromRequest($request);

        if (!$template->validate(['id' => $id])) {
            return $this->responseValidationError($template->getValidationErrors());
        }

        $values = $template->getEditableValues();

        $form = $this->updateFormData($form, $values);

        // Refill template
        $template = $this->makeTemplate($form, 'feedback_form.php');

        return $this->responseFormComponent($id, $template, $this->editCaption, $this->save);
    }

    /**
     * Fill template with data.
     *
     * @param string $filename
     * @param FeedbackForm $form
     *
     * @return  Templater
     */
    protected function makeTemplate(FeedbackForm $form, $filename): Templater
    {
        $template = new Templater(OpxFeedBack::getTemplateFileName($filename));

        $template->fillValuesFromObject($form);

        return $template;
    }

    /**
     * Update form data
     *
     * @param FeedbackForm $form
     * @param array $data
     *
     * @return  FeedbackForm
     */
    protected function updateFormData(FeedbackForm $form, array $data): FeedbackForm
    {
        $this->setAttributes($form, $data, [
            'alias', 'name', 'enabled',
            'from_email', 'from_name', 'to_emails', 'email_title',
            'form_layout',
            'form_title', 'form_disclaimer', 'form_button_caption',
            'success_message', 'error_message',
        ]);

        $form->save();

        return $form;
    }
}