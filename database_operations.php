<?php

require("menu.php");
require("db.php");
if ($_SESSION['rola'] === 'user'){
    $id_klienta = $_SESSION['id_klienta'];
}

function addOrder($gameId, $quantity, $wynik) {
    global $conn;
    $id_klienta = $_SESSION['id_klienta'];
    $query = "INSERT INTO Zamowienia (id_klienta, id_gry, ilosc, data_zamowienia, cena, status) VALUES ($id_klienta, $gameId, $quantity, NOW(), $wynik, 'sprzedane')";
    $conn->query($query);
}

function addPurchaseHistory($gameId, $quantity, $wynik) {
    global $conn;
    $id_klienta = $_SESSION['id_klienta'];
    $query = "INSERT INTO Historia_Zakupow(id_klienta, id_gry, ilosc, cena, data_zakupu, status) VALUES ($id_klienta, $gameId, $quantity, $wynik, NOW(), 'sprzedane')";
    $conn->query($query);
}

function updateGameQuantity($gameId, $newQuantity, $status) {
    global $conn;
    $query = "UPDATE Gry SET ilosc_na_stanie = $newQuantity WHERE id_gry = $gameId";
    $conn->query($query);
}



?>
