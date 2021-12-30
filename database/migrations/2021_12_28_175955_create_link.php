<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLink extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // type_link = 0 --> Random Code Link
        // type_link = 1 --> custom Link

        Schema::create('links', function (Blueprint $table) {
            $table->id();
            $table->text("real_link");
            $table->tinyInteger("type_link");
            $table->timestamps();
        });

        Schema::create('random_links', function (Blueprint $table) {
            $table->id();
            $table->integer("link_id");
            $table->string("random_code",10);
            $table->timestamps();
        });

        Schema::create('custom_links', function (Blueprint $table) {
            $table->id();
            $table->integer("link_id");
            $table->text("alias");
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('link');
    }
}
