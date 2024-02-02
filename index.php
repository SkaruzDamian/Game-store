<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sklep z Grami</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        .content {
            display: flex;
            justify-content: space-between;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        

        .underHeader {
            text-decoration: none;
            color: #333;
            margin-right: 20px;
            font-size: 16px;
        }

        .content1 {
    display: flex;
    align-items: center;
    text-align: center; /* Center the content horizontally */
}

.content2 {
    display: flex;
    align-items: center;
    margin-left: 20px;
}

form {
    display: flex;
    align-items: center;
    margin: 0 auto; /* Center the form horizontally */
}

        input[type="text"] {
            padding: 10px;
            margin-right: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        input[type="submit"] {
            background-color: #4caf50;
            color: #fff;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        .mainContainer {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            margin: 20px 0;
        }

        .line {
            width: 100%;
            margin-top: 20px;
        }

        .mainItem {
            text-decoration: none;
            color: #333;
            width: 20%;
            padding: 10px;
            margin: 10px;
            background-color: #fff;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s;
        }

        .mainItem:hover {
            transform: scale(1.05);
        }

        .itemimg {
            width: 30%;
            height: auto;
        }
        .itemImage {
            text-align: center;
        }

        .itemimg {
            display: inline-block;
        }

        .itemTitle {
            text-align: center;
        }
    </style>

</head>
<body>
<?php
require("menu.php");
?>


 
        <div class="content2">
            <form>
                <p>
                    <input type="text" name="fraza" aria-label="Szukaj" placeholder="Szukaj gry">
                    <input type="submit" value="Szukaj gry">
                </p>
            </form>
  
 
</div>

<?php

$sql = "SELECT id_gry, tytul, zdjecie FROM Gry ";
 if (isset($_GET["fraza"])) {
    $fraza = $_GET["fraza"];
    $sql .= " WHERE tytul LIKE '%$fraza%'";
}
$sql .= "ORDER BY id_gry DESC LIMIT 4";
$result = $conn->query($sql);



echo "<div class='mainContainer'>";
$count = 0;
$licznik = 0;
while ($row = $result->fetch_object()) {
    if ($count % 3 == 0) {
        if ($count > 0) {
            echo "</div><div class='line'>";
        }
    }

    $gameId = isset($row->id_gry) ? $row->id_gry : 0;
    echo "<a class='mainItem' href='details.php?id_gry={$gameId}'>
                <div class='itemImage'>
                    <img class='itemimg' src='{$row->zdjecie}' alt='{$row->tytul}'></img>
                </div>
                <div class='itemTitle'>{$row->tytul}</div>
              </a>";

    $count++;
    $licznik++;
    if ($count % 3 == 0) {
        $count = 0;
    }
    $licznik++;
    if($licznik==8){
        break;
    }
    
}

echo "</div>";
?>


    
</body>

</html>
