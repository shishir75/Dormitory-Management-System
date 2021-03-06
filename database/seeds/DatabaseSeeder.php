<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call( UsersTableSeeder::class );
        $this->call( RolesTableSeeder::class );
        $this->call( SessionsTableSeeder::class );
        $this->call( DeptsTableSeeder::class );
        $this->call( HallTableSeeder::class );
        $this->call( StudentsTableSeeder::class );
        $this->call( DiningSeeder::class );
    }
}
