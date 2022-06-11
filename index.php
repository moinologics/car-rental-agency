<?php

    session_start();

    if(isset($_SESSION['user']) && $_SESSION['user']['type'] == 'AGENCY') {
        header('Location: add-new-car.php');
    }
    else {
        header('Location: available-cars-to-rent.php');
    }

?>