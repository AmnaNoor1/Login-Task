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
           header("Location: home.php");
        }
        else{
            echo '<script>
            alert("Invalid Password");
            window.location.href="login.php";
            </script>';
        }
    } else {
       echo '<script>
       alert("Invalid Username or Email");
       window.location.href="login.php";
       </script>';
    }
    
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1, shrink-to-fit=no"
    />

    <!-- Bootstrap CSS -->
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css"
      integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh"
      crossorigin="anonymous"
    />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
    />
    <link rel="stylesheet" href="style.css" />

    <title>Login</title>
  </head>
  <body>
    <div id="form" style="width: 40%">
      <h1>Login Form</h1>
      <form name="form" action="login.php" method="post">
        <i class="fa-solid fa-user"></i>
        <input
          type="text"
          id="name"
          name="name"
          placeholder="enter username/email"
          required
        /><br /><br />
        <i class="fa-solid fa-lock"></i>
        <input
          type="password"
          id="password"
          name="password"
          placeholder="enter password"
          required
        /><br /><br />
        <input type="submit" id="btn" value="Login" name="login" /><br /><br />
        <p>Don't have an account? Click to <a href="index.php">signup</a></p>
      </form>
    </div>

    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.min.js"
      integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6"
      crossorigin="anonymous"
    ></script>
  </body>
</html>
