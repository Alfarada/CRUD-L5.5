<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class WelcomeUserTest extends TestCase
{
    /** @test */
    function it_welcomes_users_with_nickname()
    {
    	$this->get('/saludo/Alfredo/alfarada')
    			->assertStatus(200)
    			->assertSee('Bienvenido Alfredo, tu apodo es alfarada ');
    }

      /** @test */
    function it_welcomes_users_without_nickname()
    {
    	$this->get('/saludo/Alfredo')
    			->assertStatus(200)
    			->assertSee('Bienvenido Alfredo');
    }
}
