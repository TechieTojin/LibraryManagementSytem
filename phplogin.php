<?php
  include("connection.php");

  // Check if the form is submitted
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve values from the form
    $username = $_POST["username"];
    $password = $_POST["pwd"];

    // Perform authentication (you'll need to replace this with your actual authentication logic)
    // For example, you might query a database to check if the username and password match a user record.
    // This is just a simple example and should be enhanced for security.
    $sql = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
    $result = mysqli_query($connection, $sql);

    // Check if the query was successful and if a matching user was found
    if ($result && mysqli_num_rows($result) > 0) {
      // Redirect to the home page on successful login
      header("Location: homepg.html");
      exit();
    } else {
      // Authentication failed, you might want to display an error message or redirect to the login page
      $error_message = "Invalid username or password.";
    }
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <!-- ... (unchanged head section) ... -->
</head>
<body>
  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
    <!-- ... (unchanged form section) ... -->
  </form>
</body>
</html>
