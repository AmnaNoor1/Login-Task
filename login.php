<?php
include("connection.php");
if(isset($_POST['login'])){
    $name=$_POST['name'];
    $password=$_POST['password'];

    $sql="select * from users where UserName='$name' or Email='$name' ";
    $result=mysqli_query($conn,$sql);
    $row=mysqli_fetch_array($result,MYSQLI_ASSOC);

    if ($row) {
        if(password_verify($password, $row['Password'])){
           header("Location: home.html");
        }
        else{
            echo '<script>
            alert("Invalid Password");
            window.location.href="login.html";
            </script>';
        }
    } else {
       echo '<script>
       alert("Invalid Username or Email");
       window.location.href="login.html";
       </script>';
    }
    
}
?>