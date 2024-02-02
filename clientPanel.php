<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Panel Klienta</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            color: #333;
        }

        h2 {
            color: #007BFF;
            text-align: center;
        }

        form {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        label {
            display: block;
            margin: 10px 0 5px;
            font-weight: bold;
        }

        input {
            width: 100%;
            padding: 10px;
            box-sizing: border-box;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button {
            background-color: #007BFF;
            color: #fff;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <?php
    require("menu.php");
    require("db.php");

  
    $id_klienta = $_SESSION['id_klienta'];

    $query = "SELECT * FROM Klienci WHERE id_klienta = $id_klienta";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $imie = $row['imie'];
        $nazwisko = $row['nazwisko'];
        $ulica = $row['ulica'];
        $miasto = $row['miasto'];
        $kod_pocztowy = $row['kod_pocztowy'];
        $numer_telefonu = $row['numer_telefonu'];
        $email = $row['email'];
        $login = $row['login'];
        $haslo = $row['haslo'];
    } else {
        echo "Error: Klient nie znaleziony.";
        exit();
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $new_imie = $_POST['imie'];
        $new_nazwisko = $_POST['nazwisko'];
        $new_ulica = $_POST['ulica'];
        $new_miasto = $_POST['miasto'];
        $new_kod_pocztowy = $_POST['kod_pocztowy'];
        $new_numer_telefonu = $_POST['numer_telefonu'];
        $new_email = $_POST['email'];
        $new_login = $_POST['login'];
        $new_haslo = $_POST['haslo'];
       

      
        $login_check_query = "SELECT id_klienta FROM Klienci WHERE login = '$new_login' AND id_klienta != $id_klienta";
        $login_check_result = $conn->query($login_check_query);

        if ($login_check_result->num_rows > 0) {
            echo "Login w użyciu.";
        } else {
         
            $update_query = "UPDATE Klienci
                             SET imie = '$new_imie', nazwisko = '$new_nazwisko', ulica = '$new_ulica',
                                 miasto = '$new_miasto', kod_pocztowy = '$new_kod_pocztowy',
                                 numer_telefonu = '$new_numer_telefonu', email = '$new_email',
                                 login = '$new_login', haslo = '$new_haslo'
                             WHERE id_klienta = $id_klienta";

            if ($conn->query($update_query)) {
                echo "Zaktualizowano informacje";
            } else {
                echo "Error" . $conn->error;
            }
        }
    }
    ?>

    <h2>Edytuj swoje dane</h2>
    <form method="post" action="clientPanel.php">
        <label for="imie">Imie:</label>
        <input type="text" name="imie" value="<?php echo $imie; ?>" required>

        <label for="nazwisko">Nazwisko:</label>
        <input type="text" name="nazwisko" value="<?php echo $nazwisko; ?>" required>

        <label for="ulica">Ulica:</label>
        <input type="text" name="ulica" value="<?php echo $ulica; ?>" required>

        <label for="miasto">Miasto:</label>
        <input type="text" name="miasto" value="<?php echo $miasto; ?>" required>

        <label for="kod_pocztowy">Kod pocztowy:</label>
        <input type="text" name="kod_pocztowy" value="<?php echo $kod_pocztowy; ?>" required>

        <label for="numer_telefonu">Numer telefonu:</label>
        <input type="text" name="numer_telefonu" value="<?php echo $numer_telefonu; ?>" required>

        <label for="email">Email:</label>
        <input type="email" name="email" value="<?php echo $email; ?>" required>

        <label for="login">Login:</label>
        <input type="text" name="login" value="<?php echo $login; ?>" required>

        <label for="haslo">Haslo:</label>
        <input type="password" name="haslo" required>

        <button type="submit">Zaktualizuj</button>
    </form>
</body>
</html>
