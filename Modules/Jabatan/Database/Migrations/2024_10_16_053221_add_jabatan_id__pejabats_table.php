<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddJabatanIDPejabatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pejabats', function (Blueprint $table) {
			#$table->string('jabatan_id')->after('id');
			$table->bigInteger('jabatan_id')->unsigned()->after('id')->index(); 
			$table->dropColumn('jabatan');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pejabats', function (Blueprint $table) {
			$table->dropColumn('jabatan_id');
			$table->char('jabatan', 100);
        });
    }
}
