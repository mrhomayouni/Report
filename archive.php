<?php
require "load.php";
require "header.php";

/*if (!$is_admin) redirect("index.php");*/
if (isset($_POST["submit_arc"], $_POST["type"], $_POST["description"])) {
    if ($_FILES["file"]["name"] === "") {
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

$files = get_archives();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>آرشیو</title>
</head>
<body>
<main class="container">

    <h2 class="h3 mb-3 fw-normal">ثبت پرونده</h2>
    <div class="card" style="padding: 16px;margin: 10px">

        <form method="POST" enctype="multipart/form-data">
            <fieldset>
                <?php if (isset($ok) && $ok === true) { ?>

                    <div class="alert alert-success" role="alert">
                        با موفقیت ثبت شد.
                    </div>
                <?php } elseif (isset($ok) && $ok !== true) { ?>

                    <div class="alert alert-warning" role="alert">
                        <?= $ok ?>
                    </div>

                <?php } ?>

                <div class="mb-3">
                    <label class="form-label">نوع <font style="color: red">*</font> </label>
                    <select class="form-select" name="type">
                        <option value="interview">مصاحبه</option>
                        <option value="Report">گزارش</option>
                        <option value="Contract">قرارداد</option>
                        <option value="Other">متفرقه</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">فایل <font style="color: red">*</font></label>
                    <input name="file" type="file" class="form-control" placeholder="نوع فایل">
                </div>
                <div class="mb-3">
                    <label class="form-label">توضیح <font style="color: red">*</font></label>
                    <textarea name="description" cols="150" rows="10" class="form-control"
                              placeholder="توضیح فایل"></textarea>
                </div>
            </fieldset>
    </div>
    <button name="submit_arc" type="submit" class="btn btn-primary mb-4">ذخیره</button>
    </form>
    <table class="table table-striped" style="border-style: solid">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">نوع</th>
            <th scope="col">توضیح</th>
            <th scope="col">پیوست</th>
            <th scope="col">مدیریت</th>
        </tr>
        </thead>
        <tbody>
        <?php if (count($files) < 1) { ?>
            <div> داده ای برای نمایش وجود ندارد</div>
        <?php } else { ?>
            <?php foreach ($files as $file) { ?>
                <tr>
                    <th scope="row"><?= $file["id"] ?></th>
                    <td><?= $file["type"] ?></td>
                    <td><?= $file["description"] ?></td>
                    <td><a href="files/<?= $file["file_name"] ?>" target="_blank">
                            <?php if (str_ends_with($file["file_name"], ".jpg") ||
                                str_ends_with($file["file_name"], ".png") ||
                                str_ends_with($file["file_name"], ".bmp") ||
                                str_ends_with($file["file_name"], ".gif")) { ?>
                                <img src="files/<?= $file["file_name"] ?>" width="150" height="150">
                            <?php } else { ?>
                                <?= $file["file_name"] ?>
                            <?php } ?>
                        </a></td>
                    <td><?= $file["id"] ?></td>
                </tr>
            <?php }
        } ?>
        </tbody>
    </table>

</main>
</body>