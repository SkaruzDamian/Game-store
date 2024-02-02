<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Koszyk</title>
    
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f4f4f4;
            color: #333;
        }

        div {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
            padding: 10px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        img {
            width: 100px;
            height: 100px;
            margin-right: 10px;
        }

        button {
            background-color: #dc3545;
            color: #fff;
            padding: 8px 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: #c82333;
        }

        form {
            margin-top: 20px;
            text-align: center;
        }

        input[type="submit"] {
            background-color: #007BFF;
            color: #fff;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        p {
            text-align: center;
            font-size: 18px;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <?php
    require("menu.php");
    require("db.php");
  
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
   
   if (isset($_POST["id_gry"])) {
       $gameId = $_POST["id_gry"];
       $id_klienta = $_SESSION['id_klienta'];
       $removeQuery = "DELETE FROM Koszyk WHERE id_gry = $gameId AND id_klienta = $id_klienta";
       $result = $conn->query($removeQuery);
       if (!$result) {
        die("Error: " . $conn->error);
    }
       header("Location: index.php");

   }
}

$id_klienta = $_SESSION['id_klienta'];
$sql = "SELECT DISTINCT g.id_gry, g.zdjecie, g.tytul, k.cena_cala
        FROM Gry g
        JOIN Koszyk k ON g.id_gry = k.id_gry
        JOIN Klienci c ON k.id_klienta = $id_klienta;";
$result = $conn->query($sql);


if ($result->num_rows > 0) {
    echo "<div style='float: left; width: 70%;'>";
    while ($row = $result->fetch_assoc()) {
        echo "<div>";
        echo "<img src='" . $row['zdjecie'] . "' alt='" . $row['tytul'] . "' style='width: 100px; height: 100px;'>";
        echo "<p>{$row['cena_cala']}</p>";
        echo "<span>" . $row['tytul'] . "</span>";
        echo "<form method='post'>";
        $id_gry = $row['id_gry'];
        echo "<input type='hidden' name='id_gry' value='$id_gry'>";
        echo "<button type='submit'>Usuń</button>";
        echo "</form>";
        echo "</div>";
    }
    echo "</div>";
} else {
    echo "<p>Koszyk jest pusty.</p>";
}
    ?>

    <div style="clear: both;"></div>

    <form action="buygame.php" method="post">
        <input type="submit" value="Kup">
    </form>

</body>
</html>
