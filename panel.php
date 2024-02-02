<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
        }

        h2 {
            margin-top: 20px;
        }

        form {
            margin-top: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        label {
            margin-bottom: 5px;
        }

        input {
            padding: 8px;
            margin-bottom: 10px;
            box-sizing: border-box;
        }

        button {
            background-color: #4caf50;
            color: #fff;
            padding: 10px;
            margin-top: 10px;
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
    require("db.php");

    $role = $_SESSION['rola'];

    function releaseEmployee($conn) {
        $vendorId = $_POST['vendorId'];

     
        $releaseQuery = "INSERT INTO Historia_Pracownikow (id_pracownika, data_zatrudnienia, data_zwolnienia) SELECT id_pracownika, data_zatrudnienia, NOW() FROM Pracownicy WHERE id_pracownika = $vendorId";
        $result = $conn->query($releaseQuery);

        $releaseQuery = "UPDATE Pracownicy
        SET data_zwolnienia = NOW()
        WHERE id_pracownika = $vendorId";
        $result = $conn->query($releaseQuery);
        echo "Edycja udana.";
    }

    function showSalespersons($conn) {
       
        $showQuery = "SELECT * FROM Pracownicy WHERE data_zwolnienia IS NULL AND id_stanowiska = (SELECT id_stanowiska FROM Stanowiska WHERE nazwa_stanowiska = 'sprzedawca') ";
        $result = $conn->query($showQuery);

        if ($result->num_rows > 0) {
           
            while ($row = $result->fetch_assoc()) {
                echo "ID: " . $row['id_pracownika'] . " | Imie i nazwisko: " . $row['imie'] . " " . $row['nazwisko'] . "<br>";
            }
        } else {
            echo "Nie znaleziono sprzedawców.";
        }
    }


    function showManagers($conn) {
        
        $showQuery = "SELECT * FROM Pracownicy WHERE data_zwolnienia IS NULL AND id_stanowiska = (SELECT id_stanowiska FROM Stanowiska WHERE nazwa_stanowiska = 'kierownik') ";
        $result = $conn->query($showQuery);

        if ($result->num_rows > 0) {
           
            while ($row = $result->fetch_assoc()) {
                echo "ID: " . $row['id_pracownika'] . " | Imie i nazwisko: " . $row['imie'] . " " . $row['nazwisko'] . "<br>";
            }
        } else {
            echo "Nie znaleziono pracowników.";
        }
    }

    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        switch ($_POST['action']) {
            case 'releaseEmployee':
                releaseEmployee($conn);
                break;
            case 'showSalespersons':
                showSalespersons($conn);
                break;
            case 'showManagers':
                showManagers($conn);
                break;
            default:
                echo "Invalid action.";
                break;
        }
    }

   
    if ($role === 'kierownik') {
        echo "<h2>Panel kierownika</h2>";
        ?>
        <form method="post" action="editperson.php">
            <input type="hidden" name="action" value="editSalesperson">
            <label for="vendorId">Wprowadź ID sprzedawcy:</label>
            <input type="text" name="vendorId" required>
            <button type="submit">Edytuj sprzedawce</button>
        </form>

        <form method="post" action="panel.php">
            <input type="hidden" name="action" value="releaseEmployee">
            <label for="vendorId">Wprowadź ID sprzedawcy:</label>
            <input type="text" name="vendorId" required>
            <button type="submit">Zwolnij sprzedawce</button>
        </form>

        <form method="post" action="panel.php">
            <input type="hidden" name="action" value="showSalespersons">
            <button type="submit">Pokaż sprzedawców</button>
        </form>
        <form action="addperson.php">
            <input type="hidden" name="action" value="showSalespersons">
            <button type="submit">Dodaj pracownika</button>
        </form>
        <?php
    } elseif ($role === 'prezes') {
        echo "<h2> Panel prezesa</h2>";
        ?>
        <form action="editperson.php">
            <input type="hidden" name="action" value="editManager">
            <button type="submit">Edytuj kierownika</button>
        </form>

        <form method="post" action="panel.php">
            <input type="hidden" name="action" value="releaseEmployee">
            <label for="vendorId">Wprowadź ID kierownika:</label>
            <input type="text" name="vendorId" required>
            <button type="submit">Zwolnij kierownika</button>
        </form>

        <form method="post" action="panel.php">
            <input type="hidden" name="action" value="showManagers">
            <button type="submit">Pokaż kierowników</button>
        </form>
        <form action="editperson.php">
            <input type="hidden" name="action" value="editSalesperson">
            <button type="submit">Edytuj sprzedawce</button>
        </form>

        <form method="post" action="panel.php">
            <input type="hidden" name="action" value="releaseEmployee">
            <label for="vendorId">Wprowadź ID sprzedawcy:</label>
            <input type="text" name="vendorId" required>
            <button type="submit">Zwolnij sprzedawce</button>
        </form>

        <form method="post" action="panel.php">
            <input type="hidden" name="action" value="showSalespersons">
            <button type="submit">Pokaż sprzedawców</button>
        </form>
         <form action="addperson.php">
            <input type="hidden" name="action" value="showSalespersons">
            <button type="submit">Dodaj pracownika</button>
        </form>
        <?php
    } else {
        echo "Nie dozwolony dostęp.";
        exit();
    }
    ?>

    
</body>
</html>
