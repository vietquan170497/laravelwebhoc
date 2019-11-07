<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDangkikhoahoc extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dangkikhoahoc', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('idKhoaHoc',false,true);
            $table->integer('idUser',false,true);
            $table->decimal('TongTien',15,2);
            $table->integer('TrangThai');
            $table->timestamp('created_at')->default(\DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(\DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('dangkikhoahoc');
    }
}
