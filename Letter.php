<?php
require "load.php";
require "header.php";
if (isset($_POST["submit"])) {
    /*    var_dump($_POST);*/
    $type = trim($_POST["type"]);
    $recipient = trim($_POST["recipient"]);
    $title = trim($_POST["title"]);
    $body = trim($_POST["body"]);
    /*$annex_name = rand(10000, 99999) . rand(10000, 99999) . $_FILES["annex"]["name"];
    $annex_path = "letters/" . $annex_name;*/
    if ($type === "" || $recipient === "" || $title === "" || $body === "") {
        $ok = "خطا!! فیلد خالی مجاز نیست";
    } else {
        $ok = add_letter($type, $recipient, $title, $body);
    }
}
$letters = get_letters();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>کارمن - نامه</title>
    </head>
<body>
<main class="container">
    <form action="" method="POST" class="mt-4" enctype="multipart/form-data">
        <h1 class="h3 mb-3 fw-normal">ثبت نامه</h1>
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

        <div class="mt-4 row mb-3">
            <div class="mb-3">
                <label class="form-label">نوع <font color="red">*</font></label>
                <select name="type" class="form-control">
                    <option value="1">با سربرگ شرکت</option>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">گیرنده <font color="red">*</font></label>
                <input name="recipient" type="text" class="form-control" required=""
                >
            </div>
            <div class="mb-3">
                <label class="form-label">عنوان<font color="red">*</font></label>
                <input name="title" type="text" class="form-control" required="">
            </div>
        </div>
        <div class="mb-3">
            <label class="form-label">متن<font color="red">*</font></label>
            <textarea name="body" class="form-control" cols="30" rows="10"></textarea>

        </div>
        <div class="mb-3">
            <label class="form-label">پیوست<font color="red">*</font></label>
            <input name="annex" type="file" class="form-control">
        </div>

        <button name="submit" class="btn btn-lg btn-primary" type="submit">
            ایجاد و ذخیره
        </button>
    </form>
    <table class="table table-striped" style="border-style: solid">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">نوع</th>
            <th scope="col">گیرنده</th>
            <th scope="col">عنوان</th>
            <th scope="col">متن</th>
            <th scope="col">ضمیمه</th>
            <th scope="col">تاریخ</th>

        </tr>
        </thead>
        <tbody>
        <?php if ($letters === false) { ?>
            <div> داده ای برای نمایش وجود ندارد</div>

        <?php } else { ?>
            <?php foreach ($letters as $letter) { ?>
                <tr>
                    <th scope="row"><?= $letter["id"] ?></th>
                    <td><?= $letter["type"] ?></td>
                    <td> <p style="max-width: 100px"><?= $letter["recipient"] ?> </p></td>
                    <td> <p style="max-width: 100px"> <?= $letter["title"] ?></p></td>
                    <td><p style="max-width: 400px"> <?= $letter["body"] ?></p></td>
                    <td><a href="files/<?= $letter["annex"] ?>" target="_blank">
                            <?php if (str_ends_with($letter["annex"], ".jpg") ||
                                str_ends_with($letter["annex"], ".png") ||
                                str_ends_with($letter["annex"], ".bmp") ||
                                str_ends_with($letter["annex"], ".gif")) { ?>
                                <img src="files/<?= $letter["annex"] ?>" width="150" height="150">
                            <?php } else { ?>
                                <?= $letter["annex"] ?>
                            <?php } ?>
                        </a></td>
                    <td><?= date("y-m-d<->h:i", $letter["date"]) ?></td>
                    <td><a href="letter_print.php?id=<?= $letter["id"] ?>">مشاهده</a></td>
                </tr>
            <?php }
        } ?>
        </tbody>
    </table>

</main>
</body>