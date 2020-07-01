<?php

use App\{Skill, User, UserProfile};
use App\Model\Profession;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       $professionId = Profession::where('title','Desarrollador back-end')->value('id');

        $user = factory(User::class)->create([
            'name'      => 'Alfredo Yepez',
            'email'     =>'sabryrodriguez09@gmail.com',
            'password'  => bcrypt('laravel'),
            'role' => 'admin'
        ]);

        $user->profile()->create([
            'bio' => 'Programador, profesor, editor, escritor',
            'profession_id' => $professionId, 
        ]);
 
        factory(User::class, 29)->create()->each( function ($user) {
            $user->profile()->create(
                factory(UserProfile::class)->raw()
            );
        });

    }
}
