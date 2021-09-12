<?php 
    session_start();
    include('server.php');

    $errors = array(); //เอาไว้เก็บ error

    /* -- then user click log in from logIn page -- */
    if (isset($_POST['login_user'])) { // click btn name login_user
        $username = mysqli_real_escape_string($conn, $_POST['username']); //เก็บusername
        $password = mysqli_real_escape_string($conn, $_POST['password']); //เก็บpassword

        /* ตรวจสอบว่าค่าว่างหรือเปล่า ถ้าว่างให้  error เก็บข้อความไว้*/
        if (empty($username)) {
            array_push($errors, "Username is required");
        }

        if (empty($password)) {
            array_push($errors, "Password is required");
        }

        
        

        // ถ้าไม่มี error
        if (count($errors) == 0) {
            /* ตอนสมัคร มีการเก็บรหัสแบบเข้ารหัสไว้ ตอนเข้าระบบก็ต้องถอดรหัส */
            $password = md5($password);

            /* เช็ค username password จากuser */
            $query = "SELECT * FROM ... WHERE `...` LIKE BINARY '%...%' AND ... = '$password' ";
            $result = mysqli_query($conn, $query); 
            $objRe = mysqli_fetch_array($result);

            
            
            if (mysqli_num_rows($result) == 1) {


                if($objRe["Login_Status"]=="pending"){
             
                    mysqli_close($conn);
                    $_SESSION['error'] = "'".$username."' บัญชีพบข้อผิดพลาดระหว่างใช้งานโปรดติดต่อทีมงาน! ";
                    header("location: ../login.php");
                }
        

              /*  if($objRe["Login_Status"]=="online"){
                    echo "'".$username."' username นี้กำลังใช้งานอยู่! ";
                    echo  $objRe["Login_Status"] ;
                    //echo  $objRe["user_id"] ;
                    
                }*/
                else{

                    //Updata status
                $sql = "UPDATE ... SET ... ='online' WHERE ... ='".$objRe["user_id"]."'";
                $result = mysqli_query($conn, $sql) ;
                $query2 = mysqli_query($conn,$sql); // con มี nตัวเดียว

                $_SESSION['user_id'] = $objRe["user_id"];
                $_SESSION['username'] = $username;
                $_SESSION['success'] = "Your are now logged in";

                $Status_user = $objRe['User_Status'];

                //เป็นแอดมิน
                if($Status_user == 0){ mysqli_close($conn);
                    header("location: ../admin_page.php"); }
                //เป็นuser
                elseif($Status_user == 1){ mysqli_close($conn);
                    header("location: ../home.php"); }

              

                

                mysqli_close($conn);
                
                }
                
            } else { //ถ้า รหัสผิดพลาด ให้ session เก็บข้อความไว้ และ ไปที่หน้า login
                array_push($errors, "Wrong Username or Password");
                $_SESSION['error'] = "Wrong Username or Password!";
                header("location: ../login.php");
               
            }
        } else {
            array_push($errors, "Username & Password is required");
            $_SESSION['error'] = "Username & Password is required";
            header("location: ../login.php");
        }
    }
?>