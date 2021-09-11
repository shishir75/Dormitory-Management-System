<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DiningSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table( 'dinings' )->insert( [
            'name'    => 'Rabindranath Tagore Hall Dining',
            'email'   => 'rth_dining@gmail.com',
            'hall_id' => 1,
        ] );

        DB::table( 'dinings' )->insert( [
            'name'    => 'Sheikh Hasina Hall Dining',
            'email'   => 'shh_dining@gmail.com',
            'hall_id' => 2,
        ] );
    }
}
