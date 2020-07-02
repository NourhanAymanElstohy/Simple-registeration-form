<?php
require_once "pdo.php";
session_start();

if (isset($_POST['cancel'])) {
    header("Location: index.php");
}

if (isset($_POST['login'])) {
    if (isset($_POST['email']) && isset($_POST['password'])) {
        unset($_SESSION['login']);
        $errors = array();

        //============ Email ==============
        if (strlen($_POST['email']) < 1) {
            $errors['email'][] = "Email is required";
        } else {
            $email = $_POST['email'];
        }
        //========== password ===============
        if (strlen($_POST['password']) < 1) {
            $errors['password'][] = "Password is required";
        } else {
            $password = $_POST['password'];
            $salt = 'XyZzy12*_';
            $hashed_password = hash('md5', $salt . $password);
        }
        if ($email && $password) {
            $sql = "select * from users where email=:email and password =:password";

            $stmt = $db->prepare($sql);
            $stmt->execute(['email' => $email, 'password' => $hashed_password]);

            if ($user = $stmt->fetch()) {
                header("Location: index.php");
                return;
            } else {
                $errors['not_login'][] = "This user is not found, Please Create a new Account" . "<br>" . "<a href=\"register.php\">Create a new Account</a>";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login to your account</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
</head>

<body>
    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-5">
                <form method="POST">
                    <div class="form-row">
                        <div class="col-md-12 mb-3">
                            <h1>Login to Your Account</h1>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-12 mb-3">
                            <label for="validationCustom02">Email</label>
                            <input type="email" class="form-control" id="validationCustom02" value="<?= $_POST['email'] ?>" name="email">
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
                    <button class="btn btn-primary" type="submit" name="login">Login</button>
                    <button class="btn btn-secondary" name="cancel">Cancel</button>
                    <?php
                    if (isset($errors['not_login'])) {
                        foreach ($errors['not_login'] as $val) {
                            echo "<br>" . $val . "<br>";
                        }
                    }
                    ?>
                </form>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
</body>

</html>