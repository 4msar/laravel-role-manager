<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePermissionRoleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(config('role_manager.database.role_permission_table'), function (Blueprint $table) {
            $table->unsignedInteger('role_id');
            $table->unsignedInteger('permission_id');

            $table->foreign('permission_id')
                ->references('id')
                ->on(config('role_manager.database.permission_table'))
                ->onDelete('cascade');

            $table->foreign('role_id')
                ->references('id')
                ->on(config('role_manager.database.role_table'))
                ->onDelete('cascade');

            $table->primary(['permission_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop(config('role_manager.database.role_permission_table'));
    }
}
