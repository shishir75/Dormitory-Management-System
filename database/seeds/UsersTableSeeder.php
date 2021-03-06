<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table( 'users' )->insert( [
            'role_id'  => 1,
            'name'     => 'Md. Register',
            'email'    => 'register@gmail.com',
            'password' => bcrypt( 12345678 ),
        ] );

        DB::table( 'users' )->insert( [
            'role_id'  => 2,
            'name'     => 'Institute of Information Technology',
            'email'    => 'iit-office@gmail.com',
            'password' => bcrypt( 12345678 ),
        ] );

        DB::table( 'users' )->insert( [
            'role_id'  => 3,
            'name'     => 'Rabindranath Tagore Hall',
            'email'    => 'rth_office@gmail.com',
            'password' => bcrypt( 12345678 ),
        ] );

        DB::table( 'users' )->insert( [
            'role_id'  => 5,
            'name'     => 'Rabindranath Tagore Hall Dining',
            'email'    => 'rth_dining@gmail.com',
            'password' => bcrypt( 12345678 ),
        ] );

    }
}
