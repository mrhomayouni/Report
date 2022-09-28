<?php
require "load.php";

$id = $_GET["id"];
$letter = get_letter_by_id($id);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>چاپ - نامه</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="generator" content="KareMan">
    <link rel="stylesheet" type="text/css"
          href="https://cdn.jsdelivr.net/gh/rastikerdar/vazirmatn@v33.003/Vazirmatn-font-face.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.rtl.min.css"
          integrity="sha384-+4j30LffJ4tgIMrq9CwHvn0NjEvmuDCOfk6Rpg2xg7zgOxWWtLtozDEEVvBPgHqE" crossorigin="anonymous">
</head>
<body style="direction: rtl">

<span style=""><img src="logo.png" width="200"> </span>

<div style="margin-right: 83rem;margin-top:-180px">
    <b>تاریخ: <?= date("y/m/d", $letter["date"]) ?> </b>
    <br><br>
    <b>شماره: A/22/<?= $letter["id"] ?></b>
    <br><br>
    <b>پیوست: ندارد </b>
</div>

<hr style="color: darkblue; border-style: inset;
    border-width: 10px; margin-top: 40px">
<div style="text-align: center"> بسمه تعالی</div>
<br>
<div style="margin-right: 10px">
    <div><b></b><?= $letter["recipient"] ?></div>
    <br>
    <div><b> موضوع:</b> <?= $letter["title"] ?></div>
    <br><br>
    <p> <?= $letter["body"] ?></p>
</div>
</body>
</html>