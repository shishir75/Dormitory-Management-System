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
        $faker = Faker\Factory::create();

        for ( $i = 0; $i < 5; $i++ ) {
            DB::table( 'depts' )->insert( [
                'name'        => $name = $faker->unique()->firstNameMale,
                'slug'        => Str::slug( $name ),
                'short_name'  => $name,
                'is_semester' => false,
            ] );

        }

    }
}
