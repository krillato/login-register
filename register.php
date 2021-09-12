<?php 
    session_start();
    include('db/server.php');
    session_destroy();
    unset($_SESSION['username']); 
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="icon" type="image/png" href="img/duckling/01-born.png" />
    <title>สมัครสมาชิก</title>
    <link rel="stylesheet" type="text/css" media="all" href="css/create-ac-style.css?ver=1001" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css"
        integrity="sha384-tKLJeE1ALTUwtXlaGjJYM3sejfssWdAaWR2s97axw4xkiAdMzQjtOjgcyw0Y50KU" crossorigin="anonymous" />
</head>

<body>
    <main>

        <div class="main-grid">

            <!-- ============== Left ============== -->
            <div class="container-items">
                <!-- ========== Header ============= -->
                <div class="header">
                    <a href="index.html">Ugly Duckling</a>
                    <p>สมัครสมาชิก</p>
                </div>


                <!-- เมื่อคลิก submit จะมีการทำงานเบื้องหลังที่ register_db.php  -->
                <form action="db/register_db.php" method="post">
                    <div >
                        <!-- กรณีเกิด error  -->
                        <?php include('errors.php'); ?>
                        <?php if (isset($_SESSION['error'])) : ?>
                        <div class="error">
                            <h3>
                                <?php 
                        echo $_SESSION['error'];
                        unset($_SESSION['error']);
                    ?>
                            </h3>
                        </div>
                        <?php endif ?>
                    </div>
                    <!-- ส่วนการรับเข้าข้อมูล  -->

                    <label class="text" for="username">Username</label>
                    <input class="text" type="text" name="username" placeholder="เฉพาะ a-z, A-Z, 0-9">
                    <!-- กำหนด name เพราะต้องใช้ในการรับค่า  -->

                    <label class="text" for="email">Email</label>
                    <input class="text" type="email" name="email" placeholder="เช่น xxxxx@gmail.com">

                    <label class="text" for="password_1">Password</label>
                    <input class="text" type="password" name="password_1" size=”6″ maxlength=”50″
                        placeholder="เฉพาะ a-z, A-Z, 0-9">


                    <label class="text" for="password_2">Confirm Password</label>
                    <input class="text" type="password" name="password_2" size=”6″ maxlength=”50″
                        placeholder="ยืนยันรหัสผ่าน">





                    <!-- ไปที่หน้า login ถ้าเป็นสมาชิกอยู่แล้ว  -->


                    <div class="button">
                        <a href="login.php">เข้าสู่ระบบ</a>
                        <button type="submit" name="reg_user" class="btn">ต่อไป</button>
                    </div>
                </form>
            </div>


            <!-- ============== Right ============== -->
            <div class="right-items">
                <img src="img/duckling/01-born.png" alt="">
            </div>

        </div>
    </main>
</body>

</html>