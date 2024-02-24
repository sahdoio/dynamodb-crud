<?php

namespace App\Database;

use Aws\DynamoDb\Marshaler;
use Aws\Exception\AwsException;
use Ramsey\Uuid\Uuid;

class Create extends DynamoDB
{
    public function exec(array $payload, string $table): string
    {
        $marshaler = new Marshaler();

        $postId = Uuid::uuid4()->toString();

        $params = [
            'TableName' => $table,
            'Item' => $marshaler->marshalItem(['post_id' => $postId, ...$payload]),
        ];


        try {
            $this->database->putItem($params);
            return $postId;
        } catch (AwsException $e) {
            print_r($e->getMessage());
            return null;
        }
    }
}
