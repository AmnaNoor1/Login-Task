<?php
include("connection.php");
if (isset($_POST['submit'])){
    $username= $_POST['username'];
    $email= $_POST['email'];
    $password= $_POST['password'];
    $rePassword= $_POST['re-pass'];

    $sql="select * from users where UserName='$username' ";
    $result=mysqli_query($conn,$sql);
    $count_user=mysqli_num_rows($result);

    $sql="select * from users where Email='$email' ";
    $result=mysqli_query($conn,$sql);
    $count_email=mysqli_num_rows($result);

    if ($count_user == 0 && $count_email == 0) {
        if ($password == $rePassword) {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $sql = "INSERT INTO users (UserName, Email, Password) VALUES ('$username', '$email', '$hash')";
            $result = mysqli_query($conn, $sql);
            
            if ($result) {
                header("Location: home.html");
            }
        }
        else {
            echo '<script>
                    alert("Passwords do not match");
                    window.location.href = "index.html";
                  </script>';
        }
        
    } else {
        if ($count_user > 0) {
            echo "<script>
                    alert('Username already exists!!');
                    window.location.href = 'index.html';
                  </script>";
        } elseif ($count_email > 0) {
            echo "<script>
                    alert('Email already exists!!');
                    window.location.href = 'index.html';
                  </script>";
        }
    }
    
    

}
?>