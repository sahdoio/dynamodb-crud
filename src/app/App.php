<?php

declare(strict_types=1);

namespace App;

use App\Database\Create;
use App\Database\Read;
use Faker\Factory as Faker;

class App
{
    const OPS_LIST = 'list';
    const OPS_READ = 'read';
    const OPS_CREATE = 'create';
    const OPS_SEED = 'seed';

    /**
     * @throws \Exception
     */
    public function start(array $args): void
    {
        $operation = $args[1] ?? self::OPS_READ;
        $table = $args[2] ?? null;

        if (!$table) {
            throw new \Exception('No table name passed in args');
        }

        $id = $operation === self::OPS_READ ?: ($args[3] ?? null);

        if ($operation === self::OPS_READ && !$id) {
            throw new \Exception('Id required for read operation');
        }

        $result = match ($operation) {
            self::OPS_LIST => $this->handleList($table),
            self::OPS_READ => $this->handleRead($id, $table),
            self::OPS_CREATE => $this->handleCreate(null, $table),
            self::OPS_SEED => $this->handleSeed($table),
            default => throw new \Exception('Invalid Operation')
        };

        echo 'Operation: ' . $operation . PHP_EOL;
        echo 'Result: ';
        print_r(json_encode($result));
        echo PHP_EOL;
    }

    private function handleList(string $tableName): array|null
    {
        $read = new Read();
        return $read->findAll($tableName);
    }

    private function handleRead(string $id, string $tableName): array|null
    {
        $read = new Read();
        return $read->findOne($id, $tableName);
    }

    private function handleCreate(?array $payload, string $tableName): array|null
    {
        $faker = Faker::create();
        $create = new Create();
        $item = $payload ?? [
            'title' => $faker->sentence(6),
            'body' => $faker->sentence(20),
        ];
        $postId =  $create->exec($item, $tableName);
        return $this->handleRead($postId, $tableName);
    }

    private function handleSeed(string $tableName): array|null
    {
        $faker = Faker::create();

        for ($i = 0; $i < 10; $i++) {
            $item = [
                'title' => $faker->sentence(6),
                'body' => $faker->sentence(20),
            ];

            $this->handleCreate($item, $tableName);
        }

        return $this->handleList($tableName);
    }
}
