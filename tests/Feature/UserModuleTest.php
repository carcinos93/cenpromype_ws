<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserModuleTest extends TestCase
{
    /**
     * Prueba de metodo de detalle de usuarios
     * @test
     */
    function it_loads_the_users_list_page()
    {
        $response = $this->get('/usuarios/500');

        $response->assertStatus(200);

       $response->assertSee('Informacion');
    }

    /**
     * Prueba de usuarios
     * @test
     */
    function it_loads_the_users_page() {
        $response = $this->get('/usuarios');

        $response->assertStatus(200);

       $response->assertSee('Usuarios');
    }

    /**
     * Prueba de usuarios
     * @test
     */
    function it_loads_the_users_page_empty() {
        $response = $this->get('/usuarios?empty');

        $response->assertStatus(200);

        $response->assertSee('No hay lista de usuarios');
    }
    /**
     * Prueba de usuarios
     * @test
     */
    function it_loads_the_user_create() {
        $response = $this->get('/usuarios/nuevo');


        $response->assertStatus(200);


       $response->assertSee('nuevo usuario');
    }

    /***
     * Prueba de show
     * @test
     */
    function it_loads_the_user_show() {
        $response = $this->get('/usuarios/55');

        $response->assertStatus(200);

        $response->assertSee("Mostrando detalle de usuario 55");
    }
}
