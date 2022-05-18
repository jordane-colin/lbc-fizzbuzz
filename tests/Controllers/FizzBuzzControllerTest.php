<?php

namespace Controllers;

use App\Models\Stats;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;
use TestCase;

class FizzBuzzControllerTest extends TestCase
{
    use DatabaseMigrations;

    public function testFizzBuzzSuccess()
    {
        $query = [
            'int1' => '3',
            'int2' => '5',
            'limit' => '20',
            'str1' => 'Fizz',
            'str2' => 'Buzz',
        ];
        $this->get('/generate_fizzbuzz?'.http_build_query($query));
        $expected = '1,2,Fizz,4,Buzz,Fizz,7,8,Fizz,Buzz,11,Fizz,13,14,FizzBuzz,16,17,Fizz,19,Buzz';

        $this->seeInDatabase('stats', ['request' => json_encode($query, JSON_THROW_ON_ERROR)]);
        $this->seeStatusCode(200);
        $this->assertEquals(
            $expected, $this->response->getContent()
        );
    }

    public function testFizzBuzzWrongOrder()
    {
        $query = [
            'int1' => '3',
            'int2' => '5',
            'limit' => '20',
            'str1' => 'Fizz',
            'str2' => 'Buzz',
        ];
        $this->get('/generate_fizzbuzz?'.http_build_query($query));
        $expected = '1,2,Buzz,4,5,Fizz,Buzz,8,Fizz,Buzz,11,Fizz,13,14,FizzBuzz,16,17,Fizz,19,Buzz';

        $this->seeInDatabase('stats', ['request' => json_encode($query, JSON_THROW_ON_ERROR)]);
        $this->seeStatusCode(200);
        $this->assertNotEquals(
            $expected, $this->response->getContent()
        );
    }

    public function testFizzBuzzModuloFail()
    {
        $query = [
            'int1' => '0',
            'int2' => '5',
            'limit' => '20',
            'str1' => 'Fizz',
            'str2' => 'Buzz',
        ];
        $this->get('/generate_fizzbuzz?'. http_build_query($query));

        $this->notSeeInDatabase('stats', ['request' => json_encode($query, JSON_THROW_ON_ERROR)]);
        $this->seeStatusCode(400);
    }

    public function testFizzBuzzFailValidation()
    {
        $this->get('/generate_fizzbuzz?int1=michael&int2=scott&limit=20');

        $this->seeStatusCode(400);
    }

    public function testFizzBuzzWrongUrl()
    {
        $this->get('/generate_dwight?int1=4&int2=23&limit=20');

        $this->seeStatusCode(404);
    }

    public function testGetMostCalledRequest()
    {
        Stats::factory()->count(10)->create(['request' => 'Bruce']);
        Stats::factory()->count(9)->create(['request' => 'Banner']);

        $this->get('/get_most_called_request');

        $expected = [
            'request' => 'Bruce',
            'hits' => 10,
        ];

        $this->seeStatusCode(200);
        $this->assertEquals(
            json_encode($expected), $this->response->getContent()
        );
    }

    public function testGetMostCalledRequestNoResult()
    {
        $this->get('/get_most_called_request');

        $expected = '[]';

        $this->seeStatusCode(200);
        $this->assertEquals(
            $expected, $this->response->getContent()
        );
    }
}
