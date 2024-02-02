<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historia zamówień</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }


        form {
            margin: 20px 0;
        }

        button {
            padding: 10px;
            margin: 5px;
            font-size: 16px;
            cursor: pointer;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #4caf50;
            color: white;
        }

        h2, p {
            margin-top: 20px;
        }

        p {
            font-size: 18px;
        }
    </style>

</head>
<body>
        <?php
 require("menu.php");
?>
  <?php
  
    $customerId = $_SESSION['id_klienta'];
    if (isset($_POST['btnPurchaseHistory'])) {
        $sql = "SELECT h.id_historii_zakupow, g.tytul, h.ilosc, h.cena, h.data_zakupu
                FROM Historia_Zakupow h
                JOIN Gry g ON h.id_gry = g.id_gry
                WHERE h.id_klienta = $customerId";

        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo "<h2>Historia zakupów:</h2>";
            echo "<table border='1'>
                    <tr>
                        <th>Gra</th>
                        <th>Ilość</th>
                        <th>Cena</th>
                        <th>Data</th>
                    </tr>";

            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        
                        <td>{$row['tytul']}</td>
                        <td>{$row['ilosc']}</td>
                        <td>{$row['cena']}</td>
                        <td>{$row['data_zakupu']}</td>
                    </tr>";
            }

            echo "</table>";
        } else {
            echo "Nieznaleziono zamówień";
        }
    }


    if (isset($_POST['btnHaving'])) {
        $sql = "SELECT AVG(cena) as średnia
                FROM Historia_Zakupow
                WHERE id_klienta = $customerId
                HAVING średnia > 50";

        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            echo "<h2>Średnia cena zamówień powyżej 100 złotych</h2>";
            echo "<p>Średnia cena {$row['średnia']}</p>";
        } else {
            echo "Nieznaleziono zamówień";
        }
    }

    if (isset($_POST['btnSubquery'])) {
        $sql = "SELECT g.tytul
        FROM Gry g
        WHERE g.id_gry IN (
            SELECT id_gry 
            FROM Historia_Zakupow 
            WHERE id_klienta = $customerId
              AND data_zakupu >= CURDATE() - INTERVAL 7 DAY
        )";

        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo "<h2>Zamówienia z podzapytaniem:</h2>";
            echo "<table border='1'>
                    <tr>
                        <th>Tytuł</th>
                    </tr>";

            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['tytul']}</td>
                    </tr>";
            }

            echo "</table>";
        } else {
            echo "Nie znaleziono zakupów.";
        }
    }

    
    if (isset($_POST['btnRegex'])) {
        $sql = "SELECT g.tytul
                FROM Gry g
                JOIN Historia_Zakupow h ON g.id_gry = h.id_gry
                WHERE h.id_klienta = $customerId
                AND g.tytul REGEXP '^G'";

        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo "<h2>Zakupy zaczynające się na G:</h2>";
            echo "<table border='1'>
                    <tr>
                        <thTytul</th>
                    </tr>";

            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['tytul']}</td>
                    </tr>";
            }

            echo "</table>";
        } else {
            echo "Nieznaleziono zakupów";
        }
    }

   
    $conn->close();
    ?>

    <form method="post">
        <button type="submit" name="btnPurchaseHistory">Wyświetl historię zakupów</button>
        <button type="submit" name="btnHaving">Zamówienia z having</button>
        <button type="submit" name="btnSubquery">Zamówienia z podzapytaniem</button>
        <button type="submit" name="btnRegex">Zamówienia z Regex</button>
    </form>
</body>
</html>