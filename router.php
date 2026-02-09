<?php
// Router for PHP built-in server
if (file_exists($_SERVER["SCRIPT_FILENAME"])) {
    return false;
} else {
    require_once "index.php";
}
