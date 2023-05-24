<?php

namespace App\Models;

use App\Models\Traits\HasEventsObserver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;


abstract class ModelFactory extends Model
{
    use HasFactory, HasEventsObserver;

    private $payload;

    protected function setPayload($request)
    {
        $this->payload = $request;
    }

    protected function getPayload()
    {
        return $this->payload;
    }

    /**
     * Carica e manipola i dati in base ad un Behavior
     * Da implementare nella classe Behavior.
     *
     * @param \Illuminate\Http\Request $request
     * @return void
     */
    protected function loadBehaviors()
    {
    }

    /**
     * Sincronizza tutte le relazioni.
     * Da implementare nella classe modello.
     *
     * @param \Illuminate\Http\Request $request
     * @return void
     */
    protected function syncRelationships()
    {
    }

    /**
     * Salva i dati della richiesta in database.
     *
     * @param \Illuminate\Http\Request $request
     * @return bool | static
     */
    public function saveItem($request)
    {
        $this->setPayload($request);
        $this->loadBehaviors();
        $this->syncInputToModel();
        if ($this->save()) {
            $this->syncRelationships();
            $this->unsetPayload();
            return $this;
        }
        return false;
    }

    protected function unsetPayload()
    {
        $this->payload = null;
    }

    public function toName($snakeCase = false)
    {
        return $snakeCase ? Str::snake(class_basename($this)) : Str::lower(class_basename($this));
    }

    protected function syncInputToModel(array $override = [])
    {
        if (!is_array($this->payload)) {
            $request_input = $this->payload->input();
        } else {
            $request_input = [];
        }

        if (count($override)) {
            $request_input = Arr::except($request_input, array_keys($override));
        }
        $filling = array_combine(
            array_keys($request_input),
            array_map(function ($i) {
                return $i === "" ? null : $i;
            }, $request_input)
        );

        $this->fill(array_merge($filling, $override));
        return $this;
    }

    /**
     * Synchronize a relationship based on the provided parameters.
     *
     * @param string $relation The name of the relationship method
     * @param \Illuminate\Http\Request|null $request The request
     * @param bool $detaching Whether to detach existing related models
     * @return $this
     */
    public function syncToRelationship($relation, $request = null, $detaching = true)
    {
        if (is_null($request)) {
            $request = $this->getPayload();
        }

        if ($request) {
            $payloadName = Str::snake(Str::singular(is_object($relation) ? class_basename($relation) : $relation));

            if (method_exists($this, $relation) || is_callable([$this, $relation])) {
                $relationBuilder = $this->{$relation}();
                // Many-to-many relationship
                if ($relationBuilder instanceof BelongsToMany && $request->has($payloadName) && is_array($request->input($payloadName))) {
                    $relationBuilder->sync($request->input($payloadName), $detaching);
                }
                // Single model relationship (with or without pivot)
                else {
                    if ($request->has($payloadName)) {
                        $foreignKey = $payloadName;
                    } else {
                        $foreignKey = method_exists($relationBuilder, 'getRelatedPivotKeyName')
                            ? $relationBuilder->getRelatedPivotKeyName()
                            : $relationBuilder->getForeignKeyName();
                    }

                    if ($request->has($foreignKey)) {
                        $relationModels = $request->input($foreignKey);

                        if (!is_array($relationModels)) {
                            $relationModels = [$relationModels];
                        }

                        if ($relationBuilder instanceof HasMany) {
                            // Models that cannot exist without related models
                            $related = $relationBuilder->getRelated()->whereIn($relationBuilder->getRelated()->getKeyName(), $relationModels)->get();
                            $relationBuilder->saveMany($related);
                        } else {
                            // Primary key as index of a pivot payload
                            foreach ($relationModels as $relationModel) {
                                if (is_array($relationModel)) {
                                    $relationModel = key($relationModel);
                                }

                                $relatedModel = $relationBuilder->getRelated();

                                if ($related = $relatedModel->find($relationModel)) {
                                    if ($relationBuilder instanceof BelongsToMany && $relationBuilder->getParent()->getKey()) {
                                        $relationBuilder->sync(
                                            [$related->getKey() => $request->has('pivots') ? $request->input('pivots') : []],
                                            $detaching
                                        );
                                    } elseif (method_exists($relationBuilder, 'associate')) {
                                        $relationBuilder->associate($related);
                                    } else {
                                        $relationBuilder->save($related);
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        return $this;
    }
}
