<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kup grę</title>
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

        p {
            text-align: center;
        }

        button {
            background-color: #007BFF;
            color: #fff;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin: 10px;
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
        $role = $_SESSION['rola'];

        if ($role === 'user') {
            $query = "SELECT g.id_gry, k.ilosc, k.cena_cala FROM Koszyk k
            JOIN Gry g ON k.id_gry = g.id_gry
            WHERE k.id_klienta = $id_klienta";

            $result = $conn->query($query);

            if ($result->num_rows > 0) {
                echo "<h2>Jesteś pewny że chcesz kupić?</h2>";
                echo "<button onclick='confirmPurchase()'>Tak</button>";
                echo "<button onclick='cancelPurchase()'>Nie</button>";
            } else {
                echo "<p>Twój koszyk jest pusty.</p>";
            }
        }
    ?>

<script>
        function confirmPurchase() {
            var confirmPurchase = confirm("Jesteś pewny że chcesz kupić?");
            if (confirmPurchase) {
                window.location.href = "process_purchase.php";
            } else {
                alert("Sprzedaż odrzucona.");
            }
        }

        function cancelPurchase() {
            alert("Sprzedaż odrzucona.");
        }
    </script>
</body>
</html>
