<?php
    require_once "login.php";
    require_once "utils.php";
    
    $connection = new mysqli($hn, $un,$pw,$db);
    if($connection -> connect_error) die(mysql_conn_error($connection -> connect_error));
    
    if(isset($_POST['email']) && isset($_POST['password']) && isset($_POST['username'])){
        $sanitized_email = sanitizeMySQL($connection, $_POST['email']);
        $sanitized_name = sanitizeMySQL($connection, $_POST['username']);
        $sanitized_password = sanitizeString($_POST['password']);
        $salt = substr($sanitized_email,0).substr($sanitized_name,0);
        $stmt = $connection->prepare('INSERT INTO userinfo VALUES(?,?,?,?)');
        $token = hash('ripemd128',$salt.$sanitized_password);
        $stmt->bind_param('ssss', $sanitized_name, $sanitized_email, $salt, $token);
        $stmt->execute();
          
    
        
        if (!$stmt) die (mysql_conn_error($conn->error));
        else{
            session_start();
            $_SESSION['username'] = $sanitized_name;
            $_SESSION['email'] = $sanitized_email;
            echo "'$sanitized_name' you are now logged in !!";
            die ("<a href = upload.php> Click here to continue</a>");
        }
        $stmt->close();
    }
    else{
        echo <<<_END
        <!DOCTYPE html><html><head><title>An Example Form</title><style>.signup {border:1px solid #999999; font: normal 14px helvetica; color: #444444;}
            </style>
            <script src="/final/function_validate.js"></script>
            </head>
            <body><table border="0" cellpadding="2" cellspacing="5" bgcolor="#eeeeee"><th colspan="2" align="center">Signup Form</th><form method="post" action="signup.php" onsubmit="return validate(this)">
                <tr><td>Username</td><td><input type="text" maxlength="16" name="username"></td></tr>
                <tr><td>Password</td><td><input type="password" maxlength="12" name="password"></td></tr>
                <tr><td>Email</td><td><input type="text" maxlength="64" name="email"></td></tr>
                <tr><td colspan="2" align="center"><input type="submit"value="Signup"></td></tr>
            <tr><td colspan="2" align="center"><a href=login_page.php> Login </a> </td></tr>
            </form></table>
            </body>
            </html>
        _END;
    }
    
    $connection->close();
    
?>
