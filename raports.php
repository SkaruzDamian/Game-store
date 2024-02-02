<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Raporty</title>
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

        form {
            margin-top: 20px;
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
        }

        button {
            background-color: #4caf50;
            color: #fff;
            padding: 10px;
            margin: 5px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: #45a049;
        }

        table {
            border-collapse: collapse;
            width: 80%;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #4caf50;
            color: #fff;
        }
    </style>
</head>
<body>
    <?php
    require("menu.php");
    require("db.php");

    function executeQueryAndDisplay($query, $columns)
    {
        require("db.php");
        $result = $conn->query($query);

        if ($result->num_rows > 0) {
            echo "<table border='1'>";
            echo "<tr>";
            foreach ($columns as $column) {
                echo "<th>$column</th>";
            }
            echo "</tr>";

            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                foreach ($columns as $column) {
                    echo "<td>{$row[$column]}</td>";
                }
                echo "</tr>";
            }

            echo "</table>";
        } else {
            echo "Nie znaleziono rekordów.";
        }
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['btn_unique_customers'])) {
            $query = "SELECT COUNT(DISTINCT id_klienta) AS 'Liczba klientów, którzy zrobili zakupy'
                      FROM Historia_Zakupow";

            $columns = ["Liczba klientów, którzy zrobili zakupy"];
            executeQueryAndDisplay($query, $columns);
        } elseif (isset($_POST['btn_status_ratio'])) {
            $query = "SELECT
                          (SELECT COUNT(*) FROM Historia_Zakupow WHERE status = 'zakupiono') AS 'Licznik sprzedanych gier',
                          (SELECT COUNT(*) FROM Historia_Zakupow WHERE status = 'zwrócono') AS 'Licznik zwróconych gier'";
                          
            $columns = ["Licznik sprzedanych gier", "Licznik zwróconych gier"];
            executeQueryAndDisplay($query, $columns);
        } elseif (isset($_POST['btn_least_sold_games'])) {
            $query = "SELECT Zamowienia.id_gry, tytul, COUNT(id_zamowienia) AS 'Najwięcej sprzedano'
                      FROM Zamowienia
                      JOIN Gry ON Zamowienia.id_gry = Gry.id_gry
                      GROUP BY id_gry
                      ORDER BY 'Najwięcej sprzedano' ASC
                      LIMIT 2";

            $columns = ["id_gry", "tytul", "Najwięcej sprzedano"];
            executeQueryAndDisplay($query, $columns);
        } elseif (isset($_POST['btn_higher_than_average_price'])) {
            $query = "SELECT id_zamowienia, id_klienta, id_gry, cena
                      FROM Zamowienia
                      WHERE cena > (SELECT AVG(cena) FROM Zamowienia)";

            $columns = ["id_zamowienia", "id_klienta", "id_gry", "cena"];
            executeQueryAndDisplay($query, $columns);
        }
    }
    ?>

    <form method="post" action="raports.php">
        <button type="submit" name="btn_unique_customers">Liczba unikalnych klientów, którzy dokonali zakupu</button>
        <button type="submit" name="btn_status_ratio">Statusy sprzedaży i zwrotów</button>
        <button type="submit" name="btn_least_sold_games">Najbardziej sprzedawane gry</button>
        <button type="submit" name="btn_higher_than_average_price">Gry z ceną wiekszą od średniej</button>
    </form>
</body>
</html>
