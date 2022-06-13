<?php

function is_logged(){
    require("secrets.php");
    return $_REQUEST["password"] === $passphrase ;
}
