<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddValueQrcodeInRandomLinkCustomLink extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('random_links', function (Blueprint $table) {
            $table->string("qrcode",50)->nullable();
        });

        Schema::table('custom_links', function (Blueprint $table) {
            $table->string("qrcode",50)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

    }
}
