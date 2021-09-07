<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StudentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();

        for ( $i = 0; $i < 350; $i++ ) {
            DB::table( 'students' )->insert( [
                'name'       => $faker->name,
                'session_id' => rand( 1, 7 ),
                'dept_id'    => rand( 1, 5 ),
                'reg_no'     => rand( 40000, 50000 ),
                'sex'        => $faker->randomElement( ['M', 'F'] ),
                'hall_id'    => rand( 1, 22 ),
            ] );
        };

    }
}
