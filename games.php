<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sklep</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-wrap: wrap;
        }

        .container {
            display: flex;
            width: 80%;
            margin: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            overflow: hidden;
        }

        .filters {
            width: 30%;
            padding: 20px;
            background-color: #f0f0f0;
        }

        .filter-section {
            margin-bottom: 15px;
        }

        .filter-section label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        .filter-section select,
        .filter-section input {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
            margin-bottom: 10px;
        }

        .filter-section input[type="submit"] {
            background-color: #4caf50;
            color: #fff;
            cursor: pointer;
        }

        .results {
            width: 70%;
            padding: 20px;
            overflow-y: auto;
            max-height: 80vh;
        }

        .game {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            margin-bottom: 20px;
        }

        .game a {
            display: block;
            text-decoration: none;
            color: #333;
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 8px;
            overflow: hidden;
            transition: transform 0.3s;
        }

        .game img {
            width: 20%;
            height: auto;
            border-bottom: 1px solid #ddd;
            margin-bottom: 10px; /* Add margin to separate image and title */
        }

        .game a:hover {
            transform: scale(1.02);
        }

    </style>
 
</head>
<body>
        <?php
 require("menu.php");
 require("db.php");
?>

<div class="container">
    <div class="filters">
        <form action="games.php" method="get">
            <div class="filter-section">
                <label for="category">Kategoria:</label>
                <select name="category" id="category">
                    <?php
                    $categories = $conn->query("SELECT * FROM Kategorie");
                    while ($row = $categories->fetch_object()) {
                        $selected = (isset($_GET['category']) && $_GET['category'] == $row->id_kategorii) ? 'selected' : '';
                        echo "<option value='{$row->id_kategorii}' $selected>{$row->nazwa_kategorii}</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="filter-section">
                <label for="platform">Platforma:</label>
                <select name="platform" id="platform">
                    <?php
                    $categories = $conn->query("SELECT * FROM Platformy");
                    while ($row = $categories->fetch_object()) {
                        $selected = (isset($_GET['platform']) && $_GET['platform'] == $row->id_platformy) ? 'selected' : '';
                        echo "<option value='{$row->id_platformy}' $selected>{$row->nazwa_platformy}</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="filter-section">
                <label for="title">Tytul:</label>
                <input type="text" name="title" id="title" value="<?php echo isset($_GET['title']) ? $_GET['title'] : ''; ?>">
            </div>

            <div class="filter-section">
    <label for="price">Cena:</label>
    <input type="number" name="price_min" placeholder="Min" value="<?php echo isset($_GET['price_min']) ? $_GET['price_min'] : ''; ?>">
    <input type="number" name="price_max" placeholder="Max" value="<?php echo isset($_GET['price_max']) ? $_GET['price_max'] : ''; ?>">
</div>

<div class="filter-section">
    <label for="players">Liczba graczy:</label>
    <input type="number" name="players_min" placeholder="Min" value="<?php echo isset($_GET['players_min']) ? $_GET['players_min'] : ''; ?>">
    <input type="number" name="players_max" placeholder="Max" value="<?php echo isset($_GET['players_max']) ? $_GET['players_max'] : ''; ?>">
</div>

<div class="filter-section">
    <label for="multiplayer">Multiplayer:</label>
    <select name="multiplayer" id="multiplayer">
        <option value="Tak" <?php echo isset($_GET['multiplayer']) && $_GET['multiplayer'] == 'Tak' ? 'selected' : ''; ?>>Tak</option>
        <option value="Nie" <?php echo isset($_GET['multiplayer']) && $_GET['multiplayer'] == 'Nie' ? 'selected' : ''; ?>>Nie</option>
    </select>
</div>

<div class="filter-section">
    <label for="age">Wiek:</label>
    <select name="age" id="age">
        <?php
        $ages = $conn->query("SELECT DISTINCT przedzial_wiekowy FROM Gry");
        while ($row = $ages->fetch_object()) {
            $selected = (isset($_GET['age']) && $_GET['age'] == $row->przedzial_wiekowy) ? 'selected' : '';
            echo "<option value='{$row->przedzial_wiekowy}' $selected>{$row->przedzial_wiekowy}</option>";
        }
        ?>
    </select>
</div>
            
            <div class="filter-section">
                <input type="submit" value="Filtruj">
            </div>
        </form>
    </div>
<div class="results">
<?php
if (isset($_SESSION['rola']) && in_array($_SESSION['rola'], ['user'])) {
$sql = "SELECT * FROM Gry WHERE status<>'usunieta' ";
}
if (isset($_SESSION['rola']) && in_array($_SESSION['rola'], ['sprzedawca', 'kierownik', 'prezes'])) {
    $sql = "SELECT * FROM Gry WHERE 1=1 ";
    }
if (isset($_GET['title']) && $_GET['title'] !== '') {
    $title = $_GET['title'];
    $sql .= " AND tytul = '$title'";
}

if (isset($_GET['category']) && $_GET['category'] !== '') {
    $category = $_GET['category'];
    $sql .= " AND id_kategorii = $category";
}

if (isset($_GET['platform']) && $_GET['platform'] !== '') {
    $platform = $_GET['platform'];
    $sql .= " AND id_platformy = $platform";
}

if (isset($_GET['price_min']) && isset($_GET['price_max'])) {
    $price_min = $_GET['price_min'];
    $price_max = $_GET['price_max'];
    if ($price_min !== '' && $price_max !== '') {
        $sql .= " AND cena BETWEEN $price_min AND $price_max";
    }
}

if (isset($_GET['players_min']) && isset($_GET['players_max'])) {
    $players_min = $_GET['players_min'];
    $players_max = $_GET['players_max'];
    if ($players_min !== '' && $players_max !== '') {
        $sql .= " AND liczba_graczy BETWEEN $players_min AND $players_max";
    }
}

if (isset($_GET['multiplayer']) && $_GET['multiplayer'] !== '') {
    $multiplayer = $_GET['multiplayer'];
    $sql .= " AND tryb_multiplayer = '$multiplayer'";
}

if (isset($_GET['age']) && $_GET['age'] !== '') {
    $age = $_GET['age'];
    $sql .= " AND przedzial_wiekowy = $age";
}


$result = $conn->query($sql);


while ($row = $result->fetch_object()) {
    echo "<div class='game'>";
    echo "<a class='mainItem' href='details.php?id_gry={$row->id_gry}'>
            <img class='itemimg' src='{$row->zdjecie}' alt='{$row->tytul}'></img>
            <div class='itemTitle'>{$row->tytul}</div>
          </a>";
    echo "</div>";
}

$conn->close();
?>

</div>



    
</body>
</html>
