<?php
require "load.php";
require "header.php";

if (!isset($_SESSION["user_id"])) {
    redirect("login.php");
}
if (isset($_POST["submit"], $_POST["time_start"], $_POST["time_end"], $_POST["time_teach"], $_POST["description"])
    && is_array(["time_start"]) &&
    is_array($_POST["time_end"]) &&
    is_array($_POST["time_teach"]) &&
    is_array($_POST["description"])) {

    $time_starts = $_POST["time_start"];
    $time_ends = $_POST["time_end"];
    $time_teaches = $_POST["time_teach"];
    $descriptions = $_POST["description"];

    $ok = add_reports($user["id"], $time_starts, $time_ends, $time_teaches, $descriptions);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>کارمن - ثبت گزارش</title>
</head>
<body>
<main class="container">
    <form action="" method="POST">
        <h2 class="h3 mb-3 fw-normal">ثبت گزارش</h2>
        <?php if (isset($ok) && $ok === true) { ?>

            <div class="alert alert-success" role="alert">
                گزارش با موفقیت ثبت شد.
            </div>
        <?php } elseif (isset($ok) && $ok !== true) { ?>

            <div class="alert alert-warning" role="alert">
                <?php echo $ok ?>
            </div>

        <?php } ?>


        <div class="reports"></div>
        <div class="reports-add">
            <span>+</span>
        </div>

        <button name="submit" class="w-100 btn btn-lg btn-primary mt-4 mb-4" type="submit">
            ذخیره
        </button>
        <p class="mt-5 mb-3 text-muted text-center"> © تولید اسرز با عشق 2022</p>

</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa"
        crossorigin="anonymous"></script>
<script type="text/javascript">
    var tp = {
        // (A) INIT - GENERATE TIME PICKER HTML
        hwrap: null, // entire html time picker
        hhr: null,   // html hour value
        hmin: null,  // html min value
        hap: null,   // html am/pm value
        init: () => {
            // (A1) ADD TIME PICKER TO BODY
            tp.hwrap = document.createElement("div");
            tp.hwrap.id = "tp-wrap";
            document.body.appendChild(tp.hwrap);

            // (A2) TIME PICKER INNER HTML
            tp.hwrap.innerHTML =
                `<div id="tp-box">
                <div class="tp-cell" id="tp-hr">
                    <div class="tp-up">&#65087;</div> <div class="tp-val">0</div> <div class="tp-down">&#65088;</div>
                </div>
                <div class="tp-cell" id="tp-min">
                    <div class="tp-up">&#65087;</div> <div class="tp-val">0</div> <div class="tp-down">&#65088;</div>
                </div>
                <div class="tp-cell" id="tp-ap">
                    <div class="tp-up">&#65087;</div> <div class="tp-val">AM</div> <div class="tp-down">&#65088;</div>
                </div>
                <button id="tp-close" onclick="tp.hwrap.classList.remove('show')">انصراف</button>
                <button id="tp-set" onclick="tp.set()">تنظیم</button>
                </div>`;

            // (A3) GET VALUE ELEMENTS + SET CLICK ACTIONS
            for (let segment of ["hr", "min", "ap"]) {
                let up = tp.hwrap.querySelector(`#tp-${segment} .tp-up`),
                    down = tp.hwrap.querySelector(`#tp-${segment} .tp-down`);
                tp["h" + segment] = tp.hwrap.querySelector(`#tp-${segment} .tp-val`);

                if (segment == "ap") {
                    up.onclick = () => {
                        tp.spin(true, segment);
                    };
                    down.onclick = () => {
                        tp.spin(true, segment);
                    };
                } else {
                    up.onmousedown = () => {
                        tp.spin(true, segment);
                    };
                    down.onmousedown = () => {
                        tp.spin(false, segment);
                    };
                    up.onmouseup = () => {
                        tp.spin(null);
                    };
                    down.onmouseup = () => {
                        tp.spin(null);
                    };
                    up.onmouseleave = () => {
                        tp.spin(null);
                    };
                    down.onmouseleave = () => {
                        tp.spin(null);
                    };
                }
            }
        },

        // (B) SPIN HOUR/MIN/AM/PM
        //  direction : true (up), false (down), null (stop)
        //  segment : "hr", "min", "ap" (am/pm)
        timer: null, // for "continous" time spin
        minhr: 1,    // min spin limit for hour
        maxhr: 12,   // max spin limit for hour
        minmin: 0,   // min spin limit for minute
        maxmin: 59,  // max spin limit for minute
        spin: (direction, segment) => {
            // (B1) CLEAR TIMER
            if (direction == null) {
                if (tp.timer != null) {
                    clearTimeout(tp.timer);
                    tp.timer = null;
                }
            }

            // (B2) SPIN FOR AM/PM
            else if (segment == "ap") {
                tp.hap.innerHTML = tp.hap.innerHTML == "AM" ? "PM" : "AM";
            }

            // (B3) SPIN FOR HR/MIN
            else {
                // (B3-1) INCREMENT/DECREMENT
                let next = +tp["h" + segment].innerHTML;
                next = direction ? next + 1 : next - 1;

                // (B3-2) MIN/MAX
                if (segment == "hr") {
                    if (next > tp.maxhr) {
                        next = tp.maxhr;
                    }
                    if (next < tp.minhr) {
                        next = tp.minhr;
                    }
                } else {
                    if (next > tp.maxmin) {
                        next = tp.maxmin;
                    }
                    if (next < tp.minmin) {
                        next = tp.minmin;
                    }
                }

                // (B3-3) SET VALUE
                if (next < 10) next = "0" + next;
                tp["h" + segment].innerHTML = next;

                // (B3-4) KEEP ROLLING - LOWER TIMEOUT WILL SPIN FASTER
                tp.timer = setTimeout(() => {
                    tp.spin(direction, segment);
                }, 100);
            }
        },

        // (C) ATTACH TIME PICKER TO HTML FIELD
        //  target : html field to attach to
        //  24 : 24 hours time? default false.
        //  after : optional, function to run after selecting time
        attach: (instance) => {
            // (C1) READONLY FIELD + NO AUTOCOMPLETE
            // IMPORTANT, PREVENTS ON-SCREEN KEYBOARD
            instance.target.readOnly = true;
            instance.target.setAttribute("autocomplete", "off");

            // (C2) DEFAULT 12 HOURS MODE
            if (instance["24"] == undefined) instance["24"] = false;

            // (C3) CLICK TO OPEN TIME PICKER
            instance.target.addEventListener("click", () => {
                tp.show(instance);
            });
        },

        // (D) SHOW TIME PICKER
        setfield: null, // set selected time to this html field
        set24: false, // false,   // 24 hours mode? default false.
        setafter: null, // run this after selecting time
        show: (instance) => {
            // (D1) INIT FIELDS TO SET + OPTIONS
            tp.setfield = instance.target;
            tp.setafter = instance.after;
            tp.set24 = instance["24"];
            tp.minhr = tp.set24 ? 0 : 1;
            tp.maxhr = tp.set24 ? 23 : 12;

            // (D2) READ CURRENT VALUE
            let val = tp.setfield.value;
            // alert(tp.set24);
            if (val == "") {
                tp.hhr.innerHTML = "0" + tp.minhr;
                tp.hmin.innerHTML = "0" + tp.minmin;
                tp.hap.innerHTML = "AM";
            } else {
                tp.hhr.innerHTML = val.substring(0, 2);
                tp.hmin.innerHTML = val.substring(3, 5);
            }

            // (D3) SHOW TIME PICKER
            if (tp.set24) {
                tp.hwrap.classList.add("tp-24");
            } else {
                tp.hwrap.classList.remove("tp-24");
            }
            tp.hwrap.classList.add("show");
        },

        // (E) SET TIME
        set: () => {
            // (E1) TIME TO FIELD
            tp.setfield.value = tp.hhr.innerHTML + ":" + tp.hmin.innerHTML; // + " " + tp.hap.innerHTML;
            tp.hwrap.classList.remove("show");

            // (E2) RUN AFTER, IF SET
            if (tp.setafter) {
                tp.setafter(tp.setfield.value);
            }
        }
    };

    // (F) ATTACH ON PAGE LOAD
    document.addEventListener("DOMContentLoaded", () => {
        tp.init();
    });
    ///////////////////////////////////
    const reports = document.querySelector(".reports");
    const reports_add = document.querySelector(".reports-add");
    const report_item_code = `<div class="card mb-3">
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label">زمان ورود</label>
                    <input name="time_start[]" type="text" class="form-control time-picker">
                </div>
                <div class="mb-3">
                    <label class="form-label">زمان خروج</label>
                    <input name="time_end[]" type="text" class="form-control time-picker">
                </div>
                <div class="mb-3">
                    <label class="form-label">زمان تدریس</label>
                    <input name="time_teach[]" type="text" class="form-control time-picker" value="00:00">
                </div>
                <div class="mb-3">
                    <label for="descriptionInput" class="form-label">گزارش فعالیت</label>
                    <textarea name="description[]" class="form-control" id="descriptionInput" rows="6"></textarea>
                </div>

            </div>
        </div>`;
    const time_picker_handle = () => {
        const time_pickers = document.querySelectorAll(".time-picker");
        time_pickers.forEach((time_picker) => {
            tp.attach({
                target: time_picker,
                "24": true
            });
        });
    };
    window.addEventListener("load", () => {
        reports.innerHTML = report_item_code;
        time_picker_handle();
    });
    reports_add.addEventListener("click", () => {
        const div = document.createElement("div");
        div.innerHTML = report_item_code;
        reports.appendChild(div);
        time_picker_handle();
    });
</script>

</body>

</html>
