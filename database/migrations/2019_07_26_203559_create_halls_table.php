<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHallsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create( 'halls', function ( Blueprint $table ) {
            $table->bigIncrements( 'id' );
            $table->string( 'name' )->unique();
            $table->string( 'slug' )->unique();
            $table->string( "short_name" )->unique();
            $table->string( "for_male_female", 1 )->default( "M" );
            $table->integer( "total_seat" );
            $table->integer( "available_seat" );
            $table->timestamps();
        } );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists( 'halls' );
    }
}
