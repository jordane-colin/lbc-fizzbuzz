<?php

namespace App\Actions;

use App\ValueObject\FizzBuzzItem;

class FizzBuzzAction
{
    /**
     * Generation the fizzbuzz string
     *
     * @param FizzBuzzItem $item1
     * @param FizzBuzzItem $item2
     * @param int $limit
     * @return string
     */
    public function play(FizzBuzzItem $item1, FizzBuzzItem $item2, int $limit): string
    {
        $data = [];
        for($num = 1; $num <= $limit; $num++) {
            if ($item1->check($num) && $item2->check($num)) {
                $data[] = $item1->getWord().$item2->getWord();
            } else if ($item1->check($num)) {
                $data[] = $item1->getWord();
            } else if ($item2->check($num)) {
                $data[] = $item2->getWord();
            } else {
                $data[] = (string) $num;
            }
        }

        return implode(',', $data);
    }
}
