<?php
//require "load.php";
?>
<!doctype html>
<html lang="fa_IR" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="generator" content="KareMan">
    <link rel="stylesheet" type="text/css"
          href="https://cdn.jsdelivr.net/gh/rastikerdar/vazirmatn@v33.003/Vazirmatn-font-face.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.rtl.min.css"
          integrity="sha384-+4j30LffJ4tgIMrq9CwHvn0NjEvmuDCOfk6Rpg2xg7zgOxWWtLtozDEEVvBPgHqE" crossorigin="anonymous">
    <style type="text/css">
        * {
            box-sizing: border-box;
        }

        body {
            font-family: "Vazirmatn";
            background-color: #f5f5f5;
        }

        header {
            padding: 2rem 1rem;
            margin-bottom: 2rem;
            background-color: #e9ecef;
        }

        #tp-wrap *::selection {
            background: transparent;
        }

        #tp-wrap {
            width: 100vw;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 999;
            background: rgba(0, 0, 0, 0.7);
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.3s;
        }

        #tp-wrap.show {
            opacity: 1;
            visibility: visible;
        }

        /* (B) BOX */
        #tp-box {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 320px;
            display: flex;
            flex-wrap: wrap;
            flex-direction: row-reverse;
            border: 1px solid #000;
            background: #2d2d2d;
            border-radius: 10px;
        }

        /* (C) HR/MIN/AM/PM */
        .tp-cell {
            width: 33.3%;
            padding: 0 15px;
            text-align: center;
        }

        .tp-up, .tp-down {
            padding: 10px 0;
            color: rgb(237, 189, 0);
            font-size: 32px;
            font-weight: 700;
            cursor: pointer;
        }

        .tp-val {
            width: 100%;
            padding: 10px 0;
            text-align: center;
            font-size: 22px;
            background: #fff;
        }

        /* (D) CLOSE & SET BUTTON */
        #tp-close, #tp-set {
            width: 50%;
            padding: 15px 0;
            border: 0;
            font-size: 18px;
            font-weight: 700;
            color: #fff;
            cursor: pointer;
        }

        #tp-close {
            background: #c2c2c2;
            border-bottom-left-radius: 10px;
        }

        #tp-set {
            background: rgb(237, 189, 0);
            border-bottom-right-radius: 10px;
        }

        /* (E) 24-HOUR MODIFY */
        #tp-wrap.tp-24 #tp-ap {
            display: none;
        }

        #tp-wrap.tp-24 #tp-hr, #tp-wrap.tp-24 #tp-min {
            width: 50%;
        }

        .widget-wrap {
            width: 500px;
            padding: 30px;
            border-radius: 20px;
            background: rgba(255, 255, 255, 0.5);
        }

        .widget-wrap label, .widget-wrap input {
            display: block;
            padding: 10px;
            width: 100%;
        }

        /* SVG */
        #hash {
            width: 100px;
            height: 100px;
            background-image: url('data:image/svg+xml;utf8,<svg viewBox="0 0 640 512" width="100" xmlns="http://www.w3.org/2000/svg"><path d="M496 224c-79.59 0-144 64.41-144 144s64.41 144 144 144 144-64.41 144-144-64.41-144-144-144zm64 150.29c0 5.34-4.37 9.71-9.71 9.71h-60.57c-5.34 0-9.71-4.37-9.71-9.71v-76.57c0-5.34 4.37-9.71 9.71-9.71h12.57c5.34 0 9.71 4.37 9.71 9.71V352h38.29c5.34 0 9.71 4.37 9.71 9.71v12.58zM496 192c5.4 0 10.72.33 16 .81V144c0-25.6-22.4-48-48-48h-80V48c0-25.6-22.4-48-48-48H176c-25.6 0-48 22.4-48 48v48H48c-25.6 0-48 22.4-48 48v80h395.12c28.6-20.09 63.35-32 100.88-32zM320 96H192V64h128v32zm6.82 224H208c-8.84 0-16-7.16-16-16v-48H0v144c0 25.6 22.4 48 48 48h291.43C327.1 423.96 320 396.82 320 368c0-16.66 2.48-32.72 6.82-48z" /></svg>');
            background-repeat: no-repeat;
            background-position: center;
        }

        /* FOOTER */
        #code-boxx {
            font-weight: 600;
            margin-top: 30px;
        }

        #code-boxx a {
            display: inline-block;
            padding: 5px;
            text-decoration: none;
            background: #b90a0a;
            color: #fff;
        }


        .reports {

        }

        .reports-add {
            width: 60px;
            margin: auto;
            cursor: pointer;
        }

        .reports-add span {
            font-size: 40px;
            display: flex;
            justify-content: center;
            align-items: center;
            background: rgb(237, 189, 0);
            border-radius: 100%;
            width: 60px;
            height: 60px;
        }
    </style>
</head>
<body>
<header>
    <div class="container d-flex align-items-center justify-content-center flex-column">
        <a href="index.php"> <img class="mb-2" src="logo.png" alt="" width="100px"></a>
        <h3 class="display-5">
            سلام <?php
            echo ($user["gender"] === 0) ? "اقای " : "خانم ";
            echo $user["first_name"] . " " . $user["last_name"];
            ?>
            !</h3>
        <p class="mt-4">
            <?= motivational_sentence() ?>
        </p>
        <p>
            <a class="btn btn-primary btn-sm" href="logout.php"
               role="button">خروج
            </a>
            <?php if ($is_admin) { ?>
                <a
                        class="btn btn-primary <?php if (check_page("/Report/archive.php")) { ?> btn-warning <?php } ?> btn-sm"
                        href="archive.php"
                        role="button">بایگانی
                </a>
                <a class="btn btn-primary <?php if (check_page("/Report/Letter.php")) { ?> btn-warning <?php } ?> btn-sm"
                   href="Letter.php"
                   role="button">نامه
                </a>

            <?php } ?>
            <a class="btn  btn-primary <?php if (check_page("/Report/add_reports.php")) { ?> btn-warning <?php } ?> btn-sm"
               href="add_reports.php"
               role="button">ثبت گزارش
            </a>
            <a class="btn btn-primary <?php if (check_page("/Report/edit_profile.php")) { ?> btn-warning <?php } ?> btn-sm"
               href="edit_profile.php"
               role="button">پروفایل
            </a>

            <a class="btn btn-primary <?php if (check_page("/Report/vacation.php")) { ?> btn-warning <?php } ?> btn-sm"
               href="vacation.php"
               role="button">مرخصی
            </a>
            <a class="btn btn-primary <?php if (check_page("/Report/questions.php")) { ?> btn-warning <?php } ?> btn-sm"
               href="questions.php"
               role="button">سوالات
            </a>
        </p>
    </div>
</header>
</body>