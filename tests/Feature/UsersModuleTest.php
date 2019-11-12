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
        
        factory(User::class)->create([
            'name' => 'Bob',
        ]);

        factory(User::class)->create([
            'name' => 'Ted' 
        ]);

        $this->get('/usuarios')
        		->assertStatus(200)
        		->assertSee('listado de usuarios')
                ->assertSee('Bob')
                ->assertSee('Ted');
    }
    
    /** @test */
    function it_display_the_users_details()
    {
        $user = factory(User::class)->create([
            'name' => 'Alfredo Yepez'
        ]);

    	$this->get('/usuarios/'.$user->id) //usuario 5
    			->assertStatus(200)
    			->assertSee('Alfredo Yepez');
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
                ->assertSee('Crear Usuario');
    }

     /** @test */
    function it_displays_a_404_error_if_the_user_is_not_found()
    {
    	$this->get('/usuarios/999')
    			->assertStatus(404)
    			->assertSee('Página no encontrada');
    }
}
