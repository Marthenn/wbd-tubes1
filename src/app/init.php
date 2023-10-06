<?php

require_once 'core/Privilege.php';
require_once 'core/App.php';
require_once 'core/Controller.php';
require_once 'core/Database.php';
require_once 'core/Flasher.php';

require_once 'config/config.php';

// create session if not exist
if (session_status() != PHP_SESSION_ACTIVE) {
    session_start();
}
