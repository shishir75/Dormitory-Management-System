<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HallTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table( 'halls' )->insert( [
            'name'        => 'Rabindranath Tagore Hall',
            'slug'        => 'rabindranath-tagore-hall',
            'short_name'  => 'RTH',
            'is_for_male' => true,
        ] );

        DB::table( 'halls' )->insert( [
            'name'        => 'Sheikh Hasina Hall',
            'slug'        => 'sheikh-hasina-hall',
            'short_name'  => 'SHH',
            'is_for_male' => false,
        ] );
    }
}
