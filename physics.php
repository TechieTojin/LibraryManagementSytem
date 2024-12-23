<!DOCTYPE html>
<html lang="en">
<head>
    <title>Physics Books</title>
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
            padding: 5px;
            font-size: 16px;
            border: 3px solid black;
            border-radius: 10px;
            font-family: Arial, sans-serif; /* Set font for input elements */
        }
    </style>
</head>
<body>
    <h1><strong style="color: black;">Physics Books</strong></h1>

    <!-- Search Box -->
    <form method="post">
        <input type="text" name="search" placeholder="Search by Book Name">
        <input type="submit" value="Search">
    </form>

    <table>
        <tr>
            <th>Book ID</th>
            <th>Book Name</th>
            <th>Author Name</th>
            <th>Publisher</th>
            <th>Quantity</th>
        </tr>
        <?php
        $conn = mysqli_connect("localhost", "root", "", "physic_books");
        if ($conn->connect_error) {
            die("Failed to connect: " . $conn->connect_error);
        }

        if(isset($_POST['search'])) {
            $search = $_POST['search'];
            $sql = "SELECT book_ID, bookname, author_name, publisher, quantity FROM project WHERE bookname LIKE '%$search%'";
        } else {
            $sql = 'SELECT book_ID, bookname, author_name, publisher, quantity FROM project';
        }

        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr><td>" . $row['book_ID'] . "</td><td>" . $row['bookname'] . "</td><td>" . $row['author_name'] . "</td><td>" . $row['publisher'] . "</td><td>" . $row['quantity'] . "</td></tr>";
            }
        } else {
            echo "<tr><td colspan='5'>No results found</td></tr>";
        }

        $conn->close();
        ?>
    </table>
</body>
</html>
