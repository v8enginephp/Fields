<?php

use Illuminate\Database\Capsule\Manager as DB;
use Illuminate\Database\Schema\Blueprint;

DB::schema()->create('fields', function (Blueprint $table) {
    $table->id();
    //Table columns here.
    $table->timestamps();
});