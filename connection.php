<?php
require __DIR__ . '/vendor/autoload.php';

use Kreait\Firebase\Factory;
use Kreait\Firebase\Exception\FirebaseException;

try {
    $factory = (new Factory)
        ->withServiceAccount('kortambayan-firebase-adminsdk-fbsvc-7cc12d768a.json')
        ->withDatabaseUri('https://kortambayan-default-rtdb.firebaseio.com');

    $database = $factory->createDatabase();

    // 🔥 Test Connection
    $reference = $database->getReference('testConnection');
    $reference->set(['message' => 'Connected to Firebase!']);
} catch (FirebaseException $e) {
    echo "Firebase connection failed: " . $e->getMessage();
} catch (Exception $e) {
    echo "General error: " . $e->getMessage();
}
