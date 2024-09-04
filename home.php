<?php
include("connection.php");

$sql = "SELECT * FROM users";
$result = $conn->query($sql);

$allUsers = [];
if ($result) {
    $allUsers = $result->fetch_all(MYSQLI_ASSOC);
} else {
    $error = "Error: " . $conn->error;
}

if (isset($_POST['delete'])){
    $id = $_POST['delete'];
    $sql = "DELETE FROM users WHERE UserID = $id";

    if ($conn->query($sql) === TRUE) {
        $deleteMessage = "User with ID $id has been deleted.";
    } else {
        $deleteError = "Error deleting user with ID $id.";
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
    <title>Home</title>
  </head>
<body>


<?php if (count($allUsers) > 0): ?>
    <table>
        <tr>
            <th>ID</th>
            <th>Username</th>
            <th>Email</th>
            <th>Place</th>
            <th>Gender</th>
            <th>Profile Picture</th>
            <th>Delete</th>
            <th>Update</th>
        </tr>
        <?php foreach ($allUsers as $user): ?>
            <tr>
                <td><?php echo $user['UserID']; ?></td>
                <td><?php echo $user['UserName']; ?></td>
                <td><?php echo $user['Email']; ?></td>
                <td><?php echo $user['Place']; ?></td>
                <td><?php echo $user['Gender']; ?></td>
                <td>
                    <img src="Images/<?php echo $user['ProfilePicture']; ?>" alt="Profile Picture" width="100" height="100">
                </td>
                <td>
                    <form method="post" action="">
                        <button name="delete" value="<?php echo $user['UserID']; ?>">Delete</button>
                    </form>
                </td>
                <td>
                    <a href="update.php?id=<?php echo $user['UserID']; ?>">Update</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
<?php else: ?>
    <p>No users found.</p>
<?php endif; ?>

</body>
</html>
