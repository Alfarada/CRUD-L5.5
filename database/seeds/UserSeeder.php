<?php

use App\User;
use App\Model\Profession;
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

        $professionId = Profession::where('title','Desarrollador back-end')->value('id'); 

        //dd($professionId);

        User::create([
        	'name'		=> 'Alfredo Yepez',
        	'email'		=>'sabryrodriguez09@gmail.com',
        	'password' 	=>bcrypt('Laravel'),
            'profession_id' => $professionId
        ]);
    }
}
