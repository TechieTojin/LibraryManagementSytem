<!DOCTYPE html>
<html lang="en">
<head>
    <title>Computer Books</title>
    <style>
         body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-image: url('bookinfo.jpg'); /* Check and ensure the path to your background image */
            background-size: cover;
            background-position: center;
            text-align: center; /* Center align content */
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px; /* Add space between search box and table */
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            background-color: white;
            opacity: 0.8;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: grey;
        }
        form {
            margin-top: 20px; /* Add space above the form */
        }
        input[type="text"], input[type="submit"] {
            padding: 8px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-family: Arial, sans-serif; /* Set font for input elements */
        }
    </style>
</head>
<body>
    <h1>Computer Science Books</h1>
    <form method="post" style="margin-top: 20px;">
        <input type="text" name="search" placeholder="Search by Book Name" style="padding: 8px; font-size: 16px; border: 1px solid #ccc; border-radius: 5px; font-family: Arial, sans-serif;">
        <input type="submit" value="Search" style="padding: 8px 12px; font-size: 16px; border: 1px solid #ccc; border-radius: 5px; font-family: Arial, sans-serif; background-color: #f0f0f0; cursor: pointer;">
    </form>
    <table>
        <tr>
            <th>Book ID</th>
            <th>Book Name</th>
            <th>Author Name</th>
            <th>publisher</th>
            <th>Quantity</th>
        </tr>
        <?php
        $conn = mysqli_connect("localhost", "root", "", "comp_books");
        if ($conn->connect_error) {
          die("Failed to connect: " . $conn->connect_error);
        }
        if(isset($_POST['search'])) {
            $search = $_POST['search'];
            $sql = "SELECT bookID, bookname, author_name, publisher, quantity FROM project WHERE bookname LIKE '%$search%'";
        } else {
            $sql = 'SELECT bookID, bookname, author_name, publisher, quantity FROM project';
        }
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr><td>" . $row['bookID'] . "</td><td>" . $row['bookname'] . "</td><td>" . $row['author_name']  . "</td><td>" . $row['publisher']."</td><td>" . $row['quantity'] . "</td></tr>";
            }
        } else {
            echo "<tr><td colspan='5'>No results found</td></tr>";
        }
        $conn->close();
        ?>
    </table>
</body>
</html>