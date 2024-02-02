<?php 
require("db.php");
require("session.php");
?>
<style>
    header {
        background-color: #333;
        padding: 10px;
        color: #fff;
        text-align: center;
    }

    p {
        margin: 0;
    }

    a {
        color: #fff;
        text-decoration: none;
        margin: 0 10px;
        font-weight: bold;
    }

    a:hover {
        text-decoration: underline;
    }
</style>

<header>
    <p>
        <a href="index.php">Strona główna</a>
        <a href="games.php">Sklep</a>
        <?php 
        if(isset($_SESSION["rola"]) && $_SESSION["rola"] === "sprzedawca") {
            echo " <a href='logout.php'>Wyloguj się</a>";
             echo " <a href='insertForm.php'>Dodaj grę</a>";
             echo " <a href='orders.php'> Zamówienia</a>";
        }elseif(isset($_SESSION["rola"]) && $_SESSION["rola"] === "kierownik") {
            echo " <a href='logout.php'>Wyloguj się</a>";
             echo " <a href='raports.php'>Raporty</a>";
            echo " <a href='insertForm.php'>Dodaj grę</a>";
              echo " <a href='orders.php'> Zamówienia</a>";
              echo " <a href='panel.php'> Panel</a>";
       
        } elseif(isset($_SESSION["rola"]) && $_SESSION["rola"] === "prezes") {
            echo " <a href='logout.php'>Wyloguj się</a>";
             echo " <a href='raports.php'>Raporty</a>";
             echo " <a href='insertForm.php'>Dodaj grę</a>";
             echo " <a href='orders.php'> Zamówienia</a>";
              echo " <a href='panel.php'> Panel</a>";
       
        }elseif(isset($_SESSION["rola"]) && $_SESSION["rola"] === "user") {
             echo "<a href = 'clientPanel.php'> Panel Klienta</a>";
            echo " <a href = 'history.php'>Historia zakupów</a>";
            echo " <a href='logout.php'>Wyloguj się</a>";
            echo " <a href='backgame.php'>Zwróć Grę</a>";
            echo " <a href='basket.php'>Koszyk</a>";
        } else {
            echo " <a href='login.php'>Zaloguj się</a> ";
            echo " <a href='registration.php'>Zarejestruj się</a> ";
        }
        ?>
    </p>
</header>
