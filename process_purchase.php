<?php
require("database_operations.php");
require("db.php");

$id_klienta = $_SESSION['id_klienta'];

$query = "SELECT k.id_gry, k.ilosc, g.ilosc_na_stanie, g.cena, k.cena_cala
          FROM Koszyk k
          JOIN Gry g ON k.id_gry = g.id_gry
          WHERE k.id_klienta = $id_klienta";

$result = $conn->query($query);

while ($row = $result->fetch_assoc()) {
    $gameId = $row['id_gry'];
    $quantityToBuy = $row['ilosc']; 
    $quantityAvailable = $row['ilosc_na_stanie'];
    $cost = $row['cena'];
    $new_cost = $quantityToBuy * $cost;
    $totalPrice = $row['cena_cala'];
    if ($quantityToBuy <= $quantityAvailable) {
        if($totalPrice != $new_cost){
            $totalPrice=$new_cost;
        }
        addOrder($gameId, $quantityToBuy, $totalPrice);
        addPurchaseHistory($gameId, $quantityToBuy, $totalPrice);
        updateGameQuantity($gameId, $quantityAvailable - $quantityToBuy, 'sprzedane');
    } else {
        $conn->close();
        header("location: index.php");
        exit(); 
    }
}

$clearCartQuery = "DELETE FROM Koszyk WHERE id_klienta = $id_klienta";
$conn->query($clearCartQuery);


header("location: index.php");
$conn->close();
?>
