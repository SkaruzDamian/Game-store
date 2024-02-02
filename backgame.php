<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zwróć grę</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f4f4f4;
            color: #333;
        }

        form {
            max-width: 400px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        input {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            box-sizing: border-box;
        }

        button {
            background-color: #007BFF;
            color: #fff;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }

        h2 {
            text-align: center;
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
     require("db.php");    
 require("menu.php");
?>
<?php
if (isset($_SESSION['id_klienta'])) {
    $customerId = $_SESSION['id_klienta'];

    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        handleReturnForLoggedInUser($customerId);
    } else {
       
        showReturnFormForLoggedInUser();
    }
} 

function showReturnFormForLoggedInUser() {
    require("db.php");  
    echo '<form method="post">';
    echo 'Nazwa gry: <input type="text" name="gameName" required><br>';
    echo 'Ilosc: <input type="number" name="quantity" required><br>';
    echo '<button type="submit">Zwróć</button>';
    echo '</form>';
}



function handleReturnForLoggedInUser($customerId) {
    require("db.php");  

    $gameName = $_POST['gameName'];
    $quantity = $_POST['quantity'];

        $canBeReturned = checkReturnValidityForLoggedInUser($customerId, $gameName, $quantity);

        if ($canBeReturned) {
            
            updateReturnForLoggedInUser($customerId, $gameName, $quantity);
            echo "Udany zwrot!";
        } else {
           
            echo "Błąd zwracania gry.";
        }
   
}

function checkReturnValidityForLoggedInUser($customerId, $gameName, $quantity) {
    
    require("db.php");  
    $query = "SELECT COUNT(*) as count FROM Historia_Zakupow WHERE id_klienta = $customerId AND id_gry = (SELECT id_gry FROM Gry WHERE tytul = '$gameName') AND ilosc >= $quantity AND status <> 'Returned'";
    
    $result = $conn->query($query);
    $row = $result->fetch_assoc();

    
    if ($row['count'] > 0) {
        return true;
    } else {
        return false;
    }
}
function updateReturnForLoggedInUser($customerId, $gameName, $quantity) {

    require("db.php");  
    
    $query = "UPDATE Historia_Zakupow h
              JOIN Gry g ON h.id_gry = g.id_gry
              SET h.status = 'zwrócono' 
              WHERE h.id_klienta = $customerId 
              AND g.tytul = '$gameName' 
              AND h.status <> 'zwrócono' 
              AND h.ilosc >= $quantity";

    $conn->query($query);

    $query = "UPDATE Zamowienia z
              JOIN Gry g ON z.id_gry = g.id_gry
              SET z.status = 'Returned' 
              WHERE z.id_klienta = $customerId 
              AND g.tytul = '$gameName' 
              AND z.status <> 'zwrócono' 
              AND z.ilosc >= $quantity";

    $conn->query($query);

    $query = "UPDATE Gry SET ilosc_na_stanie = ilosc_na_stanie + $quantity WHERE tytul = '$gameName'";
    $conn->query($query);
}


?>

</body>
</html>