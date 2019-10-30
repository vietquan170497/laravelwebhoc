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
        Schema::drop('khoahoc');
    }
}
