<?php
require "load.php";
require "header.php ";

if (isset($_POST["submit"], $_POST["username"], $_POST["first_name"], $_POST["last_name"])) {
    $username = trim($_POST["username"]);
    $first_name = trim($_POST["first_name"]);
    $last_name = trim($_POST["last_name"]);

    if ($username === "" || $first_name === "" || $last_name === "") {
        $ok = "خطا!!فیلد خالی مجاز نیست";
    } elseif (change_Specifications($user["id"], $username, $first_name, $last_name)) {
        $ok = true;
    } else {
        $ok = "خطا!!مشکلی در ویرایش اطلاعات به وجود امده است";
    }
}

if (isset($_POST["change_password"], $_POST["new_password"], $_POST["repeat_new_password"])) {
    $new_password = trim($_POST["new_password"]);
    $new_password_repeat = trim($_POST["repeat_new_password"]);

    if ($new_password === "" || $new_password_repeat === "") {
        $change_password = "خطا!! رمز عبور یا تکرار رمز عبور خالی است.";
    } elseif ($new_password !== $new_password_repeat) {
        $change_password = "خطا!! رمز عبور و تکرار ان باهم برابر نیستند.";
    } elseif (strlen($new_password < 6)) {
        $change_password = "خطا!!رمزعبور باید حداقل 6 کاراکتر باشد.";
    } elseif (change_password($user["id"], $new_password)) {
        $change_password = true;
    } else {
        $change_password = change_password($user["id"], $new_password);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>پروفایل</title>
</head>
<body>
<main class="container">

    <form action="" method="POST" class="mt-4">
        <h1 class="h3 mb-3 fw-normal">ویرایش مشخصات</h1>
        <?php if (isset($ok) && $ok === true) { ?>
            <div class="alert alert-success" role="alert">
                مشخصات با موفقیت تغییر کرد
            </div>
        <?php }elseif (isset($ok) && $ok !== true) { ?>
            <div class="alert alert-warning" role="alert">
                <?= $ok ?>
            </div>
        <?php } ?>
        <div class="mt-4 row mb-3">
            <div class="mb-3">
                <label class="form-label">کدملی <font color="red">*</font></label>
                <input name="username" type="number" class="form-control" required="" value="<?= $user["username"] ?>">
            </div>
            <div class="mb-3">
                <label class="form-label">نام <font color="red">*</font></label>
                <input name="first_name" type="text" class="form-control" required=""
                       value="<?= $user["first_name"] ?>">
            </div>
            <div class="mb-3">
                <label class="form-label">نام خانوادگی <font color="red">*</font></label>
                <input name="last_name" type="text" class="form-control" required="" value="<?= $user["last_name"] ?>">
            </div>
        </div>

        <button name="submit" class="btn btn-lg btn-primary" type="submit">
            بروزرسانی مشخصات
        </button>

    </form>

    <form action="" method="POST" class="mt-4">
        <h1 class="h3 mb-3 fw-normal">تغییر رمزعبور</h1>
        <?php if (isset($change_password) && $change_password === true) { ?>
            <div class="alert alert-success" role="alert">
                رمز عبور با موفقیت تغییر کرد
            </div>
        <?php }elseif (isset($change_password) && $change_password !== true) { ?>
            <div class="alert alert-warning" role="alert">
                <?= $change_password ?>
            </div>
        <?php } ?>

        <div class="mt-4 row mb-3">
            <div class="mb-3">
                <label class="form-label">رمزعبور جدید <font color="red">*</font></label>
                <input name="new_password" type="password" class="form-control" required="">
            </div>
            <div class="mb-3">
                <label class="form-label">تکرار رمزعبور جدید <font color="red">*</font></label>
                <input name="repeat_new_password" type="password" class="form-control" value="" required="">
            </div>
        </div>

        <button name="change_password" class="btn btn-lg btn-primary" type="submit">
            تغییر رمز
        </button>

    </form>

    <footer>
        <p class="mt-5 mb-3 text-muted text-center">&copy; تولید اسرز با عشق 2022</p>
    </footer>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa"
        crossorigin="anonymous"></script>
</body>

