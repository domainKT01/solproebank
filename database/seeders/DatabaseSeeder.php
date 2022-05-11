<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        
        $user = new User();

        $user->setTable('compare_value');

        $user->bajoPeso = 18.50;

        $user->normalBajo = 22.5;

        $user->normalAlto = 25.0;

        $user->sobrepeso = 30.0;

        $user->save();
    }
}
