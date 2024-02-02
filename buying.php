<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $quantity = $_POST['quantity'];
    $ilosc_na_stanie = $_POST['ilosc_na_stanie'];
    $cena = $_POST['cena'];

    if ($quantity > $ilosc_na_stanie) {
        echo "Nie mamy tyle gier.";
    } else {
        require("db.php");
        require("menu.php");
        $id_klienta = $_SESSION["id_klienta"];
        $checkQuery = "SELECT id_gry, cena_cala, ilosc FROM Koszyk WHERE id_gry = $id AND id_klienta = $id_klienta";
        $checkResult = $conn->query($checkQuery);

        if ($checkResult->num_rows > 0) {
            $checkRow = $checkResult->fetch_assoc();
            $cena_w_koszyku = $checkRow['cena_cala'];
            $ilosc_w_koszyku = $checkRow['ilosc'];
            $existingQuantity = $quantity + $ilosc_w_koszyku;

            $newCost = ($quantity * $cena) + $cena_w_koszyku;

            $updateQuery = "UPDATE Koszyk SET ilosc_na_stanie = $existingQuantity, cena_cala = $newCost WHERE id_w_koszyku = {$checkRow['id_w_koszyku']}";
            $conn->query($updateQuery);
            echo "Gra dodana do koszyka.";
        } else {
            $cost = $quantity * $cena;
            $addQuery = "INSERT INTO Koszyk (id_gry, id_klienta, cena_cala, ilosc) VALUES ($id, $id_klienta, $cost, $quantity)";
            $conn->query($addQuery);
            echo "Gra dodana do koszyka.";
        }

        $conn->close();
    }
    header("Location: index.php");
}
?>
