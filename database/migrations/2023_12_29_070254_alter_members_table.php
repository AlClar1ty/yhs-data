<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class AlterMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("ALTER TABLE `members` CHANGE `type` `type` ENUM('suami','istri','anak','single') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL");
        DB::statement("ALTER TABLE `members` CHANGE `phone` `phone` VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL;");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("ALTER TABLE `members` CHANGE `type` `type` ENUM('suami','istri','anak') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL");
        DB::statement("ALTER TABLE `members` CHANGE `phone` `phone` VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL;");
    }
}
