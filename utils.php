<?php

    function mysql_conn_error($error){
        echo "<h1> Not Successful please try again</h1>";
        echo "<img src = 'https://youareenough712.files.wordpress.com/2018/07/screen-shot-2017-03-06-at-2-54-30-pm.png?w=908'>";
    }
    
    function sanitizeString($var) {
        $var = stripslashes($var);
        $var = strip_tags($var);
        $var = htmlentities($var);
        return $var;
    }
    
    function sanitizeMySQL($connection, $var){
        $var = $connection->real_escape_string($var);
        $var = sanitizeString($var);
        return $var;
    }
    
    
    function destroy_session_and_data() {
            $_SESSION = array();
            setcookie(session_name(), '', time() - 2592000, '/');
            session_destroy();
        }

?>
