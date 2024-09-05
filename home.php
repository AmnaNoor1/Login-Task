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

// Handle the delete request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = intval($_POST['id']);  // Safely retrieve and validate the user ID

    $sql = "DELETE FROM users WHERE UserID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "User with ID $id has been deleted.";  // Return success message
    } else {
        echo "Error deleting user with ID $id.";  // Return error message
    }

    exit();  // Ensure no further output
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" />
    <link rel="stylesheet" href="style.css" />
    <title>Home</title>
</head>
<body>

<div class="container mt-5">
    <?php if (count($allUsers) > 0): ?>
        <table class="table table-bordered">
            <thead>
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
            </thead>
            <tbody>
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
                                <button name="delete" value="<?php echo $user['UserID']; ?>" class="btn btn-danger">Delete</button>
                            </form>
                        </td>
                        <td>
                            <button class="btn btn-primary open-modal" 
                                    data-id="<?php echo $user['UserID']; ?>" 
                                    data-username="<?php echo $user['UserName']; ?>" 
                                    data-email="<?php echo $user['Email']; ?>" 
                                    data-gender="<?php echo $user['Gender']; ?>" 
                                    data-place="<?php echo $user['Place']; ?>" 
                                    data-picture="<?php echo $user['ProfilePicture']; ?>" 
                                    data-toggle="modal" 
                                    data-target="#updateModal">
                                Update
                            </button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No users found.</p>
    <?php endif; ?>

    <!-- Update Modal -->
    <div class="modal fade" id="updateModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Update Profile</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="updateForm" method="post" action="update.php" enctype="multipart/form-data">
                        <input type="hidden" id="userId" name="id" value="" />

                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" class="form-control" id="modalUsername" name="username" value="" required />
                        </div>

                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="modalEmail" name="email" value="" required />
                        </div>

                        <div class="form-group">
                            <label>Gender</label><br>
                            <input type="radio" id="modalMale" name="gender" value="Male" /> Male
                            <input type="radio" id="modalFemale" name="gender" value="Female" /> Female
                            <input type="radio" id="modalOther" name="gender" value="Other" /> Other
                        </div>

                        <div class="form-group">
                            <label for="place">Where did you find us?</label>
                            <select class="form-control" id="modalPlace" name="place">
                                <option value="Social Media">Social Media</option>
                                <option value="News Paper">News Paper</option>
                                <option value="Google">Google</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="image">Profile Picture</label>
                            <input type="file" class="form-control-file" id="modalImage" name="image" />
                            <img id="currentPicture" src="" alt="Profile Picture" style="width: 100px; height: 100px;">
                        </div>

                        <button type="submit" class="btn btn-primary">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.bundle.min.js"></script>

<script>
$(document).ready(function(){
    $('.open-modal').on('click', function(){
        var userId = $(this).data('id');
        var username = $(this).data('username');
        var email = $(this).data('email');
        var gender = $(this).data('gender');
        var place = $(this).data('place');
        var picture = $(this).data('picture');

        $('#userId').val(userId);
        $('#modalUsername').val(username);
        $('#modalEmail').val(email);

        if (gender == 'Male') {
            $('#modalMale').prop('checked', true);
        } else if (gender == 'Female') {
            $('#modalFemale').prop('checked', true);
        } else {
            $('#modalOther').prop('checked', true);
        }

        $('#modalPlace').val(place);
        $('#currentPicture').attr('src', 'Images/' + picture);
    });
});
</script>

<script src="ajax.js"></script>

</body>
</html>
