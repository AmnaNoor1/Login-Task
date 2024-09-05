<?php
include("connection.php");

if (!isset($_POST['id'])) {
    echo "Not found!";
    exit();
}

$id = intval($_POST['id']);

//user details
$sql = "SELECT * FROM users WHERE UserID = $id";
$result = $conn->query($sql);
if ($result) {
    $user = $result->fetch_assoc();
}

if (!$user) {
    header("Location: home.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $place = $_POST['place'];
    $gender = $_POST['gender'];
    $image = $_FILES['image']['name'];
    $tempname = $_FILES['image']['tmp_name'];
    $folder = "Images/" . $image;

    //Empty
    if (empty($username) || empty($email) || empty($gender) || empty($place)) {
        echo '<script>alert("All fields are required."); window.location.href = "home.php";</script>';
        exit();
    }
   
    //Email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo '<script>alert("Invalid email format."); window.location.href = "home.php";</script>';
        exit();
    }

    //Image
    if (empty($image)) {
        $image = $user['ProfilePicture'];  // Keep current image if no new image is uploaded
    } else {
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
        $fileExtension = pathinfo($image, PATHINFO_EXTENSION);
        if (!in_array(strtolower($fileExtension), $allowedExtensions)) {
            echo '<script>alert("Please upload a valid image file."); window.location.href = "home.php";</script>';
            exit();
        }
        if (!move_uploaded_file($tempname, $folder)) {
            echo '<script>alert("File not uploaded."); window.location.href = "home.php";</script>';
            exit();
        }
    }

    //Username
    $usernamePattern = "/^(?=.*[A-Z])(?=.*[0-9])(?=.*[\W_]).{8,}$/";
    if (!preg_match($usernamePattern, $username)) {
        echo '<script>alert("Username must meet complexity requirements."); window.location.href = "home.php";</script>';
        exit();
    }

    $sql = "SELECT * FROM users WHERE UserName='$username' AND UserID != $id";
    $result = mysqli_query($conn, $sql);
    $count_user = mysqli_num_rows($result);

    $sql = "SELECT * FROM users WHERE Email='$email' AND UserID != $id";
    $result = mysqli_query($conn, $sql);
    $count_email = mysqli_num_rows($result);

    if ($count_user > 0) {
        echo "<script>
                alert('Username already exists!!');
                window.location.href = 'home.php';
              </script>";
    } elseif ($count_email > 0) {
        echo "<script>
                alert('Email already exists!!');
                window.location.href = 'home.php';
              </script>";
    } else {
        $sql = "UPDATE users SET UserName = '$username', Email = '$email', Place = '$place', Gender = '$gender', ProfilePicture= '$image' WHERE UserID = $id";
        $stmt = $conn->prepare($sql);
        $result = mysqli_query($conn, $sql);

        if ($result) {
            header("Location: home.php");
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    }
}
?>

<?php
include("connection.php");

if (!isset($_GET['id'])) {
    echo "Not found!";
    exit();
}

$id = intval($_GET['id']);

// Fetch user details
$sql = "SELECT * FROM users WHERE UserID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if (!$user) {
    header("Location: home.php");
    exit();
}
?>
