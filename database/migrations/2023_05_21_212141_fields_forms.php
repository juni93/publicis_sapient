<?php

use App\Models\DataType\Boolean;
use App\Models\DynamicField;
use App\Models\DynamicForm;
use App\Models\Extensions\Blueprint;
use App\Models\Extensions\Migration;
use App\Models\User;
use Illuminate\Support\Facades\Schema;

class FieldsForms extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->schema->create("dynamic_fields", function (Blueprint $table) {
            $table->id();
            $table->string("label");
            $table->unsignedTinyInteger("field_type");
            $table->unsignedTinyInteger("validation_type");
            $table->string("placeholder")->nullable();
            $table->integer("max_length")->default(255);
            $table->string("tool_tip")->nullable();
            $table->choice("is_required");
            $table->timestamps();
            $table->softDeletes();
        });
        $this->schema->create("dynamic_forms", function (Blueprint $table) {
            $table->id();
            $table->string("label")->nullable();
            $table->string("description")->nullable();
            $table->choice("is_active", Boolean::true());
            $table->json("form")->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
        $this->schema->create('dynamic_field_dynamic_form', function (Blueprint $table) {
            $table->foreignId('dynamic_form_id');
            $table->foreignId('dynamic_field_id');
            $table->primary(['dynamic_form_id', 'dynamic_field_id'], 'df_df_primary');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $this->schema->drop("dynamic_field_dynamic_form");
        $this->schema->drop("dynamic_fields");
        $this->schema->drop("dynamic_forms");
    }
}
