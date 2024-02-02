<!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta http-equiv="X-UA-Compatible" content="IE=edge">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Zamówienia</title>
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

        div {
            margin-top: 20px;
        }

        form {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            margin-top: 10px;
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
                <?php require("menu.php");
                require("db.php"); ?>
 <div>
 <div>
        

        <form method="post" action="editorder.php">
            <button type="submit" name="editOrder">Edytuj zamówienie</button>
        </form>

        <form method="post" action="orders.php">
            <button type="submit" name="ordersWithTimeFunctions">Zamówienia z tego tygodnia</button>
        </form>

        <form method="post" action="orders.php">
            <button type="submit" name="ordersWithSubQueries">Zamówienia z minimum 2 grami</button>
        </form>


        <form method="post" action="orders.php">
            <label>Wyświetl posortowane zamówienia:</label>
            <select name="sortOption" onchange="this.form.submit()">
                <option value="price">Według ceny</option>
                <option value="orderDate">Według czasu</option>
                <option value="quantity">Według ilości</option>
            </select>
            <input type="hidden" name="sortOrders" value="true">
        </form>
    </div>


</body>
</html>

<?php

require("db.php");

if (isset($_POST['sortOrders'])) {
        
        $sortOption = $_POST['sortOption'];

        switch ($sortOption) {
            case 'price':
                $query = "SELECT * FROM Zamowienia ORDER BY cena";
                break;
            case 'orderDate':
                $query = "SELECT * FROM Zamowienia ORDER BY data_zamowienia";
                break;
            case 'quantity':
                $query = "SELECT * FROM Zamowienia ORDER BY ilosc";
                break;
            default:
                
                break;
        }

       
        $result = $conn->query($query);

        if ($result->num_rows > 0) {
            echo "<table border='1'>";
            echo "<tr><th>ID zamówienia</th><th>ID klienta</th><th>ID gry</th><th>Ilość</th><th>Data zamówienia</th><th>Cena</th><th>Status</th></tr>";

            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>{$row['id_zamowienia']}</td>";
                echo "<td>{$row['id_klienta']}</td>";
                echo "<td>{$row['id_gry']}</td>";
                echo "<td>{$row['ilosc']}</td>";
                echo "<td>{$row['data_zamowienia']}</td>";
                echo "<td>{$row['cena']}</td>";
                echo "<td>{$row['status']}</td>";
                echo "</tr>";
            }

            echo "</table>";
        } else {
            echo "No orders found.";
        }
    } elseif (isset($_POST['ordersWithTimeFunctions'])) {
            $query = "SELECT * FROM Zamowienia WHERE data_zamowienia > (SELECT DATE_SUB(NOW(), INTERVAL 7 DAY)) ORDER BY data_zamowienia DESC";

$result = $conn->query($query);

if ($result->num_rows > 0) {
    echo "<table border='1'>";
    echo "<tr><th>ID zamówienia</th><th>ID klienta</th><th>ID gry</th><th>Ilość</th><th>Data zamówienia</th><th>Cena</th><th>Status</th></tr>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>{$row['id_zamowienia']}</td>";
        echo "<td>{$row['id_klienta']}</td>";
        echo "<td>{$row['id_gry']}</td>";
        echo "<td>{$row['ilosc']}</td>";
        echo "<td>{$row['data_zamowienia']}</td>";
        echo "<td>{$row['cena']}</td>";
        echo "<td>{$row['status']}</td>";
        echo "</tr>";
    }

    echo "</table>";
} else {
    echo "No orders found.";
}
        } elseif (isset($_POST['ordersWithSubQueries'])) {
            $query = "SELECT
            Klienci.id_klienta,
            Klienci.imie,
            Klienci.nazwisko,
            Klienci.email
          FROM
            Klienci
          WHERE
            Klienci.id_klienta IN (
                SELECT id_klienta
                FROM Zamowienia
                GROUP BY id_klienta
                HAVING COUNT(id_zamowienia) > 2
            )";

$result = $conn->query($query);

if ($result->num_rows > 0) {
    echo "<table border='1'>";
    echo "<tr><th>ID</th><th>Imie</th><th>Nazwisko</th><th>Email</th></tr>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>{$row['id_klienta']}</td>";
        echo "<td>{$row['imie']}</td>";
        echo "<td>{$row['nazwisko']}</td>";
        echo "<td>{$row['email']}</td>";
        echo "</tr>";
    }

    echo "</table>";
} else {
    echo "Nie znaleziono rekordów.";
}
        }
    ?>