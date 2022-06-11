<?php

    if(!isset($_REQUEST['op']))
        die('no op');
    else
        $op = $_REQUEST['op'];

    require_once('db.php');

    session_start();

    header('Content-Type: application/json');
    http_response_code(200);

    $response = ['success' => true, 'msg' => 'ok'];

    if($op == 'CUSTOMER_REGISTRATION' || $op == 'AGENCY_REGISTRATION')
    {
        $email = $_POST['email'];
        $password_enc = md5($_POST['password']);

        $user_type = ($op == 'CUSTOMER_REGISTRATION') ? 'CUSTOMER' : 'AGENCY';

        $stmt = $db->prepare("SELECT * FROM users WHERE email = ? AND type = ?");
        $stmt->execute([$email, $user_type]);      
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if($row) {
            $response = ['success' => false, 'msg' => "email already existed for $user_type account"];
            http_response_code(400);
        }
        else {
            $q = "INSERT INTO users (email, password, type) VALUES (?,?,?)";
            $db->prepare($q)->execute([$email, $password_enc, $user_type]);
            $response['msg'] = 'registration successfull.';
        }

        echo json_encode($response);
    }

    if($op == 'LOGIN') {

        $email = $_POST['email'];
        $password_enc = md5($_POST['password']);

        $stmt = $db->prepare("SELECT id,email,type FROM users WHERE email = ? AND password = ?");
        $stmt->execute([$email, $password_enc]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if($row) {
            $response['msg'] = "logged in successfully";
            $_SESSION['user'] = $row;
        }
        else {
            $response = ['success' => false, 'msg' => 'incorrect email and/or password'];
            http_response_code(400);
        }

        echo json_encode($response);
    }

    if($op == 'LOGOUT') {
        session_destroy();
        $response['msg'] = "logged out successfully";
        header('Location: available-cars-to-rent.php');
        echo json_encode($response);
    }

    if($op == 'ADD_NEW_CAR') {
        $vehicle_model = $_POST['vehicle_model'];
        $vehicle_number = $_POST['vehicle_number'];
        $seating_capacity = $_POST['seating_capacity'];
        $rent_per_day = $_POST['rent_per_day'];

        $stmt = $db->prepare("SELECT COUNT(*) FROM cars WHERE number = ?");
        $stmt->execute([$vehicle_number]);  
        $row = $stmt->fetch();

        if(count($row) > 0) {
            $response = ['success' => false, 'msg' => 'vehicle number already existed'];
            http_response_code(400);
        }
        else {
            $q = "INSERT INTO cars (model, number, seating_capacity, rent_per_day) VALUES (?,?,?,?)";
            $db->prepare($q)->execute([$vehicle_model, $vehicle_number, $seating_capacity, $rent_per_day]);
            $response['msg'] = 'car added successfully';
        }

        echo json_encode($response);
    }

    if($op == 'RENT_CAR') {

        $car_id = $_POST['car_id'];
        $start_date = $_POST['start_date'];
        $num_of_days = $_POST['num_of_days'];

        if($_SESSION['user']['type'] == 'AGENCY') {
            $response = ['success' => false, 'msg' => 'Agency user can\'t rent car'];
            http_response_code(400);
        }
        else {
            $user_id = $_SESSION['user']['id'];

            $q = "INSERT INTO bookings (user_id, car_id, start_date, num_of_days) VALUES (?,?,?,?)";
            $db->prepare($q)->execute([$user_id, $car_id, $start_date, $num_of_days]);
            $response['msg'] = 'car rented successfully';
        }
        
        echo json_encode($response);
    }

?>