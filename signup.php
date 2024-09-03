<?php
include("connection.php");
if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $rePassword = $_POST['re-pass'];
    $gender = $_POST['gender'];
    $place = $_POST['place'];
    
    $image = $_FILES['image']['name'];
    $tempname = $_FILES['image']['tmp_name'];
    $folder = "Images/".$image; 
    
    if (move_uploaded_file($tempname, $folder)) {
        echo "<h2>File uploaded successfully</h2>";
    } else {
        echo "<h2>File not uploaded successfully</h2>";
    }
    
    $sql = "SELECT * FROM users WHERE UserName='$username'";
    $result = mysqli_query($conn, $sql);
    $count_user = mysqli_num_rows($result);

    $sql = "SELECT * FROM users WHERE Email='$email'";
    $result = mysqli_query($conn, $sql);
    $count_email = mysqli_num_rows($result);

    if ($count_user == 0 && $count_email == 0) {
        if ($password == $rePassword) {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $sql = "INSERT INTO users (UserName, Email, Password, Place, Gender, ProfilePicture) VALUES ('$username', '$email', '$hash', '$place', '$gender', '$image')";
            $result = mysqli_query($conn, $sql);
            
            if ($result) {
                // header("Location: home.html");
            } else {
                echo "Error: " . mysqli_error($conn);
            }
        } else {
            echo '<script>
                    alert("Passwords do not match");
                    window.location.href = "index.php";
                  </script>';
        }
    } else {
        if ($count_user > 0) {
            echo "<script>
                    alert('Username already exists!!');
                    window.location.href = 'index.php';
                  </script>";
        } elseif ($count_email > 0) {
            echo "<script>
                    alert('Email already exists!!');
                    window.location.href = 'index.php';
                  </script>";
        }
    }
}
?>
