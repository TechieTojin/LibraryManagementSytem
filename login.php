<?php
  include("connection.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login ST JOSEPH'S UNIVERSITY</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      background-image: url("bil.jpg");
      background-size: cover;
      background-position: center;
    }

    form {
      background-color: rgba(255, 255, 255, 0.0);
      border-radius: 8px;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
      padding: 20px;
      width: 300px;
      text-align: center;
      backdrop-filter: blur(5px); /* Apply blur effect for transparency */
    }

    h2 {
      background-color: rgba(76, 175, 80, 0.8); /* Adjust the alpha value for transparency */
      color: white;
      padding: 10px;
      border-radius: 8px 8px 0 0;
      margin-top: 0;
    }

    label {
      display: block;
      margin-bottom: 8px;
      color: #faf6f6;
    }

    input {
      width: 100%;
      padding: 8px;
      margin-bottom: 16px;
      border: 1px solid #dddddd;
      border-radius: 4px;
      box-sizing: border-box;
    }

    input[type="submit"] {
      background-color: #4caf50;
      color: white;
      cursor: pointer;
    }

    input[type="submit"]:hover {
      background-color: #45a049;
    }

    a {
      text-decoration: none;
      color: #007bff;
      display: block;
      margin-top: 12px;
    }
  </style>
</head>
<body>
  <form action="homepg.html" method="post">
    <h2>ST JOSEPH'S UNIVERSITY LOGIN</h2>
    <label for="username">Username:</label>
    <input type="text" id="username" name="username" required>
    <label for="pwd">Password:</label>
    <input type="password" id="pwd" name="pwd" required>
    <input type="submit" value="Login">
    <a href="/register">Don't have an account? Register</a>
    <a href="/forgot_password">Forgot Password</a>
  </form>
</body>
</html>
