<?php
include("connection.php");
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

    <title>Signup</title>
  </head>
  <body>
    <div id="form">
      <h1>Signup Form</h1>
      <form class="form-fields" name="form" action="signup.php" method="post" enctype="multipart/form-data">
       <div class="form-field">
        <i class="fa-solid fa-user"></i>
        <input
          type="text"
          id="username"
          name="username"
          placeholder="enter username"
          pattern="^[a-zA-Z][a-zA-Z0-9_]{5,29}$"
          required
        />
       </div>
     
       <div class="form-field>
        <i class="fa-solid fa-envelope"></i>
        <input
          type="email"
          id="email"
          name="email"
          placeholder="enter email"
          required
        />
        </div>

        <div class="form-field>
        <i class="fa-solid fa-lock"></i>
        <input
          type="password"
          id="password"
          name="password"
          placeholder="enter password"
          required
        />
        </div>

        
        <i class="fa-solid fa-lock"></i>
        <input
          type="password"
          id="re-pass"
          name="re-pass"
          placeholder="re-enter password"
          required
        /><br /><br />

        <div id="gender">
          <label>Gender:</label>
          <input type="radio" id="male" name="gender" value="Male" />
          <label for="male">Male</label>
          <input type="radio" id="female" name="gender" value="Female" />
          <label for="female">Female</label>
          <input type="radio" id="other" name="gender" value="Other" />
          <label for="other">Other</label>
        </div>

        <label>Where did you find us?</label>
        <select name="place">
          <option>Social Media</option>
          <option>News Paper</option>
          <option>Google</option>
        </select>

        <label>Upload a profile picture: </label><br />
        <input type="file" id="image" name="image" /><br /><br />
        <p id="fileName"></p>
        
        <input
          type="submit"
          id="btn"
          value="SignUp"
          name="submit"
        /><br /><br />

        <p>Already have an account? Click to <a href="login.html">login</a></p>
      </form>
    </div>

    <script>
      document.getElementById('image').addEventListener('change', function() {
            const fileInput = document.getElementById('image');
            const fileName = fileInput.files[0] ? fileInput.files[0].name : "No file selected";
            document.getElementById('fileName').innerText = fileName;
            console.log(fileInput.files);
        });

      document.forms["form"].onsubmit = function () {
        var password = document.getElementById("password").value;
        if (password.length < 8) {
          alert("Password must be at least 8 characters long.");
          return false;
        }
        return true;
      };
    </script>
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.min.js"
      integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6"
      crossorigin="anonymous"
    ></script>
  </body>
</html>
