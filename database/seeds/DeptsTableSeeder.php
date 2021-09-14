<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DeptsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table( 'depts' )->insert( [
            'name'       => 'Institute of Information Technology',
            'short_name' => "IIT",
        ] );

        DB::table( 'depts' )->insert( [
            'name'       => 'Department of Mathamatics',
            'short_name' => "MATH",
        ] );

        $faker = Faker\Factory::create();

        for ( $i = 0; $i < 3; $i++ ) {
            DB::table( 'depts' )->insert( [
                'name'       => $name = $faker->unique()->firstNameMale,
                'short_name' => $name,
            ] );

        }

    }
}
