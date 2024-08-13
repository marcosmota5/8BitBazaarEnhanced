<?php

// $host='localhost:3307'; // Just if you have another port number
$host = 'localhost'; // I didn't add the port number here (Only in my PC)
$dbname = 'db_8bitbazzar';
$user = 'user_8bitbazzar'; // The default username
$password = '4CJI5sz9Xvpj40dJ'; // Empty by default => in your computer

$dsn = "mysql:host=$host;dbname=$dbname;port=3306";

try {
    // This object $pdo will the one to be used frequently through our CRUD operations
    // We can give it any name that makes sense to us
    $pdo = new PDO($dsn, $user, $password);
    // setAttribute(AttributeName, Value)
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    // Enable the exceptions
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


} catch (PDOException $e) {
    echo "Database Connection failed: " . $e->getMessage();
}

?>