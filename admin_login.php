<?php
    require_once "login.php";
    require_once "utils.php";
    
    
    $connection = new mysqli($hn, $un,$pw,$db);
    if($connection -> connect_error) die(mysql_conn_error($connection -> connect_error));
    
    if(isset($_POST['email']) && isset($_POST['password']) && isset($_POST['username'])){
        $sanitized_email = sanitizeMySQL($connection, $_POST['email']);
        $sanitized_name = sanitizeMySQL($connection, $_POST['username']);
        $sanitized_password = sanitizeString($_POST['password']);
        
        $stmt = $connection->prepare('SELECT * FROM admininfo WHERE username=? AND useremail=?');
        $stmt->bind_param('ss', $sanitized_name, $sanitized_email);
        $stmt -> execute();
        if (!$stmt) die (mysql_conn_error($conn->error));
        
        $result = $stmt->get_result();
        
        $stmt->close();
        
        
        if(!$result)die(mysql_conn_error($connection ->error));
        else if($result -> num_rows){
            $row = $result -> fetch_array(MYSQLI_ASSOC);
            $result -> close();
            $salt = $row['usersalt'];
            $token = hash('ripemd128',$salt.$sanitized_password);
            if($token == $row['Userpassword']){
                session_start();
                session_regenerate_id(); // preventing session finaxtion by regenting session ID
                $_SESSION['adminname'] = $sanitized_name;
                $_SESSION['adminemail'] = $sanitized_email;
                echo "'$sanitized_name' you are now logged in  as ADMIN!!";
                die ("<a href = admin_upload.php> Click here to continue</a>");
             }
            else die("Inavlid username or Password");
        }
        else die("Inavlid username or Password");
    }
    else{
        echo <<<_END
        <!DOCTYPE html><html><head><title>An Example Form</title><style>.signup {border:1px solid #999999; font: normal 14px helvetica; color: #444444;}
            </style>
            <script src="/final/function_validate.js"></script>
            </head>
            <body><table border="0" cellpadding="2" cellspacing="5" bgcolor="#eeeeee"><th colspan="2" align="center"> Admin Login </th><form method="post" action="admin_login.php" onsubmit="return validate(this)">
                <tr><td>Username</td><td><input type="text" maxlength="16" name="username"></td></tr>
                <tr><td>Password</td><td><input type="password" maxlength="12" name="password"></td></tr>
                <tr><td>Email</td><td><input type="text" maxlength="64" name="email"></td></tr>
                <tr><td colspan="2" align="center"><input type="submit"value="login"></td></tr>
            </form></table>
            </body>
            </html>
        _END;
    }

    $connection -> close();
    
?>

