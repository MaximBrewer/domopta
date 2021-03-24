<?php include 'login.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <script src="js/jquery.js"></script>
    <script src="js/jquery.form.min.js"></script>
    <script src="js/script.js"></script>
    <style>
        #status{
            display: none;
            position: absolute;
            background-color: rgba(0,0,0, .5);
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            justify-content: center;
            align-items: center;
        }
        body {
            padding-top: 50px;
        }
        .wrapper {
            width: 550px;
            margin: 0 auto;
        }
        form {
            margin: 20px auto;
            padding: 5px 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
        }
        form hr {
            width: 100%;
        }
        input[type=submit] {
            border: 2px solid #000;
            padding: 10px 20px;
            text-transform: uppercase;
            color: #000;
            background-color: #fff;
            -webkit-transition: all 400ms ease;
            transition: all 400ms ease;
            cursor: pointer;
        }
        input[type=submit]:hover {
            color: #fff;
            background: #000;
        }
        input[type=submit]:focus {
            outline: none;
        }
        #stratForm {
            justify-content: center;
        }
        .gallery {
            text-align: center;
        }
    </style>
</head>
<body>
<div class="wrapper">
<form method="post" id="submitForm" enctype="multipart/form-data" action="upload.php">
    <div>
        <label>Выберите изображения: </label>
        <input type="file" name="images[]" id="imgs" multiple >
    </div>

    <input type="submit" name="submit" value="Загрузить"/>

</form>
<div class="gallery" id="imagesPrev"></div>

    <hr>

<form method="post" id="submitFormCSV" enctype="multipart/form-data" action="upload_csv.php">
    <div>
        <label>CSV: </label>
        <input type="file" name="csv" id="csv">
    </div>
    <input type="submit" name="submit" value="Загрузить"/>

</form>
<div class="gallery" id="csvPrev"></div>

    <hr>

<form method="post" id="stratForm" enctype="multipart/form-data" action="process.php">
    <input type="submit" name="submit" value="Старт"/>
</form>
<div class="gallery" id="startPrev"></div>



<div id="status"><img src="loader.gif"/></div>
</div>


</body>
</html>