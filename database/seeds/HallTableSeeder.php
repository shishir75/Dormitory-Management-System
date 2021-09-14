<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

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
            'name'            => 'Rabindranath Tagore Hall',
            'short_name'      => 'RTH',
            'for_male_female' => "M",
            'total_seat'      => 1000,
            'available_seat'  => 70,
        ] );

        DB::table( 'halls' )->insert( [
            'name'            => 'Sheikh Hasina Hall',
            'short_name'      => 'SHH',
            'for_male_female' => "F",
            'total_seat'      => 1000,
            'available_seat'  => 65,
        ] );

        $faker = Faker\Factory::create();

        for ( $i = 0; $i < 20; $i++ ) {
            DB::table( 'halls' )->insert( [
                'name'            => $name = $faker->unique()->name,
                'short_name'      => Str::slug( $name ),
                'for_male_female' => $faker->randomElement( ["M", "F"] ),
                'total_seat'      => 1000,
                'available_seat'  => $faker->randomElement( [50, 60, 70, 80, 90, 100, 110, 120] ),
            ] );

        }
    }
}
