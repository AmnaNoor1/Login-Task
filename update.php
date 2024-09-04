<?php
include("connection.php");

if (!isset($_GET['id'])) {
    echo "Not found!";
    exit();
}

$id = intval($_GET['id']);

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
        echo '<script>alert("All fields are required."); window.location.href = "update.php?id=' . $id . '";</script>';
        exit();
    }
   
    //Email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo '<script>alert("Invalid email format."); window.location.href = "update.php?id=' . $id . '";</script>';
        exit();
    }

    //Image
    if (empty($image)) {
        $image = $user['ProfilePicture'];  // Keep current image if no new image is uploaded
    } else {
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
        $fileExtension = pathinfo($image, PATHINFO_EXTENSION);
        if (!in_array(strtolower($fileExtension), $allowedExtensions)) {
            echo '<script>alert("Please upload a valid image file."); window.location.href = "update.php?id=' . $id . '";</script>';
            exit();
        }
        if (!move_uploaded_file($tempname, $folder)) {
            echo '<script>alert("File not uploaded."); window.location.href = "update.php?id=' . $id . '";</script>';
            exit();
        }
    }

    //Username
    $usernamePattern = "/^(?=.*[A-Z])(?=.*[0-9])(?=.*[\W_]).{8,}$/";
    if (!preg_match($usernamePattern, $username)) {
        echo '<script>alert("Username must meet complexity requirements."); window.location.href = "update.php?id=' . $id . '";</script>';
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
                window.location.href = 'index.php';
              </script>";
    } elseif ($count_email > 0) {
        echo "<script>
                alert('Email already exists!!');
                window.location.href = 'index.php';
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
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" />
    <link rel="stylesheet" href="style.css" />
    <title>Update Profile</title>
</head>
<body>
    <div id="form">
        <h1>Update Profile</h1>
        <form class="form-fields" name="form" action="update.php?id=<?php echo htmlspecialchars($user['UserID']); ?>" method="post" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($user['UserID']); ?>" />

            <div class="form-field">
                <i class="fa-solid fa-user"></i>
                <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($user['UserName']); ?>" placeholder="Enter username" required />
            </div>

            <div class="form-field">
                <i class="fa-solid fa-envelope"></i>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['Email']); ?>" placeholder="Enter email" required />
            </div>

            <div class="form-field">
                <div id="gender">
                    <label class="label">Gender:</label>
                    <input type="radio" id="male" name="gender" value="Male" <?php echo ($user['Gender'] == 'Male') ? 'checked' : ''; ?> />
                    <label for="male">Male</label>
                    <input type="radio" id="female" name="gender" value="Female" <?php echo ($user['Gender'] == 'Female') ? 'checked' : ''; ?> />
                    <label for="female">Female</label>
                    <input type="radio" id="other" name="gender" value="Other" <?php echo ($user['Gender'] == 'Other') ? 'checked' : ''; ?> />
                    <label for="other">Other</label>
                </div>
            </div>

            <div class="form-field">
                <label class="label">Where did you find us?</label>
                <select name="place">
                    <option <?php echo ($user['Place'] == 'Social Media') ? 'selected' : ''; ?>>Social Media</option>
                    <option <?php echo ($user['Place'] == 'News Paper') ? 'selected' : ''; ?>>News Paper</option>
                    <option <?php echo ($user['Place'] == 'Google') ? 'selected' : ''; ?>>Google</option>
                </select>
            </div>

            <div class="form-field file-field">
                <label class="label">Upload a new profile picture:</label>
                <input type="file" id="image" name="image" />
                <?php if ($user['ProfilePicture']): ?>
                    <p>Current picture: <img src="Images/<?php echo htmlspecialchars($user['ProfilePicture']); ?>" alt="Profile Picture" style="width: 100px; height: 100px;" /></p>
                <?php endif; ?>
            </div>

            <input type="submit" id="btn" value="Update" name="update" />
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.min.js"></script>
</body>
</html>
