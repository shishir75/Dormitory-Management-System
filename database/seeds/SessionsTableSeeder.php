<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SessionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table( 'sessions' )->insert( [
            'name' => '2014-15',
        ] );

        DB::table( 'sessions' )->insert( [
            'name' => '2015-16',
        ] );

        DB::table( 'sessions' )->insert( [
            'name' => '2016-17',
        ] );

        DB::table( 'sessions' )->insert( [
            'name' => '2017-18',
        ] );

        DB::table( 'sessions' )->insert( [
            'name' => '2018-19',
        ] );

        DB::table( 'sessions' )->insert( [
            'name' => '2019-20',
        ] );

        DB::table( 'sessions' )->insert( [
            'name' => '2020-21',
        ] );

    }
}
