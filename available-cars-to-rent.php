<?php

    require_once('db.php');

    session_start();

    $cars = $db->query('SELECT * FROM cars')->fetchAll(PDO::FETCH_ASSOC);

    // print_r($cars);

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
        <h6 class="text-end">
            <a href="<?= isset($_SESSION['user']) ? 'ajax.php?op=LOGOUT' : 'login.html' ?>"> <?= isset($_SESSION['user']) ? 'logout' : 'login' ?> </a> 
        </h6>
        <h1 class="text-center"> cars availble for rent </h1>
        <div class="row">
        <?php foreach($cars as $car): ?>
            <div class="col-xl-3 col-lg-4 col-md-4 col-6 my-2">
                <div class="card">
                    <div class="card-body">
                        <p class="card-text"> Vehicle Model: <?= $car['model'] ?> </p>
                        <p class="card-text"> Vehicle Number: <?= $car['number'] ?> </p>
                        <p class="card-text"> Seating Capacity: <?= $car['seating_capacity'] ?> </p>
                        <p class="card-text"> Rent (INR/day): <?= $car['rent_per_day'] ?> </p>
                        <?php if(isset($_SESSION['user'])): ?>
                        <form id="car_form_<?= $car['id'] ?>">
                            <input type="hidden" name="car_id" value="<?= $car['id'] ?>">
                            <p>Start Date: <input type="date" name="start_date" onfocus="this.min=new Date().toISOString().split('T')[0]"></p>
                            <p>
                                Number Of Days: <select name="num_of_days">
                                    <option value="">select</option>
                                    <?php for($i=1; $i<=10; $i++): ?>
                                    <option value="<?= $i ?>"><?= $i ?></option>
                                    <?php endfor; ?>
                                </select>
                            </p>
                        </form>
                        <? endif; ?>
                        <a href="#" class="btn btn-primary text-center" onclick="rent_car(<?= $car['id'] ?>)">Rent Car</a>
                    </div>
                </div>
            </div>
        <? endforeach; ?>
        </div>
    </div>
</body>
</html>

<script>

    async function rent_car(car_id) {
        const form = document.getElementById('car_form_' + car_id);
        if(!form) {
            window.location.href = 'login.html';
            return;
        }
        const fd =  new FormData(form);
        if(fd.get('start_date') == '' || fd.get('num_of_days') == '') {
            return alert('select start date & number of days');
        }
        const r = await fetch('ajax.php?op=RENT_CAR', {method:'post', body: fd}).then(res => res.json());
        alert(r.msg);
    }

    

</script>
