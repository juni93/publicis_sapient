<?php

namespace App\Models\Extensions;

use Illuminate\Database\Schema\Blueprint as CoreBlueprint;
use App\Models\DataType\Boolean;
use Illuminate\Support\Facades\DB;

/*
 * Lo sappiamo che Blueprint è Macroable, ma infilare tutte queste macro in un service provider, è fastidioso oltre che poco OOP.
 */

class Blueprint extends CoreBlueprint {

    public const CODE_LENGTH = 8; /* Massimo numero di caratteri per identificare un record */
    public const NUMBER_LENGTH = 9; /* Massimo numero di cifre numeriche prima dei decimali */

    public function active($field = "active", $default = "on")
    {
        return $this->enum($field, ["on", "off"])->default($default);
    }

    public function choice($field, $default = "N")
    {
        return $this->enum($field, Boolean::CHOICES)->default($default);
    }

    /**
     * Crea un campo per i codici.
     *
     * @param boolean $length Quanti caratteri avrà il campo codice.
     * @param string $prefix Nome del campo che verrà prefisso a "_code".
     * @return \Illuminate\Database\Schema\ColumnDefinition
     */
    public function code($length = self::CODE_LENGTH, $prefix = null)
    {
        return ! $prefix
            ? $this->string("code", $length)
            : $this->string("{$prefix}_code", $length);
    }

    /**
     * Crea un campo per display name
     *
     * @param boolean $length Quanti caratteri avrà il campo codice.
     * @param string $suffix Nome del campo che verrà aggiunto a "display_".
     * @return \Illuminate\Database\Schema\ColumnDefinition
     */
    public function display($length = 3, $suffix = null)
    {
        return ! $suffix
            ? $this->string("display", $length)
            : $this->string("display_{$suffix}", $length);
    }

    /**
     * Crea un campo per una enumerazione che definisce il tipo del record.
     *
     * @param string $suffix Il suffisso opzionale da utilizzare nel nome della colonna.
     * @return \Illuminate\Database\Schema\ColumnDefinition
     */
    public function type(string $suffix = "")
    {
        return ! $suffix
            ? $this->unsignedTinyInteger("type")
            : $this->unsignedTinyInteger("{$suffix}_type");
    }

    public function foreignOne(string $class, $foreign_key = null, $indextype = "index", $indexname = null)
    {
        $this->{$indextype}($foreign_key ?: (new $class)->getForeignKey(), $indexname);
        return $this->foreignIdFor($class, $foreign_key);
    }

    /**
     * Crea una chiave esterna e una chiave primaria per ogni campo in $fields.
     *
     * @param array $fields La lista dei campi nel formato ["field"]
     * oppure ["field" => "N"] per una chiave esterna NULLABLE.
     * @param string $indextype Il tipo di indice a cui si riferisce la chiave esterna.
     * @param string $indexname il nome dell'indice
     * @return \App\Models\Extensions\Blueprint
     */
    public function foreignMany(array $fields, $indextype = null, $indexname = null)
    {
        if (count($fields)) {
            $index = [];
            foreach ($fields as $attribute => $foreign) {
                if ($foreign === "N") {
                    $model = $this->foreignIdFor($attribute)->nullable();
                } else {
                    $model = $this->foreignIdFor($foreign, is_numeric($attribute) ? null : $attribute);
                }
                $index[] = $model->name;
            }
            return $this->{$indextype ?? "primary"}($index, $indexname);
        }
        return $this;
    }

    public function primaryMorphing($name, $morphed_id)
    {
        $this->primary(array_merge([$morphed_id], $this->morphing($name)), $name);
        return $this;
    }

    public function morphing($name)
    {
        return [$name. "_type", $name . "_id"];
    }

    public function sortable()
    {
        return $this->unsignedBigInteger("sort_order")->nullable();
    }

    public function status($field)
    {
        return $this->unsignedTinyInteger($this->statusName($field));
    }

    public function typographySize($field = "default_size", $default = null)
    {
        $col = $this->unsignedSmallInteger($field);
        if ($default) {
            $col->default($default);
        }
        $col->nullable();
        return $this;
    }

    public function currency(string $column, int $max_int_digits = self::NUMBER_LENGTH, bool $unsigned = false)
    {
        return $this->double($column, $max_int_digits + 2, 2, $unsigned);
    }

    public function unsignedCurrency(string $column, int $max_int_digits = self::NUMBER_LENGTH)
    {
        return $this->currency($column, $max_int_digits, true);
    }

    public function changeColumn($column, $newColumnDefinition)
    {
        if (is_array($newColumnDefinition)) {
            $newColumnDefinition = "enum(" . implode(",", array_map(function($col) {
                return sprintf("'%s'", $col);
            }, $newColumnDefinition)). ")";
        }
        DB::statement("ALTER TABLE {$this->table} MODIFY $column $newColumnDefinition");
    }

}
