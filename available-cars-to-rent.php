<?php

    require_once('db.php');

    $cars = $db->query('SELECT * FROM cars', PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cars available to rent</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1 class="text-center"> cars availble for rent </h1>
        <div class="row">
        <?php foreach($cars as $car) ?>
            <div class="col-xl-3 col-lg-3 col-md-4 col-6">
                <div class="card">
                    <div class="card-body">
                        <p class="card-text"> Vehicle Model: <? $car['model'] ?> </p>
                        <p class="card-text"> Vehicle Number: <? $car['number'] ?> </p>
                        <p class="card-text"> Seating Capacity: <? $car['seating_capacity'] ?> </p>
                        <p class="card-text"> Rent (INR/day): <? $car['rent_per_day'] ?> </p>
                        <?php if($_SESSION) ?>
                        <form>
                            <input type="hidden" name="vehicle_id" value="1">
                            <p>Start Date: <input type="date" name="start_date" onfocus="this.min=new Date().toISOString().split('T')[0]"></p>
                            <p>
                                Number Of Days: <select name="num_of_days">
                                    <option value="">select</option>
                                    <option value="1">1</option>
                                </select>
                            </p>
                        </form>
                        <? endif; ?>
                        <a href="#" class="btn btn-primary text-center">Rent Car</a>
                    </div>
                </div>
            </div>
        <? endforeach; ?>
        </div>
    </div>
    
</body>
</html>