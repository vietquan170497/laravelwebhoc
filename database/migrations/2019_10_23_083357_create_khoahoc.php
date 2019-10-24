<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKhoahoc extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('khoahoc', function (Blueprint $table) {
            $table->increments('id');
            $table->string('Ten');
            $table->text('TomTat');
            $table->string('HinhAnh');
            $table->integer('TraPhi');
            $table->decimal('GiaKhoaHoc',15,2);
            $table->integer('idLoaiKhoaHoc',false,true);
            $table->integer('TrangThai');
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
        Schema::drop('khoahoc');
    }
}
