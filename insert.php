<?php 
$tytul = $_POST["tytul"];
$cena = $_POST["cena"];
$id_kategorii = $_POST["id_kategorii"];
$liczba_graczy = $_POST["liczba_graczy"];
$ilosc_na_stanie = $_POST["ilosc_na_stanie"];
$opis = $_POST["opis"];
$id_platformy = $_POST["id_platformy"];
$tryb_multiplayer = $_POST["tryb_multiplayer"];
$wydawca = $_POST["wydawca"];
$premiera = $_POST["premiera"];
$wersjajezykowa = $_POST["wersjajezykowa"];
$przedzial_wiekowy = $_POST["przedzial_wiekowy"];
$status = $_POST["status"];
$zdjecie = basename($_FILES["zdjecie"]["name"]);
move_uploaded_file($_FILES["zdjecie"]["tmp_name"], "src/" . $zdjecie);


$conn = new mysqli("localhost", "root", "", "projektzbd");

$sql = "INSERT INTO Gry (tytul, cena, id_kategorii, liczba_graczy, zdjecie, ilosc_na_stanie, opis, id_platformy, tryb_multiplayer, wydawca, premiera, wersja_jezykowa, przedzial_wiekowy, status) VALUES
 ('$tytul', $cena,$id_kategorii, $liczba_graczy, 'src/$zdjecie', $ilosc_na_stanie, '$opis', $id_platformy, '$tryb_multiplayer', '$wydawca','$premiera', '$wersjajezykowa', $przedzial_wiekowy, '$status')";

if ($conn->query($sql)) {
    echo "Dodano gre";
} else {
    echo "Błąd " . $conn->error;
}



header("location: index.php");


?>