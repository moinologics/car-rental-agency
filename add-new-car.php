<?php 

    require('db.php');

    session_start();

    if(!isset($_SESSION['user']) || $_SESSION['user']['type'] != 'AGENCY') { ?>
        <script>
            alert('only rental agency can access this page');
            window.location.href = 'login.html';
        </script>  <?php 
        exit;
    }

    $edit_car_id = isset($_GET['edit_car_id']) ? $_GET['edit_car_id'] : 0;

    $edit_car = null;
    $agency_user_id = $_SESSION['user']['id'];

    if($edit_car_id != 0) {
        $edit_car = $db->query("SELECT * from cars WHERE id = $edit_car_id")->fetch(PDO::FETCH_ASSOC);
    }

    $cars = $db->query("SELECT * from cars WHERE agency_user_id = $agency_user_id")->fetchAll(PDO::FETCH_ASSOC);

    // print_r($cars);

?>


<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Add New Car</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.3/font/bootstrap-icons.css">
    </head>

    <body>
        <div class="container-fluid">
            <div class="mt-5">
                <div class="rounded d-flex justify-content-center">
                    <div class="col-md-4 col-sm-12 shadow-lg px-4 py-5 bg-light">
                        <div class="text-center">
                            <h4 class="text-primary"> <?= $edit_car_id ? 'Edit' : 'Add New'?> Car For Rent</h4>
                        </div>
                        <div class="p-4">
                            <form id="add-car-form">
                                <input type="hidden" name="car_id" value="<?= $edit_car ? $edit_car['id'] : 0 ?>">
                                <div class="input-group mb-3">
                                    <span class="input-group-text bg-primary"><i class="bi bi-123 text-white"></i></span>
                                    <input type="text" name="vehicle_model" class="form-control" placeholder="Vehicle model" value="<?= $edit_car ? $edit_car['model'] : '' ?>">
                                </div>
                                <div class="input-group mb-3">
                                    <span class="input-group-text bg-primary"><i class="bi bi-123 text-white"></i></span>
                                    <input type="text" name="vehicle_number" class="form-control" placeholder="Vehicle number" value="<?= $edit_car ? $edit_car['number'] : '' ?>">
                                </div>
                                <div class="input-group mb-3">
                                    <span class="input-group-text bg-primary"><i class="bi bi-123 text-white"></i></span>
                                    <input type="number" name="seating_capacity" class="form-control" placeholder="Seating Capacity" value="<?= $edit_car ? $edit_car['seating_capacity'] : '' ?>">
                                </div>
                                <div class="input-group mb-3">
                                    <span class="input-group-text bg-primary"><i class="bi bi-123 text-white"></i></span>
                                    <input type="number" name="rent_per_day" class="form-control" placeholder="Rent (INR/Day)" value="<?= $edit_car ? $edit_car['rent_per_day'] : '' ?>">
                                </div>
                                <div class="d-grid col-12 mx-auto">
                                    <button class="btn btn-primary" type="button" onclick="add_car()">submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container mt-5">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Vehicle Model</th>
                            <th>Vehicle Number</th>
                            <th>Seating Capacity</th>
                            <th>Rent (INR/day)</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($cars as $car): ?> 
                        <tr>
                            <td><?= $car['model'] ?></td>
                            <td><?= $car['number'] ?></td>
                            <td><?= $car['seating_capacity'] ?></td>
                            <td><?= $car['rent_per_day'] ?></td>
                            <td><a href="add-new-car.php?edit_car_id=<?= $car['id'] ?>" class="btn btn-primary">edit</a></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </body>
</html>

<script>

    async function add_car() {

        const form = document.getElementById('add-car-form');

        const r = await fetch('ajax.php?op=ADD_NEW_CAR', {method:'post', body: new FormData(form)}).then(res => res.json());

        alert(r.msg);

        if(r.success) {
            window.location.href = 'add-new-car.php';
        }
    }

    

</script>