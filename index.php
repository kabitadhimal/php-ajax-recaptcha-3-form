<?php include __DIR__.'/bootstrap.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <style>
        .has-error::placeholder { /* Chrome, Firefox, Opera, Safari 10.1+ */
            color: red !important;
            opacity: 1; /* Firefox */
        }

        .has-error:-ms-input-placeholder { /* Internet Explorer 10-11 */
            color: red !important;
        }

        .has-error::-ms-input-placeholder { /* Microsoft Edge */
            color: red !important;
        }
        .success {
            border-color: #49c659;
            color: #49c659;
        }
        .spam-error {
            border-color: #EE3124;
            color: #EE3124;
        }
        .input-error{
            display: none;
            font-size: 11px;
            color: red;
            margin-top: 5px;
        }

        .has-error + .input-error{
            display: block;
        }
    </style>
    <script src="assets/js/jquery-3.6.0.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
</head>
<body >

<main id="main">
    <div class="container" style="margin-top: 50px;">
        <section id="contact">
                <div class="row">
                    <div class="col-md-6 col-md-offset-12">
                        <h4 style="padding: 40px;">Contact Form</h4>
                        <?php
                        include "form/contact-form.php";
                        include "form/form-js.php";
                        ?>
                </div>
            </div>
        </section>
    </div>
</body>


</html>