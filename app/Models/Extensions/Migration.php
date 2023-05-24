<?php

namespace App\Models\Extensions;

use DB;
use Illuminate\Database\Migrations\Migration as CoreMigration;
use App\Models\Extensions\Blueprint;

class Migration extends CoreMigration {
    
    protected $schema;
    
    public function __construct()
    {
        $this->schema = DB::connection()->getSchemaBuilder();
        $this->schema->blueprintResolver(function ($table, $callback) {
            return new Blueprint($table, $callback);
        });
    }
    
}