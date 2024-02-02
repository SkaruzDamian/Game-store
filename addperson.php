<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edytuj pracownika</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
        }

        h2 {
            margin-top: 20px;
        }

        form {
            margin-top: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        label {
            margin-bottom: 5px;
        }

        input {
            padding: 8px;
            margin-bottom: 10px;
            box-sizing: border-box;
        }

        button {
            background-color: #4caf50;
            color: #fff;
            padding: 10px;
            margin-top: 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <?php
    require("menu.php");
    require("db.php");
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
           
      
        $newLogin = $_POST['newLogin'];
        $newPassword = $_POST['newPassword'];
        $newImie = $_POST['newImie'];
        $newNazwisko = $_POST['newNazwisko'];
        $newUlica = $_POST['newUlica'];
        $newMiasto = $_POST['newMiasto'];
        $newKodPocztowy = $_POST['newKodPocztowy'];
        $newNumerTelefonu = $_POST['newNumerTelefonu'];
        $newEmail = $_POST['newEmail'];
        $newIdStanowiska = $_POST['newIdStanowiska'];

        $checkLoginQuery = "SELECT id_pracownika FROM Pracownicy WHERE login = '$newLogin'";
        $loginResult = $conn->query($checkLoginQuery);

        if ($loginResult->num_rows > 0) {
            echo "Login '$newLogin' jest już w użyciu.";
        } else {
            $updateQuery = "INSERT INTO Pracownicy (login, haslo, imie, nazwisko, ulica, miasto, kod_pocztowy, numer_telefonu, email, data_zatrudnienia, data_zwolnienia, id_stanowiska)
            VALUES ('$newLogin', '$newPassword', '$newImie', '$newNazwisko', '$newUlica', '$newMiasto', '$newKodPocztowy', '$newNumerTelefonu', '$newEmail', NOW(), NULL, $newIdStanowiska)";
            

            if ($conn->query($updateQuery)) {
                echo "Dodano pracownika";
            } else {
                echo "Błąd " . $conn->error;
            }
        }
    }

    
    ?>

    <h2>Dodaj pracownika</h2>
    <form method="post" action="addperson.php">
        <input type="hidden" name="action" value="addperson">

        <label for="newLogin"> login:</label>
        <input type="text" name="newLogin" required>

        <label for="newPassword"> hasło:</label>
        <input type="text" name="newPassword" required>

        <label for="newImie"> imię:</label>
        <input type="text" name="newImie" required>

        <label for="newNazwisko"> nazwisko:</label>
        <input type="text" name="newNazwisko" required>

        <label for="newUlica"> ulica:</label>
        <input type="text" name="newUlica" required>

        <label for="newMiasto"> miasto:</label>
        <input type="text" name="newMiasto" required>

        <label for="newKodPocztowy"> kod pocztowy:</label>
        <input type="text" name="newKodPocztowy" required>

        <label for="newNumerTelefonu"> numer telefonu:</label>
        <input type="text" name="newNumerTelefonu" required>

        <label for="newEmail"> email:</label>
        <input type="email" name="newEmail" required>

        <label for="newIdStanowiska"> ID stanowiska:</label>
        <input type="number" name="newIdStanowiska" required>

        <button type="submit">Zatwierdź</button>
    </form>
</body>
</html>
