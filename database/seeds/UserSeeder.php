<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //$professions = DB::select('SELECT id FROM professions WHERE title = ? LIMIT 0,1',['Desarrollador back-end']); 

        //dd($professionId);

        DB::table('users')->insert([
        	'name'		=> 'Alfredo Yepez',
        	'email'		=>'sabryrodriguez09@gmail.com',
        	'password' 	=>bcrypt('Laravel'),
            'profession_id' => DB::table('professions')->whereTitle('Desarrollador back-end')->value('id')
        ]);
    }
}
