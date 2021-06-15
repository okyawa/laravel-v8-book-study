<?php

declare(strict_types=1);

namespace App\Services;

use App\DataProvider\Eloquent\Publisher;

class PublishService
{
    public function exists(string $name): bool
    {
        $count = Publisher::whereName($name)->count();
        if ($count > 0) {
            return true;
        }
        return false;
    }

    public function store(string $name, string $address): int
    {
        $publisher = Publisher::create(
            [
                'name' => $name,
                'address' => $address,
            ]
        );
        return (int)$publisher->id;
    }
}
