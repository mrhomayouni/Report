<?php
require "load.php";

if (!isset($_SESSION["user_id"])) {
    redirect("login.php");
}

require "header.php";
?>
<body style="text-align: center">
<b style="font-size: 50px"> متن صفحه اول سایت </b>
</body>