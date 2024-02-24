<?php

namespace App\Database;

use Aws\DynamoDb\DynamoDbClient;

class DynamoDB
{    protected DynamoDbClient $database;

    public function __construct()
    {
        // Set up credentials and region
        $credentials = [
            'key' => 'your_key',
            'secret' => 'your_secret'
        ];

        // Create a DynamoDB client
        $this->database = new DynamoDbClient([
            'version' => 'latest',
            'credentials' => $credentials,
            'region' => 'us-east-1',
        ]);
    }
}
