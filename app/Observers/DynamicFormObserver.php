<?php

namespace App\Observers;

use App\Models\DynamicForm;

class DynamicFormObserver extends ObserverFactory {

    public function saved(DynamicForm $dynamicForm)
    {
        if ($dynamicForm->wasRecentlyCreated) {
            $dynamicForm->syncToRelationship("dynamicFields");
            $dynamicForm->setAttribute($dynamicForm->formKey, $dynamicForm->generateFormJson());
            $dynamicForm->saveQuietly();
        }
    }
}