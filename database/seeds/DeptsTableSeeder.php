<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

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
            'name'        => 'Institute of Information Technology',
            'slug'        => 'Institute-of-Information-Technology',
            'short_name'  => "IIT",
            'is_semester' => true,
        ] );

        DB::table( 'depts' )->insert( [
            'name'        => 'Department of Mathamatics',
            'slug'        => 'Department-of-Mathamatics',
            'short_name'  => "MATH",
            'is_semester' => false,
        ] );

        $faker = Faker\Factory::create();

        for ( $i = 0; $i < 3; $i++ ) {
            DB::table( 'depts' )->insert( [
                'name'        => $name = $faker->unique()->firstNameMale,
                'slug'        => Str::slug( $name ),
                'short_name'  => $name,
                'is_semester' => $faker->randomElement( ['True', 'False'] ),
            ] );

        }

    }
}
