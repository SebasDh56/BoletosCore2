<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEmailToPersonasTable extends Migration
{
    public function up()
    {
        Schema::table('personas', function (Blueprint $table) {
            $table->string('email')->nullable()->after('edad');
        });
    }

    public function down()
    {
        Schema::table('personas', function (Blueprint $table) {
            $table->dropColumn('email');
        });
    }
}