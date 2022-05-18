<?php

namespace Actions;

use App\Actions\FizzBuzzAction;
use App\ValueObject\FizzBuzzItem;
use Controllers\PHPUnit_Framework_TestCase;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;
use TestCase;

class FizzBuzzActionTest extends TestCase
{
    public function testFizzBuzzSuccess()
    {
        $item1 = new FizzBuzzItem();
        $item1->setMultiplier(3);
        $item1->setWord('Dwight');

        $item2 = new FizzBuzzItem();
        $item2->setMultiplier(5);
        $item2->setWord('Schrute');

        $limit = 20;

        $action = new FizzBuzzAction();

        $this->assertEquals(
            '1,2,Dwight,4,Schrute,Dwight,7,8,Dwight,Schrute,11,Dwight,13,14,DwightSchrute,16,17,Dwight,19,Schrute', $action->play($item1, $item2, $limit)
        );
    }
}
