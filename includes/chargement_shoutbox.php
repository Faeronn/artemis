<?php
        include ('configuration.php');
        include ('fonctions/date.php');
        $message = $bdd->query('SELECT * FROM taiga ORDER BY id DESC LIMIT 10');
        foreach ($message as $message) {
            ?>