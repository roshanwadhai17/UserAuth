<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Student Data</title>
<style>
    table {
        border-collapse: collapse;
        width: 100%;
    }

    th, td {
        border: 1px solid #dddddd;
        text-align: left;
        padding: 8px;
    }

    th {
        background-color: #f2f2f2;
    }

    form {
        margin-bottom: 20px;
    }

    input[type="text"], input[type="number"], input[type="submit"] {
        margin: 5px;
        padding: 5px;
    }
</style>
</head>
<body>

<h2>Insert Student Data</h2>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
    <label for="name">Name:</label>
    <input type="text" id="name" name="name" required><br>
    <label for="age">Age:</label>
    <input type="number" id="age" name="age" required><br>
    <label for="grade">Grade:</label>
    <input type="text" id="grade" name="grade" required><br>
    <input type="submit" value="Submit">
</form>

<h2>Search Student Data</h2>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="get">
    <label for="search">Search:</label>
    <input type="text" id="search" name="search"><br>
    <input type="submit" value="Search">
</form>

<h2>Student Data</h2>
<table>
    <thead>
        <tr>
            <th>Name</th>
            <th>Age</th>
            <th>Grade</th>
        </tr>
    </thead>
    <tbody>
        <?php
        // Database connection parameters
        $servername = "localhost";
        $username = "root";
        $password = "";
        $db_name = "db";
        $conn = new mysqli($servername, $username, $password, $db_name, 3307);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Retrieve form data and insert into database
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $name = $_POST['name'];
            $age = $_POST['age'];
            $grade = $_POST['grade'];

            $sql = "INSERT INTO students (name, age, grade) VALUES ('$name', $age, '$grade')";
            if ($conn->query($sql) === TRUE) {
                echo "New record created successfully";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }

        }

        // Fetch and display student data from the database based on search query
        $search = isset($_GET['search']) ? $_GET['search'] : '';
        $sql = "SELECT * FROM students WHERE name LIKE '%$search%' OR age LIKE '%$search%' OR grade LIKE '%$search%'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // Output data of each row
            while($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["name"] . "</td>";
                echo "<td>" . $row["age"] . "</td>";
                echo "<td>" . $row["grade"] . "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='3'>0 results</td></tr>";
        }

        // Close connection
        $conn->close();
        ?>
    </tbody>
</table>

</body>
</html>


