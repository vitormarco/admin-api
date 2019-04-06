<?php

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\User;

class EntrustTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = new Role(); 
		$admin->name = 'admin';
		$admin->display_name = "Administrator";
        $admin->save();
        
        //$vendedor = new Role(); 
		//$vendedor->name = 'vendedor';
		//$vendedor->display_name = "Vendedor";
        //$vendedor->save();
        
        $user = User::where('email', '=', 'master@gmail.com')->first();
		$user->attachRole($admin);
    }
}
