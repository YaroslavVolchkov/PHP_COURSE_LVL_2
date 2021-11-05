<?php

session_start();
require('src/response.php');
setcookie(" ", " ", time() - 1);
session_destroy();
responseOk();

?>