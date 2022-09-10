<?php
require "load.php";

if (isset($_POST["submit_arc"], $_POST["type"], $_POST["description"])) {
    if ($_FILES["file"]["size"] === 0) {
        $ok = "خطا!! فایلی انتخاب نشده است";
    } else {

        $type = $_POST["type"];
        $description = trim($_POST["description"]);
        $file_name = rand(100000, 999999) . rand(100000, 999999) . $_FILES["file"]["name"];
        $file_path = "files/" . $file_name;
        if ($type === "" || $description === "") {
            $ok = "خطا!!لطفا نوع و توضیح فایل را به درستی وارد کنید.";
        } else if (move_uploaded_file($_FILES["file"]["tmp_name"], $file_path)) {
            $ok = add_to_archive($type, $description, $file_name);
        } else {
            $ok = "خطایی در آپلود فایل یه وجود امده است";
        }
    }
}
?>
<!doctype html>
<html lang="fa_IR" dir="rtl">
<head>
    <meta charset="utf-8">
    <title>کارمن - ورود</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="generator" content="KareMan">
    <link rel="stylesheet" type="text/css"
          href="https://cdn.jsdelivr.net/gh/rastikerdar/vazirmatn@v33.003/Vazirmatn-font-face.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.rtl.min.css"
          integrity="sha384-+4j30LffJ4tgIMrq9CwHvn0NjEvmuDCOfk6Rpg2xg7zgOxWWtLtozDEEVvBPgHqE" crossorigin="anonymous">
</head>

<form method="POST" enctype="multipart/form-data">
    <fieldset>
        <legend>ثبت پرونده</legend>
        <?php if (isset($ok) && $ok === true) { ?>

            <div class="alert alert-success" role="alert">
                با موفقیت ثبت شد.
            </div>
        <?php } ?>
        <?php if (isset($ok) && $ok !== true) { ?>

            <div class="alert alert-warning" role="alert">
                <?= $ok ?>
            </div>

        <?php } ?>

        <div class="mb-3">
            <label class="form-label">نوع</label>
            <select class="form-select" name="type">
                <option value="interview">مصاحبه</option>
                <option value="Report">گزارش</option>
                <option value="Contract">قرارداد</option>
                <option value="Other">متفرقه</option>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">فایل</label>
            <input name="file" type="file" class="form-control" placeholder="نوع فایل">
        </div>
        <div class="mb-3">
            <label class="form-label">توضیح</label>
            <input name="description" type="text" class="form-control" placeholder="توضیح فایل">
        </div>
        <button name="submit_arc" type="submit" class="btn btn-primary">Submit</button>
    </fieldset>
</form>
