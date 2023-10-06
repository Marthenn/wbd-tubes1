<?php

class Flasher {
    public static function setFlash($message, $type = 'info', $left_button = null, $right_button = 'Cancel'){
        $_SESSION['flash'] = [
                'message' => $message,
                'type' => $type
        ];

        if ($left_button != null){
            $_SESSION['flash']['left_button'] = $left_button;
            $_SESSION['flash']['right_button'] = $right_button;

        }
    }

    public static function flash(){
        if (isset($_SESSION['flash'])){
            if (isset($_SESSION['flash']['left_button'])){
                echo'
                <div class="flash-message">
                    <div class="flash-'. $_SESSION['flash']['type'] . '">
                        <p class="flash-message-text">' . $_SESSION['flash']['message'] . '</p>
                        <div class = "flash-button">
                            <button class="flash-message-left-button">' . $_SESSION['flash']['left_button'] . '</button>
                            <button class="flash-message-right-button">' . $_SESSION['flash']['right_button'] . '</button>
                        </div>
                    </div>
                </div>
                ';
            } else {
                echo'
                <div class="flash-message">
                    <div class="flash-'. $_SESSION['flash']['type'] . '">
                        <p class="flash-message-text">' . $_SESSION['flash']['message'] . '</p>
                        <div class = "flash-button">
                            <button class="flash-message-right-button">OK</button>
                        </div>
                    </div>
                </div>
                ';
            }

            unset($_SESSION['flash']);
        }
    }
}