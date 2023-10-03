<?php

class Flasher {
    public static function setFlash($message, $action, $type) {
        $_SESSION['flash'] = [
            'message' => $message,
            'action' => $action,
            'type' => $type
        ];
    }

    public static function flash() {
        if (isset($_SESSION['flash'])) {
            // TODO: create the HTML for the flash message (must use vanilla HTML CSS)
            unset($_SESSION['flash']);
        }
    }
}