$(document).ready(function () {
  // AJAX for updating user
  $("#updateForm").on("submit", function (e) {
    e.preventDefault();

    var formData = new FormData(this);

    $.ajax({
      url: "update.php",
      type: "POST",
      data: formData,
      contentType: false,
      processData: false,
      success: function (response) {
        alert("Profile Updated");
      },
      error: function () {
        alert("An error occurred while updating.");
      },
    });
  });

  // AJAX for deleting user
  $('button[name="delete"]').on("click", function (e) {
    e.preventDefault();

    var userId = $(this).val();
    var row = $(this).closest("tr");

    $.ajax({
      url: "home.php",
      type: "POST",
      data: { id: userId },
      success: function (response) {
        alert("User Deleted");
        row.fadeOut(500, function () {
          row.remove();
        });
      },
      error: function () {
        alert("An error occurred while deleting.");
      },
    });
  });
});
