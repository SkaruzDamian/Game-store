<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logowanie</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px;
            text-align: center;
        }

        h1 {
            color: #333;
        }

        .login-input {
            width: 100%;
            margin: 10px 0;
            padding: 8px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .login-button {
            width: 100%;
            background-color: #4caf50;
            color: #fff;
            padding: 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .login-button:hover {
            background-color: #45a049;
        }

        .link {
            margin-top: 10px;
        }

        a {
            color: #007bff;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
<?php
require('db.php');
session_start();

if (isset($_POST["login"])) {
    $login = $_POST["login"];
    $haslo = $_POST["haslo"];

    
    $sqlClients = "SELECT `id_klienta`, `login`, `haslo` FROM `Klienci` WHERE `login`='$login' AND `haslo`='$haslo'";
    $resultClients = $conn->query($sqlClients);

  

    if ($resultClients->num_rows == 1) {
        $row = $resultClients->fetch_object();
        $_SESSION["login"] = $row->login;
        $_SESSION["id_klienta"] = $row->id_klienta;
        $_SESSION["rola"] = "user";
        header("Location: index.php");
        exit();
    }

    $sqlEmployees = "SELECT `id_pracownika`, `login`, `haslo`, `id_stanowiska`
                     FROM `Pracownicy`  
                     WHERE `login`='$login' AND `haslo`='$haslo'";
    $resultEmployees = $conn->query($sqlEmployees);

    if ($resultEmployees->num_rows == 1) {
        $row = $resultEmployees->fetch_object();
        $ID = $row->id_stanowiska;

        $sqlPosition = "SELECT `id_stanowiska`, `nazwa_stanowiska` 
                        FROM `Stanowiska`
                        WHERE `id_stanowiska`='$ID'";
        $resultPosition = $conn->query($sqlPosition);

        if ($resultPosition->num_rows == 1) {
            $rowPosition = $resultPosition->fetch_object();
            $_SESSION["login"] = $row->login;
            $_SESSION["id_pracownika"] = $row->id_pracownika;
            $_SESSION["rola"] = $rowPosition->nazwa_stanowiska;
            header("Location: index.php");
            exit();
        }
    }

    echo "<div class='form'>
            <h3>Nieprawidłowy login lub hasło.</h3><br/>
            <p class='link'>Ponów próbę <a href='login.php'>logowania</a>.</p>
          </div>";
} else {
?>
    <form class="form" method="post" name="login">
        <h1 class="login-title">Logowanie</h1>
        <input type="text" class="login-input" name="login" placeholder="Login" autofocus="true"/>
        <input type="password" class="login-input" name="haslo" placeholder="Hasło"/>
        <input type="submit" value="Zaloguj" name="submit" class="login-button"/>
    </form>
<?php
}
?>
</body>
</html>
