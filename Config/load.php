<?php
session_start();

define("GLOBALDIR", __DIR__ . "/..");

set_include_path(GLOBALDIR);
spl_autoload_register();

// include_once(GLOBALDIR."/Config/cdn.php");
// include_once(GLOBALDIR."/Config/flowbite.php");
require("Utils/date.php");
include_once(GLOBALDIR . "/Config/db.php");
