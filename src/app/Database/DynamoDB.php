<?php

namespace App\Database;

use Aws\DynamoDb\DynamoDbClient;

class DynamoDB
{
    protected DynamoDbClient $database;

    public function __construct()
    {
        // Set up credentials and region
        $credentials = [
            'key' => 'AKIA3AHPQDAF6P4I6VAS',
            'secret' => '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'
        ];

        // Create a DynamoDB client
        $this->database = new DynamoDbClient([
            'version' => 'latest',
            'credentials' => $credentials,
            'region' => 'us-east-1',
        ]);
    }
}
