<?php
require "load.php";
require "header.php";
if (!isset($user)) {
    redirect("load.php");
} else {
    if (isset($_POST["submit"], $_POST["type"], $_POST["type"], $_POST["duration"], $_POST["description"])) {
        $date = trim($_POST["date"]);
        $type = trim($_POST["type"]);
        $duration = trim($_POST["duration"]);
        $description = trim($_POST["description"]);
        if ($date === "" ||
            $type === "" ||
            $duration === "" ||
            $description === "") {
            $error = "خطا!! فیلد خالی مجاز نیست";
        } else {
            $error = add_vacation($user["id"], $date, $type, $duration, $description);
        }
    }
    $vacations = get_vacation($user["id"]);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title> کار من - مرخصی</title>
</head>
<body>
<main class="container">

    <h1 class="h3 mb-3 fw-normal">لیست مرخصی ها</h1>
    <table class="table">
        <thead>
        <tr>
            <th scope="col">نام</th>
            <th scope="col">تاریخ</th>
            <th scope="col">نوع</th>
            <th scope="col">زمان</th>
            <th scope="col">شرح</th>
            <th scope="col">زمان درخواست</th>
            <th scope="col">وضعیت</th>
        </tr>
        </thead>
        <tbody>
        <?php if ($vacations === false) {
            echo "فیلدی برای نمایش جود ندارد";
        } else {
            foreach ($vacations as $vacation) { ?>
                <tr style="background-color:
                <?php if ($vacation["status"] === 0) { ?> #decf2a <?php } ?>
                <?php if ($vacation["status"] === 1) { ?> #40e612 <?php } ?>
                <?php if ($vacation["status"] === 2) { ?> #de2a2a <?php } ?>
                        ;">
                    <td><?php echo get_user_by_id($vacation["user_id"])["first_name"] . " " . get_user_by_id($vacation["user_id"])["last_name"] ?></td>
                    <td><?= $vacation["date"] ?></td>
                    <td><?= $vacation["type"] ?></td>
                    <td><?= $vacation["duration"] ?></td>
                    <td><?= $vacation["description"] ?></td>
                    <td><?= date("h:i - y/m/d", $vacation["created_at"]) ?></td>
                    <td><?php
                        if ($vacation["status"] === 0) echo "در انتظار برسی";
                        if ($vacation["status"] === 1) echo "تایید شده";
                        if ($vacation["status"] === 2) echo "رد شده";

                        ?></td>
                </tr>
            <?php }
        } ?>
        </tbody>
    </table>

    <form action="" method="POST" onsubmit="return send(this);">
        <h1 class="h3 mb-3 fw-normal">ثبت مرخصی</h1>
        <?php if (isset($error) && $error === true) { ?>

            <div class="alert alert-success" role="alert">
                با موفقیت ثبت شد.
            </div>
        <?php } ?>
        <?php if (isset($error) && $error !== true) { ?>

            <div class="alert alert-warning" role="alert">
                <?= $error ?>
            </div>

        <?php } ?>
        <div class="row">
            <div class="mb-3 col-4">
                <label for="date-picker1" class="form-label">تاریخ <font color="red">*</font></label>
                <input name="date" id="date-picker1" type="text" class="form-control date-picker" required=""
                       pattern="[0-9]{4}/[0-9]{2}/[0-9]{2}" value="1401/06/23">
            </div>
            <div class="mb-3 col-4">
                <label class="form-label">نوع <font color="red">*</font></label>
                <select id="inputType" class="form-control" name="type" required="">
                    <option value="hoursly">ساعتی</option>
                    <option value="daily">روزانه</option>
                </select>
            </div>
            <div class="mb-3 col-4">
                <label class="form-label">زمان <font color="red">*</font></label>
                <select id="inputDuration" class="form-control" name="duration" required="">
                    <option value="30m">سی دقیقه</option>
                    <option value="1h">یک ساعت</option>
                    <option value="2h">دو ساعت</option>
                    <option value="3h">سه ساعت</option>
                    <option value="4h">چهار ساعت</option>
                    <option value="5h">پنج ساعت</option>

                    <option value="1d">یک روز</option>
                    <option value="2d">دو روز</option>
                    <option value="3d">سه روز</option>
                    <option value="4d">چهار روز</option>
                    <option value="5d">پنج روز</option>
                </select>
            </div>
            <div class="mb-3 col-12">
                <label class="form-label">شرح <font color="red">*</font></label>
                <textarea class="form-control" name="description" rows="4" requried=""></textarea>
            </div>
        </div>

        <button name="submit" class="mt-3 w-100 btn btn-lg btn-primary" type="submit">
            ذخیره
        </button>
    </form>

    <footer>
        <p class="mt-5 mb-3 text-muted text-center">&copy; تولید اسرز با عشق 2022</p>
    </footer>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa"
        crossorigin="anonymous"></script>
<script type="text/javascript" src="mds.bs.datetimepicker.js"></script>
<script type="text/javascript">
    const dateInputs = document.querySelectorAll("input.date-picker");
    dateInputs.forEach((dateInput) => {
        const dtp1Instance = new mds.MdsPersianDateTimePicker(dateInput, {
            targetTextSelector: "input#" + dateInput.id,
            // targetDateSelector: '[data-name="dtp1-date"]',
        });
    });

    const inputType = document.querySelector("#inputType");
    const inputDuration = document.querySelector("#inputDuration");
    inputType.addEventListener("change", () => {
        inputDuration.querySelectorAll("option").forEach((option) => {
            if (inputType.value === "hoursly") {
                option.style.display = option.value.includes("h") ? "block" : "none";
            } else {
                option.style.display = option.value.includes("d") ? "block" : "none";
            }
        });

        const options = inputDuration.querySelectorAll("option");
        for (let i = 0; i < options.length; i++) {
            if (options[i].style.display !== "none") {
                inputDuration.value = options[i].value;
                break;
            }
        }
    });
    inputType.dispatchEvent(new Event("change"));
</script>
</body>
</html>
