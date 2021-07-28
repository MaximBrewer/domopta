<?php
session_start();
if(!isset($_SESSION['ppp'])):
    if(isset($_POST['login']) && isset($_POST['password'])){
        if($_POST['login'] == 'LW-foto' && $_POST['password'] == '@620090-LW620010)('){
            $_SESSION['ppp'] = 1;
            header("Refresh:0");
            die();
        }
    }
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <style>
            body {
                padding-top: 70px;
            }
            .wrapper {
                width: 550px;
                margin: 0 auto;
                text-align: center;
            }
            form {
                display: inline-block;
                text-align: left;
                width: 272px;
            }
            form > div {
                margin-bottom: 15px;
            }
            input {
                border: 1px solid #000;
                height: 30px;
                font-size: 14px;
                padding: 5px;
                font-family: Arial;
            }
            label {
                font-family: Arial;
            }
            input:hover {
                outline: none;
                box-shadow: 0 0 3px #456;
                -webkit-box-shadow: 0 0 3px #456;
                -moz-box-shadow: 0 0 3px #456;
                border: 1px solid #000;
            }
            input[type=submit] {
                border: 2px solid #000;
                padding: 10px 20px;
                height: auto;
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
                box-shadow: none;
            }
            input[type=submit]:focus {
                outline: none;
            }
            .line {
                display: flex;
                justify-content: space-between;
                align-items: center;
            }
        </style>
    </head>
    <body>
    <div class="wrapper">
    <form method="post" action="">
        <div class="line">
            <label>Логин</label>
            <input type="text" name="login">
        </div>
        <div class="line">
            <label>Пароль</label>
            <input type="password" name="password">
        </div>
        <div style="text-align: center">
          <input type="submit" name="submit" value="Войти"/>
        </div>
    </form>
    </div>
    </body>
    </html>

<?php
die();
endif;