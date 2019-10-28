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
    	$this->get('/usuarios/10')
    			->assertStatus(200)
    			->assertSee('10');
    }

     /** @test */
    function it_load_the_new_user_page()
    {
    	$this->get('/usuarios/nuevo')
    			->assertStatus(200)
    			->assertSee('Creando nuevo usuario');
    }
}
