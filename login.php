<?php
require "load.php";

if (isset($_SESSION["user_id"])) {
    redirect("index.php");
}

if (isset($_POST["submit"], $_POST["username"], $_POST["password"])) {
    $username = trim($_POST["username"]);
    $password = md5(trim($_POST["password"]));
    $user = get_user_by_password($username, $password);
    if ($user === null) $error = true;
    else {
        $user_id = $user["id"];
        $_SESSION["user_id"] = $user_id;
        redirect("index.php");
    }
}

?>


<!doctype html>
<html lang="fa_IR" dir="rtl">
<head>
    <meta charset="utf-8">
    <title>کارمن-ورود</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="generator" content="KareMan">
    <link rel="stylesheet" type="text/css"
          href="https://cdn.jsdelivr.net/gh/rastikerdar/vazirmatn@v33.003/Vazirmatn-font-face.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.rtl.min.css"
          integrity="sha384-+4j30LffJ4tgIMrq9CwHvn0NjEvmuDCOfk6Rpg2xg7zgOxWWtLtozDEEVvBPgHqE" crossorigin="anonymous">
    <style type="text/css">
        body {
            font-family: "Vazirmatn";
            display: flex;
            align-items: center;
            padding-top: 40px;
            padding-bottom: 40px;
            background-color: #f5f5f5;
        }

        .form-signin {
            width: 100%;
            max-width: 330px;
            padding: 15px;
            margin: auto;
        }

        .form-signin .form-floating:focus-within {
            z-index: 2;
        }

        .form-signin input[type="number"] {
            margin-bottom: -1px;
            border-bottom-right-radius: 0;
            border-bottom-left-radius: 0;
        }

        .form-signin input[type="password"] {
            margin-bottom: 10px;
            border-top-left-radius: 0;
            border-top-right-radius: 0;
        }
    </style>
</head>
<body class="text-center">
<main class="form-signin">
    <form action="" method="POST">
        <img class="mb-4" src="logo.png" alt="" width="140">
        <h1 class="h3 mb-3 fw-normal">ورود به سامانه</h1>
        <?php if (isset($error)) { ?>
            <div class="alert alert-danger" role="alert">
                کدپرسنلی یا رمزعبور نادرست است!
            </div>
        <?php } ?>
        <div class="form-floating">
            <input name="username" dir="ltr" type="text" class="form-control" id="floatingInput"
                   placeholder="Username">
            <label for="floatingInput">کد پرسنلی</label>
        </div>
        <div class="form-floating">
            <input name="password" dir="ltr" type="password" class="form-control" id="floatingPassword"
                   placeholder="Password">
            <label for="floatingPassword">رمزعبور</label>
        </div>
        <button name="submit" class="w-100 btn btn-lg btn-primary" type="submit">
            ورود
        </button>
        <p class="mt-5 mb-3 text-muted">&copy; تولید اسرز با عشق 2022</p>
    </form>
</main>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa"
        crossorigin="anonymous"></script>
</body>
</html>
