<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dodaj grę</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .centered-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 400px;
            text-align: center;
        }

        .larger-input {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        select {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button {
            width: 100%;
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
<?php
 require("menu.php");
?>

    <?php 
    echo"
    <div class='centered-container'>
        <form action='insert.php' method='post'  enctype='multipart/form-data'>
        <p><input type='text' class='larger-input' name='tytul' placeholder='tytul' id='' value=''></p>
        <p><input type='number' name='cena' placeholder='cena' id='' value=''></p>
        <p><input type='number' class='larger-input' name='liczba_graczy' placeholder='liczba_graczy' id='' value=''></p>
        <p><input type='file' name='zdjecie'></p>
        <p><input type='number' class='larger-input' name='ilosc_na_stanie' placeholder='ilosc_na_stanie' id='' value=''></p>
        <p><input type='text' class='larger-input' name='opis' placeholder='opis' id='' value=''></p>
        <p><input type='text' class='larger-input' name='tryb_multiplayer' placeholder='tryb_multiplayer' id='' value=''></p>
        <p><input type='text' class='larger-input' name='wydawca' placeholder='wydawca' id='' value=''></p>
        <p><input type='text' class='larger-input' name='gatunek' placeholder='gatunek' id='' value=''></p>
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

    <p><button type='submit'>Dodaj Grę</button>
        </form>
        </div>
        ";
    ?>

    
</body>
</html>