<?php
require "load.php";



if (isset($_GET["id"])) {
    $question_id = $_GET["id"];
} else {
    redirect("questions.php");
}
$question = get_question_by_question_id($question_id);
if ($question === null) {
    redirect("question.php");
}

require "header.php";

$QUser = get_user_by_id($question["user_id"]);

if (isset($_POST["submit"], $_POST["description"])) {
    $description = $_POST["description"];
    if ($description === "") {
        $ok = "خطا: لطفا متن پاسخ را وارد کنید.";
    } else {
        $ok = add_answer($question_id, $user["id"], $description);
    }
}
$answers = get_answers($question_id);


?>


<!doctype html>
<html lang="fa_IR" dir="rtl">
<head>
    <meta charset="utf-8">
    <title>کارمن</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
</head>
<body>
<main class="container">

    <!-- <div class="d-flex flex-direction-row align-items-center"> -->
    <h1 class="mt-2 w-100"><?= $question["title"] ?> </h1>
    <br>

    <span class="badge bg-primary">  <?= $QUser["first_name"] . " " . $QUser["last_name"] ?> </span>
    <span class="badge bg-warning ms-2"><?= date("y/m/d", $question["date"]) ?></span>
    <!-- </div> -->
    <br>
    <p> <?= $question["body"] ?> </p>

    <a href="question.php?id=5&status=pending" class="btn btn-primary">باز کردن سوال</a>

    <h2 class="h3 mt-5 mb-3 fw-normal">پاسخ ها</h2>
    <?php if (isset($answers) && count($answers) === 0) { ?>
        <div>
            پاسخی برای این سوال وجود ندارد
        </div>
    <?php } else {
        foreach ($answers as $answer) {
            ?>

            <div class="card mb-2">
                <div class="card-body d-flex align-items-center">
                    <div class="w-100">
                        <b> <?php
                            $AUser = get_user_by_id($answer["user_id"]);
                            echo $AUser["first_name"] . " " . $AUser["last_name"]
                            ?> </b>
                        در <?= date("y/m/d", $answer["date"]) ?> پاسخ می دهد:
                        <p style="margin-bottom: 0;"> <?= $answer["body"] ?> </p>
                    </div>
                </div>
            </div>
        <?php }
    } ?>


    <form action="" method="POST" enctype="multipart/form-data" onsubmit="return send(this);">
        <h1 class="h3 mt-4 mb-1 fw-normal">ثبت پاسخ</h1>

        <?php if (isset($error) && $error === true) { ?>

            <div class="alert alert-success" role="alert">
                با موفقیت ثبت شد.
            </div>
        <?php } ?>
        <?php if (isset($ok) && $ok !== true) { ?>

            <div class="alert alert-warning" role="alert">
                <?= $ok ?>
            </div>

        <?php } ?>

        <div class="form-group mt-4">
            <label for="descriptionInput">شرح <font color="red">*</font></label>
            <textarea name="description" rows="5" class="form-control" id="descriptionInput" required=""></textarea>
        </div>

        </div>

        <button name="submit" type="submit" class="btn btn-primary mt-4">ذخیره</button>
    </form>


    <footer>
        <p class="mt-5 mb-3 text-muted text-center">&copy; تولید اسرز با عشق 2022</p>
    </footer>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa"
        crossorigin="anonymous"></script>
</body>
</html>

