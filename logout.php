<?php

// Start the session if it wasn't started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// session_destroy(): Destroys all data registered to a session
session_destroy(); 

header("Location: index.php");
exit();