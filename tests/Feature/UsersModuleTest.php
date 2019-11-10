<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use App\Model\Profession;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UsersModuleTest extends TestCase
{
    use RefreshDatabase;

    /**
    * @test */
    function it_loads_the_users_list_page()
    {


        $professionId = Profession::where('title','Desarrollador back-end')->value('id'); 

        factory(User::class)->create([
            'name'      => 'Alfredo',
            'email'     =>'sabryrodriguez09@gmail.com',
            'password'  =>bcrypt('Laravel'),
            'profession_id' => $professionId, 
            'is_admin' => true
        ]);

        factory(User::class)->create([
            'name' => 'Bob',
        ]);

        factory(User::class)->create([
            'name' => 'Ted' 
        ]);

        $this->get('/usuarios')
        		->assertStatus(200)
        		->assertSee('listado de usuarios')
                ->assertSee('Alfredo')
                ->assertSee('Bob')
                ->assertSee('Ted');
    }
    
    /** @test */
    function it_load_the_users_details_page()
    {
    	$this->get('/usuarios/10')
    			->assertStatus(200)
    			->assertSee('10');
    }

    /**
    * @test */
    function it_show_a_default_message_if_the_users_list_is_empty()
    {
        //DB::table('users')->truncate();

        $this->get('/usuarios')
                ->assertStatus(200)
                ->assertSee('No hay usuarios registrados');
    }

     /** @test */
    function it_load_the_new_user_page()
    {
    	$this->get('/usuarios/nuevo')
    			->assertStatus(200)
    			->assertSee('Creando nuevo usuari');
    }
}
