<?php

// Include the session initialization file to start the session
require_once __DIR__ . "/config/session_init.php";

// session_destroy(): Destroys all data registered to a session
session_destroy(); 

header("Location: index.php");
exit();