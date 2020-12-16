<?php     // upload.php
    require_once "login.php";
    require_once "utils.php";
    
    
    
    $conn = new mysqli($hn, $un, $pw, $db);
    if ($conn->connect_error) die(mysql_conn_error($conn->connect_error));
    session_start();
    
    if(isset($_POST['signout']) && $_POST['signout'] == "signout"){
        destroy_session_and_data();
        $_POST = array();
        echo "<h1> you are logged out </h1>";
        die( "<p> Please Login <a href=login_page.php> Login </a> OR <a href=signup.php> Sign Up </a> OR <a href=admin_login.php> Admin Login </a></p>");
    }
    
    if (isset($_SESSION['username']) && isset($_SESSION['email'])){
        
        $sanitized_name = sanitizeMySQL($conn, $_SESSION['username']);
        $sanitized_email = sanitizeMySQL($conn, $_SESSION['email']);
        

        echo "<h1> You are logged in as '$sanitized_name' </h1>";
        echo <<<_END
        <html>
        <head>
            <script src="/final/function_validate.js"></script>
        </head>
        
        <body>
        <h2> upload  a txt, pdf or zip File to check for virus:</h2>
        <form action="upload.php" method="post" enctype="multipart/form-data" onsubmit = "return validate_upload(this)">
        <pre>
        File <input type="file" name="filetoupload" size ="10">
        CLICK: <input type = "submit" value="Upload"  name="upload">
        </pre></form>
            
        <form action="upload.php" method="post" enctype="multipart/form-data">
            SIGN OUT <input type = "submit" value = "signout" name = "signout">
        </form>
            
        </body>
        </hmtl>
        _END;
        

            if($_FILES){
                switch($_FILES['filetoupload']['type']){
                       case 'text/plain' : $ext = 'txt';
                       break;
                       case 'application/pdf': $ext = 'pdf';
                       break;
                       case 'application/zip': $ext = 'zip';
                       break;
                       }
                if ($ext) {
                    $target_dir = "files/";
                    $file = sanitizeString($_FILES['filetoupload']['name']);
                    $path = pathinfo($file);
                    $filename = $path['filename'];
                    $temp_name = sanitizeString($_FILES['filetoupload']['tmp_name']);
                    $path_filename_ext = $target_dir.$filename.".".$ext;
                  
                    if (file_exists($path_filename_ext)) {
                     echo "Sorry, file already exists. <br>";
                     }else{
                     move_uploaded_file($temp_name,$path_filename_ext);
                     echo "Congratulations! File Uploaded for Scan Successfully. <br>";
                     }
                    
                   
                    
                    $path = "python3 virusScan.py ".$path_filename_ext;
                    $command = escapeshellcmd($path);
                    $output = shell_exec($command);
                    echo $output;
                    
    
                    
                    //delete file from server
                    $removeCmd = "rm ".$path_filename_ext;
                    $command = escapeshellcmd($removeCmd);
                    $output = shell_exec($command);
                    echo $output;
                    
                    
                    
            }
            else{
                    echo "Invalid Format";
            }
        }
            else{
                echo "No File uploaded";
            }
       
 }
    else{
        echo "<p> Please Login <a href=login_page.php> Login </a> OR <a href=signup.php> Sign Up </a> OR <a href=admin_login.php> Admin Login </a></p>";
    }
   
?>

