<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

abstract class UnitFactory extends TestCase
{
    use DatabaseMigrations;
    
}