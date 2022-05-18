<?php

namespace App\ValueObject;

class FizzBuzzItem
{
    private $word;
    private $multiplier;

    public function setWord(string $word): FizzBuzzItem
    {
        $this->word = $word;

        return $this;
    }

    public function setMultiplier(int $multiplier): FizzBuzzItem
    {
        $this->multiplier = $multiplier;

        return $this;
    }

    public function getWord(): string
    {
        return $this->word;
    }

    public function check($number): bool
    {
        return ($number % $this->multiplier === 0);
    }
}
