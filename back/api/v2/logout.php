<?php

session_start();
include_once('cors.php');
require('response.php');
setcookie(" ", " ", time() - 1);
session_destroy();
responseOk();

?>