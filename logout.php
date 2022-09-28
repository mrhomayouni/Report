<?php
require "load.php";

unset ($_SESSION ["user_id"]);

redirect("login.php");
