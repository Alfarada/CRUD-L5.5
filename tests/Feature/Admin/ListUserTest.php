<?php

namespace Tests\Feature\Admin;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ListUserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function it_shows_the_users_list()
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

    function it_show_a_default_message_if_the_users_list_is_empty()
    {   
        $this->get('/usuarios')
            ->assertStatus(200)
            ->assertSee('No hay usuarios registrados');
    }
}
