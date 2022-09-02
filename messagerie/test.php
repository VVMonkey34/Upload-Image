<?php

require 'autoload.php';

$test = Db::singleton();
//$test->create("user", ["pseudo", "mail", "password"], ["Vincent","vvaugrente@gmail.com","powow"]);
$test->update("user", ["mail"], ["powow@yahoo.fr"], 1, "user_id");


