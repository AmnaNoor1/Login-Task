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
    $folder = "Images/" . $image;


    if (empty($username) || empty($email) || empty($password) || empty($rePassword) || empty($gender) || empty($place) || empty($image)) {
        echo '<script>
                alert("All fields are required.");
                window.location.href = "index.php";
              </script>';
        exit();
    }
    
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo '<script>
                alert("Invalid email format");
                window.location.href = "index.php";
              </script>';
        exit();
    }

    $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
    $fileExtension = pathinfo($image, PATHINFO_EXTENSION);
    if (!in_array(strtolower($fileExtension), $allowedExtensions)) {
        echo '<script>
                alert("Please upload a valid image file. Only JPG, JPEG, PNG, and GIF formats are allowed.");
                window.location.href = "index.php";
              </script>';
        exit();
    }

    $usernamePattern = "/^(?=.*[A-Z])(?=.*[0-9])(?=.*[\W_]).{8,}$/";
    if (!preg_match($usernamePattern, $username)) {
        echo '<script>
                alert("Username must be at least 8 characters long and contain at least one uppercase letter, one number, and one special character.");
                window.location.href = "index.php";
              </script>';
        exit();
    }

    if (strlen($password) < 8) {
        echo '<script>
                alert("Password must be at least 8 characters long.");
                window.location.href = "index.php";
              </script>';
        exit();
    }
   
    if (!move_uploaded_file($tempname, $folder)) {
        echo "File not uploaded";
        exit();
    }

    $sql = "SELECT * FROM users WHERE UserName='$username'";
    $result = mysqli_query($conn, $sql);
    $count_user = mysqli_num_rows($result);


    $sql = "SELECT * FROM users WHERE Email='$email'";
    $result = mysqli_query($conn, $sql);
    $count_email = mysqli_num_rows($result);

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
    } else {
        if ($password == $rePassword) {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $sql = "INSERT INTO users (UserName, Email, Password, Place, Gender, ProfilePicture) VALUES ('$username', '$email', '$hash', '$place', '$gender', '$image')";
            $result = mysqli_query($conn, $sql);

            if ($result) {
                header("Location: home.html");
            } else {
                echo "Error: " . mysqli_error($conn);
            }
        } else {
            echo '<script>
                    alert("Passwords do not match");
                    window.location.href = "index.php";
                  </script>';
        }
    }
}
?>
