            <!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta http-equiv="X-UA-Compatible" content="IE=edge">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Edytuj grę</title>
                <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            display: flex;
            flex-direction: column; 
            align-items: center;
        }

        /* Add styles for the menu */
        header {
            background-color: #333;
            color: #fff;
            padding: 10px;
            text-align: center;
            width: 100%;
        }

        form {
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            padding: 20px;
            width: 60%; 
            margin-top: 20px; 
            text-align: center;
        }

        label {
            display: block;
            margin: 10px 0;
            font-weight: bold;
        }

        input,
        textarea {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
            margin-bottom: 15px;
        }

        button {
            background-color: #4caf50;
            color: #fff;
            padding: 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: #45a049;
        }
    </style>
            </head>
            <body>
                <?php require("menu.php");
                
 ?>

<?php 
    echo"
    <div class='centered-container'>
        <form method='post' enctype='multipart/form-data'>
        <p><input type='text' class='larger-input' name='tytul' placeholder='tytul' id='' value=''></p>
        <p><input type='number' name='cena' placeholder='cena' id='' value=''></p>
        <p><input type='number' class='larger-input' name='liczba_graczy' placeholder='liczba_graczy' id='' value=''></p>
        <p><input type='file' name='zdjecie'></p>
        <p><input type='number' class='larger-input' name='ilosc_na_stanie' placeholder='ilosc_na_stanie' id='' value=''></p>
        <p><input type='text' class='larger-input' name='opis' placeholder='opis' id='' value=''></p>
        <p><input type='text' class='larger-input' name='tryb_multiplayer' placeholder='tryb_multiplayer' id='' value=''></p>
        <p><input type='text' class='larger-input' name='wydawca' placeholder='wydawca' id='' value=''></p>
        <p><input type='date' class='larger-input' name='premiera' placeholder='premiera' id='' value=''></p>
        <p><input type='text' class='larger-input' name='wersjajezykowa' placeholder='wersjajezykowa' id='' value=''></p>
        <p><input type='number' class='larger-input' name='przedzial_wiekowy' placeholder='przedzial_wiekowy' id='' value=''></p>
		<p><input type='text' class='larger-input' name='status' placeholder='status' id='' value=''></p>
        <p><select name='id_kategorii' ></p>
        ";
        $conn = new mysqli("localhost", "root", "", "projektzbd");
        $sql = "SELECT id_kategorii,nazwa_kategorii FROM Kategorie";
        $result = $conn->query($sql);
        if($result->num_rows > 0){
            while($row = $result->fetch_object()) {
                echo"<option value='$row->id_kategorii'>{$row->nazwa_kategorii} </option>";

            }}else
            {
                echo"NIE ZNALEZIONO KATEGORII";
            }
        
            echo "</select></p>";
            echo "  <p><select name='id_platformy' ></p> ";
            $conn = new mysqli("localhost", "root", "", "projektzbd");
            $sql = "SELECT id_platformy,nazwa_platformy FROM Platformy";
            $result = $conn->query($sql);
            if($result->num_rows > 0){
                while($row = $result->fetch_object()) {
                    echo"<option value='$row->id_platformy'>{$row->nazwa_platformy} </option>";
    
                }}else
                {
                    echo"NIE ZNALEZIONO PLATFORMY";
                }
        
    echo"     </select></p>

    <p><button type='submit'>Edytuj Grę</button>
        </form>
        </div>
        ";
    ?>


            </body>
            </html>
 

<?php




function updateGameDetails($gameId, $category, $platform, $title, $description, $zdjecie, $price, $numPlayers, $multiplayerMode, $languageVersion, $ageRange, $publisher, $quantityInStock, $status, $premiera) {
   
    require("db.php");
    $updateQuery = "UPDATE Gry g
                    SET g.id_kategorii = $category, g.id_platformy = $platform, g.tytul = '$title', g.opis = '$description', g.zdjecie = 'src/$zdjecie', g.cena = $price, g.premiera= $premiera, g.status = '$status', g.liczba_graczy = $numPlayers, g.tryb_multiplayer = '$multiplayerMode', g.wersja_jezykowa = '$languageVersion', g.przedzial_wiekowy = $ageRange, g.wydawca = '$publisher',  g.ilosc_na_stanie = $quantityInStock
                    WHERE g.id_gry = $gameId";

if ($conn->query($updateQuery) === TRUE) {
    echo "Rekord został pomyślnie zaktualizowany";
} else {
    echo "Błąd podczas aktualizacji rekordu: " . $conn->error;
}
}

if (isset($_SESSION['rola']) && in_array($_SESSION['rola'], ['sprzedawca', 'kierownik', 'prezes'])) {
    if (isset($_GET['id'])) {
        $gameId = $_GET['id'];
       

        
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $category = $_POST['id_kategorii'];
                $platform = $_POST['id_platformy'];
                $title = $_POST['tytul'];
                $description = $_POST['opis'];
                $zdjecie = basename($_FILES["zdjecie"]["name"]);
                move_uploaded_file($_FILES["zdjecie"]["tmp_name"], "src/" . $zdjecie);
                $price = $_POST['cena'];
                $numPlayers = $_POST['liczba_graczy'];
                $multiplayerMode = $_POST['tryb_multiplayer'];
                $languageVersion = $_POST['wersjajezykowa'];
                $ageRange = $_POST['przedzial_wiekowy'];
                $publisher = $_POST['wydawca'];
                $quantityInStock = $_POST['ilosc_na_stanie'];
                $status=$_POST['status'];
                $premiera = $_POST['premiera'];

                updateGameDetails($gameId, $category, $platform, $title, $description, $zdjecie, $price, $numPlayers, $multiplayerMode, $languageVersion, $ageRange, $publisher, $quantityInStock, $status, $premiera);

                header("Location: game_details.php?id={$gameId}");
                exit();
            
        }
    }
}
            ?>