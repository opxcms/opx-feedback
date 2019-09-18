<?php

use Illuminate\Support\Facades\Schema;
use Core\Foundation\Database\OpxBlueprint;
use Core\Foundation\Database\OpxMigration;

class CreateFeedbackFormsTable extends OpxMigration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        $this->schema->create('feedback_forms', static function (OpxBlueprint $table) {
            $table->id();
            $table->name();
            $table->alias();
            $table->boolean('enabled')->nullable()->default(1);

            $table->string('from_email');
            $table->string('from_name')->nullable();
            $table->text('to_emails');
            $table->string('email_title')->nullable();

            $table->layout('form_layout');

            $table->string('form_title');
            $table->longText('form_disclaimer');
            $table->string('form_button_caption');

            $table->longText('success_message');
            $table->longText('error_message');

            $table->data();

            $table->timestamps();
            $table->softDeletes();

            $table->index(['id', 'alias']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::drop('feedback_forms');
    }
}
