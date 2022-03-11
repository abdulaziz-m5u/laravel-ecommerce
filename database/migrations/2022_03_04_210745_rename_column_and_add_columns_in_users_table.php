<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameColumnAndAddColumnsInUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('name')->nullable()->change();
			$table->renameColumn('name', 'username');
			$table->string('first_name')->nullable()->after('name');
			$table->string('last_name')->nullable()->after('first_name');
			$table->string('phone')->nullable()->after('email');
			$table->string('address1')->nullable()->after('phone');
			$table->string('address2')->nullable()->after('address1');
			$table->integer('province_id')->nullable()->after('address2');
			$table->integer('city_id')->nullable()->after('province_id');
			$table->integer('postcode')->nullable()->after('city_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
}
