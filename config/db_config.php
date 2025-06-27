<?php

$host = 'localhost'; // No port number is needed for localhost, but it might be needed for remote servers
$dbname = 'db_8bitbazzar'; // The name of the database
$user = 'user_8bitbazzar'; // The default username
$password = '4CJI5sz9Xvpj40dJ'; // Only for localhost, dummy password

// Data Source Name (DSN) for MySQL
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
