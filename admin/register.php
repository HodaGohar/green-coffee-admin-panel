<?php include '../components/connection.php';
session_start();
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    $user_id = '';
}
//register user
if (isset($_POST['register'])) {
    // $id = unique_id();
    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_SPECIAL_CHARS);
    $email = $_POST['email'];
    $email = filter_var($email, FILTER_SANITIZE_SPECIAL_CHARS);
    $pass = $_POST['password'];
    $pass = filter_var($pass, FILTER_SANITIZE_SPECIAL_CHARS);
    $cpass = $_POST['cpass'];
    $cpass = filter_var($cpass, FILTER_SANITIZE_SPECIAL_CHARS);
    $image = $_FILES['image']['name'];
    $image = filter_var($image, FILTER_SANITIZE_SPECIAL_CHARS);
    $image_tmp_name = $_FILES['image']['tmp_name'];
    $image_folder = '../img' . $image;


    $select_admin = $conn->prepare("SELECT * FROM `admin` WHERE email = ?");
    $select_admin->execute([$email]);

    if ($select_admin->rowCount() > 0) {
        $warning_msg[] = 'user email already exist';
    } else {
        if ($pass != $cpass) {
            $warning_msg[] = 'confirm password not matched';
        } else {
            $insert_admin = $conn->prepare("INSERT INTO `admin`(name,email,password,profile) VALUES(?,?,?,?)");
            $insert_admin->execute([ $name, $email, $pass, $image]);
            move_uploaded_file($image_tmp_name, $image_folder);
            $success_msg[] = 'New Admin Register';
        }
    }
}

?>


<style type="text/css">
    <?php include 'css/style.css'; ?>
</style>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="./admin_style.css?v=<?php echo time(); ?>" type="text/css">
    <title>gren coffee admin panal - register page</title>
</head>

<body>

    <div class="main-container">
        <section>
            <div class="form-container" id="admin_login">
                <form action="" method="post" enctype="multipart/form-data">
                    <h3>register now</h3>
                    <div class="input-field">
                        <label>user name <sup>*</sup></label>
                        <input type="text" name="name" required placeholder="enter your user name" maxlength="20" oninput="this.value.replace(/\s/g,'')">
                    </div><!-- ./input-filed -->

                    <div class="input-field">
                        <label>user email <sup>*</sup></label>
                        <input type="email" name="email" required placeholder="enter your email" maxlength="20" oninput="this.value = this.value.replace(/\s/g, '')">
                    </div><!-- ./input-filed -->

                    <div class="input-field">
                        <label>user password <sup>*</sup></label>
                        <input type="password" name="password" required placeholder="enter your password" maxlength="20" oninput="this.value = this.value.replace(/\s/g, '')">
                    </div><!-- ./input-filed -->

                    <div class="input-field">
                        <label>confirm password <sup>*</sup></label>
                        <input type="password" name="cpass" required placeholder="enter your confirm password" maxlength="20" oninput="this.value = this.value.replace(/\s/g, '')">
                    </div><!-- ./input-filed -->

                    <div class="input-field">
                        <label>select profile <sup>*</sup></label>
                        <input type="file" name="image" accept="image/*">
                    </div><!-- ./input-filed -->

                    <button type="submit" name="register" class="btn">register now</button>
                    <p>already have an account? <a href="login.php">login now</a></p>
                </form>
            </div><!-- ./form-container" -->
        </section>
    </div><!-- ./main-container -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script src="./script.js"></script>
    <?php include '../components/alert.php'; ?>
</body>

</html>