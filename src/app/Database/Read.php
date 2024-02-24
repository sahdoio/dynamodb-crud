<?php

namespace App\Database;

use Aws\Exception\AwsException;

class Read extends DynamoDB
{
    public function findOne(string $id, string $table): array|null
    {
        $params = [
            'TableName' => $table,
            'Key' => [
                'post_id' => ['S' => $id]
            ]
        ];

        try {
            $result = $this->database->getItem($params);
            return $result['Item'] ?? null;
        } catch (AwsException $e) {
            print_r($e->getMessage());
            return null;
        }
    }

    public function findAll(string $table): array|null
    {
        $params = [
            'TableName' => $table,
        ];

        try {
            $result = $this->database->scan($params);
            return $result['Items'] ?? null;
        } catch (AwsException $e) {
            print_r($e->getMessage());
            return null;
        }
    }
}
