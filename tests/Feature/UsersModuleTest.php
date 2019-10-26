<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UsersModuleTest extends TestCase
{
    /** @test */
    function it_loads_the_users_list_page()
    {
        $this->get('/usuarios')
        		->assertStatus(200)
        		->assertSee('usuarios')
        		->assertSee('Bob')
        		->assertSee('listado de usuarios');
    }
    
    /** @test */
    function it_load_the_users_details_page()
    {
    	$this->get('/usuarios/5')
    			->assertStatus(200)
    			->assertSee('5');
    }

     /** @test */
    function it_load_the_new_user_page()
    {
    	$this->get('/usuarios/nuevo')
    			->assertStatus(200)
    			->assertSee('Creando nuevo usuario');
    }
}
