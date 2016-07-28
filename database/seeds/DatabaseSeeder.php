<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        Model::unguard();
        DB::table('users')->delete();

        $users = array(
                ['name' => 'Ryan Chie', 'email' => 'ryanc@gmail.com', 'password' => Hash::make('secret')],
                ['name' => 'Chris Cox', 'email' => 'chris@scotch.io', 'password' => Hash::make('secret')],
                ['name' => 'Fulton J', 'email' => 'Fultonj@scotch.io', 'password' => Hash::make('secret')],
                ['name' => 'Cass Mo', 'email' => 'Cmo@scotch.io', 'password' => Hash::make('secret')],
            );
        foreach($users as $user)
        {
          User::create($user);
        }
        Model::reguard();
    }
}
