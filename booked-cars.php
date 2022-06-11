<?php

    require_once('db.php');

    session_start();


    if(!isset($_SESSION['user']) || $_SESSION['user']['type'] != 'AGENCY') { ?>
        <script>
            alert('only logged in agency can view this page');
            window.location.href = 'login.html';
        </script> <?php 
        exit;
    }

    $agency_user_id = $_SESSION['user']['id'];

    $q = "SELECT b.start_date, b.num_of_days, c.model, c.number, c.rent_per_day, u.id AS user_id, u.email AS user_email
        FROM bookings AS b
        JOIN cars AS c on c.id = b.car_id
        JOIN users AS u on u.id = b.user_id 
        WHERE c.agency_user_id = $agency_user_id
    ";

    $bookings = $db->query($q)->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Rented Cars</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h6 class="text-end">
            <a href="<?= isset($_SESSION['user']) ? 'ajax.php?op=LOGOUT' : 'login.html' ?>"> <?= isset($_SESSION['user']) ? 'logout' : 'login' ?> </a> 
        </h6>
        <h1 class="text-center"> Your Rented Cars </h1>
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-12">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>User ID</th>
                            <th>User Email</th>
                            <th>Vehicle Model</th>
                            <th>Vehicle Number</th>
                            <th>Start Date</th>
                            <th>Number Of Days</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($bookings as $booking): ?> 
                        <tr>
                            <td><?= $booking['user_id'] ?></td>
                            <td><?= $booking['user_email'] ?></td>
                            <td><?= $booking['model'] ?></td>
                            <td><?= $booking['number'] ?></td>
                            <td><?= $booking['start_date'] ?></td>
                            <td><?= $booking['num_of_days'] ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
