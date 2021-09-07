<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create( 'students', function ( Blueprint $table ) {
            $table->bigIncrements( 'id' );
            $table->string( 'name' );
            $table->unsignedBigInteger( 'session_id' );
            $table->unsignedBigInteger( 'dept_id' );
            $table->bigInteger( 'reg_no' );
            $table->integer( 'hall_id' )->nullable();
            $table->integer( "room_no" )->nullable();
            $table->boolean( "status" )->default( true );
            $table->string( "sex", 1 )->default( "M" );
            $table->timestamps();
            $table->foreign( 'dept_id' )->references( 'id' )->on( 'depts' )->onDelete( 'cascade' );
            $table->foreign( 'session_id' )->references( 'id' )->on( 'sessions' )->onDelete( 'cascade' );
        } );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists( 'students' );
    }
}
