<?php 
include 'php/dbconnect.php';
if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['Send'])){
    $username = $_POST['username'];
    $email = $_POST['email'];
    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn -> prepare($sql);
    $stmt -> bind_param("s", $username);
    $stmt -> execute();
    $stmt->store_result();
    if($stmt ->  num_rows > 0){
        $expire_time = time() + 300; 
       setcookie('my_cookie', $username, $expire_time);
        include 'Send_mail.php';
    }else{
        $message = "Username is not exist!";  
    }
}
?>