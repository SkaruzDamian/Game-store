<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rejestracja</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .form {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px;
            text-align: center;
        }

        .login-title {
            color: #333;
        }

        .login-input,
        .imie-input,
        .nazwisko-input,
        .ulica-input,
        .miasto-input,
        .kod_pocztowy-input,
        .numer_telefonu-input,
        .email-input,
        .login-button {
            width: 100%;
            margin-top: 10px;
            padding: 8px;
            box-sizing: border-box;
        }

        .login-button {
            background-color: #4caf50;
            color: #fff;
            cursor: pointer;
        }

        .login-button:hover {
            background-color: #45a049;
        }

        .link {
            margin-top: 10px;
        }

        footer {
            margin-top: 20px;
            text-align: center;
        }
    </style>
</head>
<body>
    
<?php
 require("db.php");
 if (isset($_POST["login"])) {
 $login = $_POST["login"];
 $haslo = $_POST["haslo"];
$imie = $_POST["imie"];
$nazwisko = $_POST["nazwisko"];
$ulica = $_POST["ulica"];
$miasto = $_POST["miasto"];
$kod_pocztowy = $_POST["kod_pocztowy"];
$numer_telefonu = $_POST["numer_telefonu"];
$email = $_POST["email"];
 $sql = "INSERT INTO Klienci (login, haslo, imie, nazwisko, ulica, miasto, kod_pocztowy, numer_telefonu, email, rola) VALUES ('$login', '$haslo', '$imie', '$nazwisko', '$ulica', '$miasto', '$kod_pocztowy', '$numer_telefonu', '$email', 'user')";
 $result = $conn->query($sql);
 if ($result) {
 echo "<div class='form'>
 <h3>Zostałeś pomyślnie zarejestrowany.</h3><br/>
 <p class='link'>Kliknij tutaj, aby się <a href='login.php'>zalogować</a></p>
 </div>";
} else {
echo "<div class='form'>
<h3>Nie wypełniłeś wymaganych pól.</h3><br/>
<p class='link'>Kliknij tutaj, aby ponowić próbę <a
href='registration.php'>rejestracji</a>.</p>
</div>";
}
} else {
?>
<form class="form" action="" method="post">
 <h1 class="login-title">Rejestracja</h1>
 <input type="text" class="login-input" name="login" placeholder="Login" required/>
 <input type="password" class="login-input" name="haslo" placeholder="Hasło" required/>
 <input type="text" class="imie-input" name="imie" placeholder="imie" required/>
 <input type="text" class="nazwisko-input" name="nazwisko" placeholder="nazwisko" required/>
 <input type="text" class="ulica-input" name="ulica" placeholder="ulica" required/>
 <input type="text" class="miasto-input" name="miasto" placeholder="miasto" required/>
 <input type="text" class="kod_pocztowy-input" name="kod_pocztowy" placeholder="kod_pocztwoy" required/>
 <input type="text" class="numer_telefonu-input" name="numer_telefonu" placeholder="numer_telefonu" required/>
 <input type="text" class="email-input" name="email" placeholder="email" required/>
 <input type="submit" name="submit" value="Zarejestruj się" class="login-button">
 <p class="link"><a href="login.php">Zaloguj się</a></p>
 </form>
<?php
 }
?>


</body>
</html>