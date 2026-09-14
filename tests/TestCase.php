<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Schema;

abstract class TestCase extends BaseTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        if (class_exists(\App\Models\Role::class) && Schema::hasTable('roles')) {
            \App\Models\Role::firstOrCreate(['id' => 1], ['nama' => 'admin']);
            \App\Models\Role::firstOrCreate(['id' => 2], ['nama' => 'konselor']);
            \App\Models\Role::firstOrCreate(['id' => 3], ['nama' => 'siswa']);
        }
    }
}
