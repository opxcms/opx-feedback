<?php

use Illuminate\Support\Facades\Schema;
use Core\Foundation\Database\OpxBlueprint;
use Core\Foundation\Database\OpxMigration;

class CreateFeedbackRecordsTable extends OpxMigration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        $this->schema->create('feedback_records', static function (OpxBlueprint $table) {
            $table->id();
            $table->parentId('form_id');

            $table->string('title')->nullable();
            $table->string('contact_name')->nullable();
            $table->string('contact_email')->nullable();
            $table->string('contact_phone')->nullable();

            $table->boolean('checked')->nullable();

            $table->longText('payload');

            $table->timestamps();
            $table->softDeletes();

            $table->index(['id', 'checked']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::drop('feedback_records');
    }
}
