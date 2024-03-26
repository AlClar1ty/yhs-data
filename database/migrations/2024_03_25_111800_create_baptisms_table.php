<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBaptismsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('baptisms', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->enum('gender', ['pria', 'wanita']);
            $table->date('tgl_lahir');
            $table->string('tempat_lahir');
            $table->string('father_name')->nullable();
            $table->string('mother_name')->nullable();
            $table->string('phone');
            $table->text('alamat');
            $table->date('baptism_date');
            $table->text('description');
            $table->boolean('active')->default(true);
            $table->timestamps();
        });

        Schema::table('baptisms', function (Blueprint $table) {
            $table->unsignedInteger("consellour_id")->nullable();
            $table->foreign("consellour_id")->references("id")->on("pastors");

            $table->unsignedInteger("baptized_by_id")->nullable();
            $table->foreign("baptized_by_id")->references("id")->on("pastors");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('baptisms');
    }
}
