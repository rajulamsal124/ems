<?php
class Input {

    public static function exists($type = 'post') {
        switch($type) {
            case 'post':
                return (!empty($_POST)) ? true : false;
                break;
            case 'get':
                return (!empty($_GET)) ? true : false;
                break;
            default:
                return false;
                break;
        }
    }

    public static function get($item) {
        if(isset($_POST[$item])) {
            return Sanitize::escape(trim($_POST[$item], " "));
        } else if(isset($_GET[$item])) {
            return Sanitize::escape(trim($_GET[$item], " "));
        }

        return '';
    }
}