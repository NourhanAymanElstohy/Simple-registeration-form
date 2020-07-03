<?php
require_once "pdo.php";
session_start();

if (isset($_POST['cancel'])) {
    header("Location: index.php");
}

if (isset($_POST['register'])) {
    if (isset($_POST['name']) && isset($_POST['email']) && isset($_POST['phone']) && isset($_POST['address']) && isset($_POST['password'])) {
        unset($_SESSION["register"]);

        $errors = array();

        if (strlen($_POST['name']) < 1) {
            $errors['name'][] = "Name is required";
        } elseif (preg_match("/^[a-zA-Z]+$/", $_POST['name']) == false) {
            $errors['name'][] = "Name must be Characters only";
        } else {
            $_SESSION['name'] = $_POST['name'];
            $name = $_POST['name'];
        }
        //======= email =================
        if (strlen($_POST['email']) < 1) {
            $errors['email'][] = "Email is required";
        } elseif (preg_match("/^[a-zA-z0-9]+@[a-z]+.[a-z]{2,4}$/", $_POST['email']) == false) {
            $errors['email'][] = "Email is not valid";
        }

        $sql = "select * from users where email=:email";

        $stmt = $db->prepare($sql);
        $stmt->execute(['email' => $_POST['email']]);

        if ($user = $stmt->fetch()) {
            $errors['email'][] = "This Email is already Exist";
        } else {
            $email = $_POST['email'];
            $_SESSION['email'] = $_POST['email'];
        }
        //=============== phone =========
        if (strlen($_POST['phone']) < 1) {
            $errors['phone'][] = "Phone is required";
        } elseif (preg_match("/^01[0-9]{9}$/", $_POST['phone']) == false) {
            $errors['phone'][] = "Phone must be 11 numbers starts with 01";
        } else {
            $_SESSION['phone'] = $_POST['phone'];
            $phone = $_POST['phone'];
        }
        //=========== address ===========
        if (strlen($_POST['address']) < 1) {
            $errors['address'][] = "Address is required";
        } else {
            $_SESSION['address'] = $_POST['address'];
            $address = $_POST['address'];
        }
        //=========== password ==========
        if (strlen($_POST['password']) < 1) {
            $errors['password'][] = "Password is required";
        } elseif (preg_match("/^[a-zA-Z0-9@#$]{8,10}$/", $_POST['password']) == false) {
            $errors['password'][] = "Password must be between 8 and 10 characters";
        } else {
            $password = $_POST['password'];
            $_SESSION['password']  = $_POST['password'];
            $salt = 'XyZzy12*_';
            $hashed_password = hash('md5', $salt . $password);
        }
        //======= Register ==============
        if ($name && $email && $phone && $address && $password) {
            $sql = "insert into users (name, email, phone, address,password) values (:name, :email, :phone, :address, :password)";

            $stmt = $db->prepare($sql);
            $stmt->execute(array(
                ':name' => $name,
                ':email' => $email,
                ':phone' => $phone,
                ':address' => $address,
                ':password' => $hashed_password,
            ));
            $_SESSION['success'] = "Thank you for your registeration";
            header("Location: login.php");
            return;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register New User</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
</head>

<body>
    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-6">
                <form method="POST">
                    <div class="form-row">
                        <div class="col-md-12 mb-3">
                            <h1>Register New User</h1>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-6 mb-3">
                            <label for="validationCustom01">Name</label>
                            <input type="text" class="form-control" id="validationCustom01" value="<?= $_POST['name'] ?>" name="name">
                            <p class="text-danger">
                                <?php if (isset($errors['name'])) {
                                    foreach ($errors['name'] as $val) {
                                        echo "$val" . "<br>";
                                    }
                                } else {
                                } ?>
                            </p>

                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="validationCustom02">Email</label>
                            <input type="text" class="form-control" id="validationCustom02" value="<?= $_POST['email'] ?>" name="email">
                            <p class="text-danger">
                                <?php if (isset($errors['email'])) {
                                    foreach ($errors['email'] as $val) {
                                        echo "$val" . "<br>";
                                    }
                                } ?>
                            </p>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-6 mb-3">
                            <label for="validationCustom05">Phone</label>
                            <input type="text" class="form-control" id="validationCustom05" value="<?= $_POST['phone'] ?>" name="phone">
                            <p class="text-danger">
                                <?php if (isset($errors['phone'])) {
                                    foreach ($errors['phone'] as $val) {
                                        echo "$val" . "<br>";
                                    }
                                } ?>
                            </p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="validationCustom03">Address</label>
                            <input type="text" class="form-control" id="validationCustom03" value="<?= $_POST['address'] ?>" name="address">
                            <p class="text-danger">
                                <?php if (isset($errors['address'])) {
                                    foreach ($errors['address'] as $val) {
                                        echo "$val" . "<br>";
                                    }
                                } ?>
                            </p>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-12 mb-3">
                            <label for="validationCustom05">Password</label>
                            <input type="password" class="form-control" id="validationCustom05" value="<?= $_POST['password'] ?>" name="password">
                            <p class="text-danger">
                                <?php if (isset($errors['password'])) {
                                    foreach ($errors['password'] as $val) {
                                        echo "$val" . "<br>";
                                    }
                                } ?>
                            </p>
                        </div>
                    </div>
                    <button class="btn btn-primary" type="submit" name="register">Register</button>
                    <button class="btn btn-secondary" name="cancel">Cancel</button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
</body>

</html>