<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edytuj zamówienie</title>
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
            width: 300px;
            text-align: center;
            margin-top: 20px; 
        }

        label {
            display: block;
            margin: 10px 0;
            font-weight: bold;
        }

        input {
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
          require("db.php");

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        
        if (isset($_POST['confirm'])) {
            $id_order = $_POST['id_order'];
            $new_status = $_POST['new_status'];

            $check_query = "SELECT * FROM Zamowienia WHERE id_zamowienia = $id_order";
            $result = $conn->query($check_query);

            if ($result->num_rows > 0) {
                $update_query = "UPDATE Zamowienia SET status = '$new_status' WHERE id_zamowienia = $id_order";
                $conn->query($update_query);

                echo "Status zaktualizowany";
            } else {
               
                echo "Błędne dane.";
            }
        }
    }
    ?>

    <form method="post" action="editorder.php">
        <label for="id_order">ID zamówienia:</label>
        <input type="number" name="id_order" required>

        <label for="new_status">Status na zmiane:</label>
        <input type="text" name="new_status" required>

        <button type="submit" name="confirm">Zatwierdź</button>
    </form>
</body>
</html>
