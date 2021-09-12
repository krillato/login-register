<?php 
    use PHPMailer\PHPMailer\PHPMailer;
        //ดึงมาใช้
    require_once "../sendMailer/PHPMailer/PHPMailer.php";
    require_once "../sendMailer/PHPMailer/SMTP.php";
    require_once "../sendMailer/PHPMailer/Exception.php";
    
?>

<?php 
/*มีการเก็บ session*/
    session_start();
    include('server.php'); // ใช้งานตัวแปล $conn
    
    $errors = array();
    /* ---ถ้ามีการกด submit ในหน้า register--- */
    if (isset($_POST['reg_user'])) {
    
        /* ส่วนที่กรอก in register page */
        /* สร้างตัวแปรเก็บค่า จากหน้า register  */
        $username = mysqli_real_escape_string($conn, $_POST['username']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $password_1 = mysqli_real_escape_string($conn, $_POST['password_1']);
        $password_2 = mysqli_real_escape_string($conn, $_POST['password_2']);

        /* ตรวจสอบว่าค่าว่างหรือเปล่า ถ้าว่างให้ session error */
        //trim() ตัดช่องว่างต้นและท้ายสตริง
        //stripslashes ตัด backslashe ออกจากสตริง
        //preg_match() คัดอักขระ
        if (empty($username) OR $username==" " OR (!preg_match("/^[a-zA-Z0-9]*$/",$username))) 
        {
            array_push($errors, "Username is required");
            $_SESSION['error'] = "Username is required";
        }
            if( strlen($username)<6)
            {
                array_push($errors, "Username is required");
                $_SESSION['error'] = "Username is length 6 or more";
            }
        
        if (empty($email)) 
        {
            array_push($errors, "Email is required");
            $_SESSION['error'] = "Email is required";
        }
            if(!filter_var($email, FILTER_VALIDATE_EMAIL))
            {
                array_push($errors, "Email is required");
                $_SESSION['error'] = "รูปแบบ email ไม่ถูกต้อง";
            }
        
        if (empty($password_1) OR $password_1==" " OR  (!preg_match("/^[a-zA-Z0-9]*$/",$password_1))) 
        {
            array_push($errors, "Password is required");
            $_SESSION['error'] = "Password is required";
        }
            if(strlen($password_1)<6)
            {
                array_push($errors, "Username is required");
                $_SESSION['error'] = "Password is length 6 or more";
            }
    
            

        if ($password_1 != $password_2) 
        {
            array_push($errors, "The two passwords do not match");
            $_SESSION['error'] = "The two passwords do not match";
        }

        //ดึงข้อมูลจาก  table name  // fild name
        /* เลือกมา 2 ตัวว่ามี username || email นี้ในระบบแล้วรึยัง */
        $user_check_query = "SELECT * FROM ... WHERE `...` LIKE BINARY '%...%' OR ... = '...' LIMIT 1";
        
        /* -- คิวรีข้อมูลในระบบ -- */
        $query = mysqli_query($conn, $user_check_query);
        $result = mysqli_fetch_assoc($query);

        //check with system
        if ($result) 
        { // if user exists
            if ($result['username'] === $username) 
            { // ตรงกับ user ในระบบรึเปล่า
                array_push($errors, "Username already exists");//เพิ่ม error
                $_SESSION['error'] = "username นี้ถูกใช้งานไปแล้ว";
            }
            if ($result['email'] === $email) 
            {
                array_push($errors, "Email already exists");
                $_SESSION['error'] = "Email ถูกใช้งานไปแล้ว";
            }
        }

        //check error**
        if (count($errors) == 0) 
        { // =0 แสดงว่าไม่มี error
            $password = md5($password_1); //use function 
            
            /* เพิ่มข้อมูลลงไปในตาราง INSERT INTO ชื่อตาราง (ฟีล) VALUES (ตัวแปรที่จะเพิ่มเข้าไป) */
            $sql = "INSERT INTO ... VALUES ('...', '...', '...' )";
            mysqli_query($conn, $sql);

            $sql_point_table = "INSERT INTO ... (...) VALUES ('...')";
            mysqli_query($conn, $sql_point_table);



            /* ส่งเมลเมื่อสมัคร */
        
        
                $mail = new PHPMailer();
        
                $username_send = $username;
                $namesend = "Duckinglearning";
                $header = "Register Ducking learning";
                
        
                //SMTP Setting
                $mail->isSMTP();
                $mail->Host = "smtp.gmail.com";
                $mail->SMTPAuth = true;
                $mail->Username = "...@gmail.com";
                $mail->Password = "...";
                $mail->Port = 465;
                $mail->SMTPSecure = "ssl";
        
                //Email Setting
                $mail->isHTML(true);
                $mail->setFrom($email,$namesend);
                $mail->addAddress($email);  //sent to
                $mail->Subject = $header;
                $mail->Body = "
                <!DOCTYPE html>
                <html>
                    <head>
                        <meta charset=utf-8'/>
                        <title>ส่ง Email</title>
                    </head>
                    <body>
                        <h1 style='background: #3b434c;padding: 10px 0 20px 10px;margin-bottom:10px;font-size:30px;color:white;' >
                            
                            DUCKING LEARNING
                        </h1>
                        <div style='padding:20px;'>
                            <div style='text-align:center;margin-bottom:50px;'>
                            <h2><center>
                            ยินดีต้อนรับคุณ  $username_send  คุณได้ทำการสมัครบัญชีกับ : DUCKING LEARNING</center>	
                            </h2>	
                            </div>
                            <div>				
                                <h2>กรุณาคลิ๊กเพื่อยืนยันการสมัคร DUCKING LEARNING : <strong style='color:#0000ff;'></strong></h2>
                                <a href='#' target='_blank'>
                                    <h1><strong style='color:#3c83f9;'> >> กรุณาคลิ๊กที่นี่ เพื่อยืนยันการสมัครบัญชี<< </strong> </h1>
                                </a>
                            </div>
                            <div style='margin-top:30px;'>
                                <hr>
                                <address>
                                    <h4>ติดต่อสอบถาม</h4>
                                    <p>DUCKING LEARNING</p>
                                    <p>www.facebook.com/</p>
                                </address>
                            </div>
                        </div>
                        <div style='background: #3b434c;color: #a2abb7;padding:30px;'>
                            <div style='text-align:center'> 
                                2021 © DUCKING LEARNING Thailand
                            </div>
                        </div>
                    </body>
                </html>
            ";
        
                if($mail->send())
                {
                    $status = "success";
                    $response = "Email is sent";
                }
                else
                {
                    $status = "failer";
                    $response = "Someting is worng" . $mail->ErrorInfo ;
                }
        
                
            


            
            

            /*   session เป็น username   */
            $_SESSION['user_id'] = $objRe["user_id"];
            $_SESSION['username'] = $username; //เก็บ username ไว้ใน session เพื่อเข้าใช้ในระบบหลัง register
            $_SESSION['success'] = "You are now logged in";//เก็บไว้ไปแสดงในหน้า index
            header('location: ../home.php'); //ไปหน้า home
            exit(json_encode(array("status" => $status, "response"=> $response)));
        } else {
            header("location: ../register.php"); //ไปสมัคร
        }
}
?>