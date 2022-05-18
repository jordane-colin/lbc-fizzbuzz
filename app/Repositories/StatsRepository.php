<?php

namespace App\Repositories;

use App\Models\Stats;

class StatsRepository
{
    public function getMostCalledRequest()
    {
        return Stats::raw(static function($collection) {
            return $collection->aggregate([
                    [
                        '$group' => [
                            '_id' => '$hash_request',
                            'count' => ['$sum' => 1]
                        ]
                    ],
                    [
                        '$sort' => [
                            'count' => -1
                        ]
                    ]
                ]
            );
        })->first();
    }
}

