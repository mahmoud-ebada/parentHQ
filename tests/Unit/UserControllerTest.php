<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserControllerTest extends TestCase
{
    /**
     * List all users unit test.
     * @test
     * @return void
     */
    public function listAllUsers()
    {
        $response = $this->json('GET', 'api/v1/users');
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'statusCode',
            'data' => [
                [
                    'id',
                    'email',
                    'amount',
                    'currency',
                    'status_code',
                    'created_at'
                ]
            ]
        ]);
    }

    /**
     * Filter users unit test. 
     * @test
     * @return void
     */
    public function filterUsers(){
        $params = [
            'provider' => 'DataProviderX',
            '&tatusCode' => 'authorised'
        ];
        $response = $this->json('GET', 'api/v1/users', $params);
        $response->assertStatus(200);
    }

    /**
     * Missing DataProvider class unit test.
     * @test
     * @return void
     */
    public function missingDataProviderClass(){
        $params = [
            'provider' => 'DataProviderM'
        ];
        $response = $this->json('GET', 'api/v1/users', $params);
        $response->assertStatus(422);
        $response->assertJson([
            'error' => [
                'name' => 'DataProviderNotFound'
            ]
        ]);
    }

    /**
     * Missing DataProvider Json File unit test.
     * @test
     * @return void
     */
    public function missingDataProviderJsonFile(){
        $params = [
            'provider' => 'DataProviderZ'
        ];
        $response = $this->json('GET', 'api/v1/users', $params);
        $response->assertStatus(422);
        $response->assertJson([
            'error' => [
                'name' => 'DataProviderJsonFileNotFound'
            ]
        ]);
    }
}
