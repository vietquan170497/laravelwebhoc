<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBaihoc extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('baihoc', function (Blueprint $table) {
            $table->increments('id');
            $table->string('TieuDe');
            $table->text('TomTat');
            $table->text('NoiDung');
            $table->string('HinhAnh');
            $table->integer('NoiBat');
            $table->integer('SoLuotXem');
            $table->integer('idKhoaHoc',false,true);
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
        Schema::drop('baihoc');
    }
}
