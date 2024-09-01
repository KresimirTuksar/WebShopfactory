<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDetailsToUsersTable extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('pricelist_id')->nullable()->after('id');
            $table->string('phone')->unique()->nullable()->after('email');
            $table->string('address')->nullable()->after('phone');
            $table->string('city')->nullable()->after('address');
            $table->string('country')->nullable()->after('city');

            // Dodavanje vanjskog ključa za pricelist_id
            $table->foreign('pricelist_id')->references('id')->on('pricelists')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            // Uklanjanje vanjskog ključa
            $table->dropForeign(['pricelist_id']);

            // Uklanjanje kolona
            $table->dropColumn(['pricelist_id', 'phone', 'address', 'city', 'country']);
        });
    }
}