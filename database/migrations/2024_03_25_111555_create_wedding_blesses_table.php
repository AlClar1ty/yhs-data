<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWeddingBlessesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wedding_blesses', function (Blueprint $table) {
            $table->increments('id');
            $table->string('male_name');
            $table->string('female_name');
            $table->datetime('datetime_bless');
            $table->string('address_bless');
            $table->text('description');
            $table->boolean('active')->default(true);
            $table->timestamps();
        });

        Schema::table('wedding_blesses', function (Blueprint $table) {
            $table->unsignedInteger("pastor_id")->nullable();
            $table->foreign("pastor_id")->references("id")->on("pastors");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wedding_blesses');
    }
}
