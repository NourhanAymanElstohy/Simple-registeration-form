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
            $_SESSION['email-error'] = "Email is required";
            header("Location: login.php");
            return;
        } elseif (preg_match("/^[a-zA-z0-9]+@[a-z]+.[a-z]{2,4}$/", $_POST['email']) == false) {
            $_SESSION['email-error'] = "Email is not valid";
            header("Location: login.php");
            return;
        } else {
            $email = $_POST['email'];
            $_SESSION['email'] = $_POST["email"];
        }
        //========== password ===============
        if (strlen($_POST['password']) < 1) {
            $_SESSION['pass-error'] = "Password is required";
            header("Location: login.php");
            return;
        } else {
            $password = $_POST['password'];
            $_SESSION['password'] = $_POST['passworrd'];
            $salt = 'XyZzy12*_';
            $hashed_password = hash('md5', $salt . $password);
        }
        if ($email && $password) {
            $sql = "select * from users where email=:email";

            $stmt = $db->prepare($sql);
            $stmt->execute(['email' => $email]);

            if ($user = $stmt->fetch()) {
                if ($user["password"] != $hashed_password) {
                    $_SESSION["pass-error"] = "Incorrect Password";
                    header("Location: login.php");
                    return;
                } else {
                    $_SESSION['name'] = $user["name"];
                    header("Location: index.php");
                    return;
                }
            } else {
                $_SESSION['not-found'] = "This user is not found, Please Create a new Account" . "<br>" . "<a href=\"register.php\">Create a new Account</a>";
                header("Location: login.php");
                return;
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
                            <?php
                            if (isset($_SESSION['success'])) {
                                echo ('<p style="color: green;">' . htmlentities($_SESSION['success']) . "</p>\n");
                                unset($_SESSION['success']);
                            }
                            ?>
                            <h1>Login to Your Account</h1>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-12 mb-3">
                            <label for="validationCustom02">Email</label>
                            <input type="text" class="form-control" id="validationCustom02" value="<?= $_SESSION['email']  ?>" name="email">
                            <?php
                            if (isset($_SESSION['email-error'])) {
                                echo ('<p style="color: red;">' . htmlentities($_SESSION['email-error']) . "</p>\n");
                                unset($_SESSION['email-error']);
                            }
                            ?>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-12 mb-3">
                            <label for="validationCustom05">Password</label>
                            <input type="password" class="form-control" id="validationCustom05" value="<?= $_SESSION['password'] ?>" name="password">
                            <?php
                            if (isset($_SESSION['pass-error'])) {
                                echo ('<p style="color: red;">' . htmlentities($_SESSION['pass-error']) . "</p>\n");
                                unset($_SESSION['pass-error']);
                            }
                            ?>
                        </div>
                    </div>
                    <button class="btn btn-primary" type="submit" name="login">Login</button>
                    <button class="btn btn-secondary" name="cancel">Cancel</button>
                    <?php
                    if (isset($_SESSION['not-found'])) {
                        echo ("<br>" . $_SESSION['not-found']);
                        unset($_SESSION['not-found']);
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