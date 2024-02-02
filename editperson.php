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
            $id = $_POST["employeeId"];
            $checkQuery = "SELECT id_stanowiska FROM Pracownicy WHERE id_pracownika = $id";
            $result = $conn->query($checkQuery);
        
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $id_stanowiska = $row['id_stanowiska'];
        
                switch ($id_stanowiska) {
                    case 1:
                        editSalesperson($conn);
                        break;
                    default:
                        editManager($conn);
                        break;
                }
            } else {
                echo "Nieprawidłowe ID pracownika.";
            }
        }

    function editSalesperson($conn) {
        $id = $_POST["employeeId"];
    $checkQuery = "SELECT * FROM Pracownicy WHERE id_pracownika = $id AND id_stanowiska = (SELECT id_stanowiska FROM Stanowiska WHERE nazwa_stanowiska = 'sprzedawca')";
    $result = $conn->query($checkQuery);

    if ($result->num_rows > 0) {
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

        $checkLoginQuery = "SELECT id_pracownika FROM Pracownicy WHERE login = '$newLogin' AND id_pracownika != $id";
        $loginResult = $conn->query($checkLoginQuery);

        if ($loginResult->num_rows > 0) {
            echo "Login '$newLogin' jest już w użyciu.";
        } else {
            $updateQuery = "UPDATE Pracownicy 
                            SET login = '$newLogin', haslo = '$newPassword', 
                                imie = '$newImie', nazwisko = '$newNazwisko', 
                                ulica = '$newUlica', miasto = '$newMiasto', 
                                kod_pocztowy = '$newKodPocztowy', 
                                numer_telefonu = '$newNumerTelefonu', 
                                email = '$newEmail', 
                                id_stanowiska = $newIdStanowiska
                            WHERE id_pracownika = $id";

            if ($conn->query($updateQuery)) {
                echo "Edycja udana";
            } else {
                echo "Błąd " . $conn->error;
            }
        }
    } else {
        echo "Nie znaleziono kierownika.";
    }
    }

    function editManager($conn) {
        $id = $_POST["employeeId"];
    $checkQuery = "SELECT * FROM Pracownicy WHERE id_pracownika = $id AND id_stanowiska = (SELECT id_stanowiska FROM Stanowiska WHERE nazwa_stanowiska = 'kierownik')";
    $result = $conn->query($checkQuery);

    if ($result->num_rows > 0) {
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

        $checkLoginQuery = "SELECT id_pracownika FROM Pracownicy WHERE login = '$newLogin' AND id_pracownika != $id";
        $loginResult = $conn->query($checkLoginQuery);

        if ($loginResult->num_rows > 0) {
            echo "Login '$newLogin' jest już w użyciu.";
        } else {
            $updateQuery = "UPDATE Pracownicy 
                            SET login = '$newLogin', haslo = '$newPassword', 
                                imie = '$newImie', nazwisko = '$newNazwisko', 
                                ulica = '$newUlica', miasto = '$newMiasto', 
                                kod_pocztowy = '$newKodPocztowy', 
                                numer_telefonu = '$newNumerTelefonu', 
                                email = '$newEmail', 
                                id_stanowiska = $newIdStanowiska
                            WHERE id_pracownika = $id";

            if ($conn->query($updateQuery)) {
                echo "Edycja udana";
            } else {
                echo "Błąd " . $conn->error;
            }
        }
    } else {
        echo "Nie znaleziono kierownika.";
    }
}

    
    ?>

    <h2>Edytuj pracownika</h2>
    <form method="post" action="editperson.php">
        <input type="hidden" name="action" value="editPerson">


        <label for="employeeId">ID pracownika:</label>
        <input type="number" name="employeeId" required>

        <label for="newLogin">Nowy login:</label>
        <input type="text" name="newLogin" required>

        <label for="newPassword">Nowe hasło:</label>
        <input type="text" name="newPassword" required>

        <label for="newImie">Nowe imię:</label>
        <input type="text" name="newImie" required>

        <label for="newNazwisko">Nowe nazwisko:</label>
        <input type="text" name="newNazwisko" required>

        <label for="newUlica">Nowa ulica:</label>
        <input type="text" name="newUlica" required>

        <label for="newMiasto">Nowe miasto:</label>
        <input type="text" name="newMiasto" required>

        <label for="newKodPocztowy">Nowy kod pocztowy:</label>
        <input type="text" name="newKodPocztowy" required>

        <label for="newNumerTelefonu">Nowy numer telefonu:</label>
        <input type="text" name="newNumerTelefonu" required>

        <label for="newEmail">Nowy email:</label>
        <input type="email" name="newEmail" required>

        <label for="newIdStanowiska">Nowe ID stanowiska:</label>
        <input type="number" name="newIdStanowiska" required>

        <button type="submit">Zatwierdź</button>
    </form>
</body>
</html>
