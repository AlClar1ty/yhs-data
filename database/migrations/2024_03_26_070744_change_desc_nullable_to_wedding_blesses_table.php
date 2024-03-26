<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class ChangeDescNullableToWeddingBlessesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('wedding_blesses', function (Blueprint $table) {
            DB::statement("ALTER TABLE `wedding_blesses` CHANGE `description` `description` TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL;");
            $table->integer("district_id");
        });
        Schema::table('baptisms', function (Blueprint $table) {
            DB::statement("ALTER TABLE `baptisms` CHANGE `description` `description` TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL;");
            $table->integer("district_id");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('wedding_blesses', function (Blueprint $table) {
            DB::statement("ALTER TABLE `wedding_blesses` CHANGE `description` `description` TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL;");
            $table->dropColumn("district_id");
        });
        Schema::table('baptisms', function (Blueprint $table) {
            DB::statement("ALTER TABLE `baptisms` CHANGE `description` `description` TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL;");
            $table->dropColumn("district_id");
        });
    }
}
