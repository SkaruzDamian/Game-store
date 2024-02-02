<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Szczegóły</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<script src="jquery-3.6.4.min.js"></script>
<style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            color: #333;
        }

        .main {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        .game-title {
            color: #007BFF;
        }

        .opis {
            color: #6C757D;
        }

        .obrazek {
            max-width: 100%;
            height: auto;
            margin: 10px 0;
            border-radius: 8px;
        }

        .info-box {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            margin-top: 10px;
        }

        .category {
            font-weight: bold;
            color: #007BFF;
        }

        .buy-game-box {
            margin-top: 20px;
            text-align: center;
        }

        label {
            display: block;
            margin-bottom: 5px;
        }

        input {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
            margin-bottom: 10px;
        }

        button {
            background-color: #28A745;
            color: #fff;
            padding: 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: #218838;
        }

        .action-buttons {
            margin-top: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .action-buttons a,
        .action-buttons button {
            padding: 10px;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
            color: #fff;
            text-align: center;
        }

        .action-buttons a {
            background-color: #007BFF;
        }

        .action-buttons button {
            background-color: #DC3545;
        }
    </style>
<?php
 require("menu.php");

?>



<div class="main">


<?php 

$id = $_GET["id_gry"];
require("db.php");
echo "<span class='object'>";

$sql = "SELECT g.id_gry, g.opis, k.nazwa_kategorii, p.nazwa_platformy, g.tytul, g.ilosc_na_stanie, g.cena, g.premiera, g.liczba_graczy, g.zdjecie, g.tryb_multiplayer, g.wersja_jezykowa, g.przedzial_wiekowy, g.wydawca
        FROM Gry g
        JOIN Kategorie k ON g.id_kategorii = k.id_kategorii
        JOIN Platformy p ON g.id_platformy = p.id_platformy
        WHERE g.id_gry = $id";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();

    echo "<div class='main'>";
    echo "<h1 class='game-title'>{$row['tytul']}</h1>";
    echo "<hr>";
    echo "<h4 class='opis'>{$row['opis']}</h4>";
    echo "<hr>";
    echo "<img src='{$row['zdjecie']}' alt='Obrazek gry' class='obrazek'>";
    echo "<hr>";

    echo "<h2 class='game-title'>Szczegóły:</h2>";
    echo "<div class='info-box'>";
    echo "<h4>Kategoria: <span class='category'>{$row['nazwa_kategorii']}</span></h4>";
    echo "<h4>Platforma: <span class='category'>{$row['nazwa_platformy']}</span></h4>";
    echo "<h4>Cena: <span class='category'>{$row['cena']}</span></h4>";
    echo "<h4>Liczba graczy: <span class='category'>{$row['liczba_graczy']}</span></h4>";
    echo "<h4>Multiplayer: <span class='category'>{$row['tryb_multiplayer']}</span></h4>";
    echo "<h4>Język: <span class='category'>{$row['wersja_jezykowa']}</span></h4>";
    echo "<h4>Wiek: <span class='category'>{$row['przedzial_wiekowy']}</span></h4>";
    echo "<h4>Wydawca: <span class='category'>{$row['wydawca']}</span></h4>";
    echo "<h4>Premiera: <span class='category'>{$row['premiera']}</span></h4>";

    if (isset($_SESSION['rola']) && in_array($_SESSION['rola'], ['user'])) {
        echo "<div class='buy-game-box'>";
        echo "<form action='buying.php' method='post'>";
        echo "<label for='quantity'>Ilość:</label>";
        echo "<input type='number' id='quantity' name='quantity' min='1' value='1'>";
        echo "<input type='hidden' name='id' value='" . $id . "'>";
        echo "<input type='hidden' name='ilosc_na_stanie' value='" . $row['ilosc_na_stanie'] . "'>";
        echo "<input type='hidden' name='cena' value='" . $row['cena'] . "'>";
        echo "<button type='submit'>Dodaj do koszyka</button>";
        echo "</form>";
        echo "<div id='buy-message'></div>";
        echo "</div>";
        
    }

    if (isset($_SESSION['rola']) && in_array($_SESSION['rola'], ['sprzedawca', 'kierownik', 'prezes'])) {
        echo "<div class='action-buttons'>";
        echo "<h4>Ilość na stanie: <span class='category'>{$row['ilosc_na_stanie']}</span></h4>";
        echo "<a href='editgame.php?id={$row['id_gry']}'>Edytuj grę</a>";
        echo "</div>";
    }

    echo "</div>";
} else {
    echo "Nieznaleziono gry.";
}


$conn->close();
?>

</html>
<script>
   
