<?php
session_start();

// If the user hasn't logged in, kick them back to the login page
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit;
}
// ... rest of your code ...


// 1. Connect to the database (Same as store_password.php)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ChronoPass"; // Make sure this matches your database name

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// 2. Get the data from the database
$sql = "SELECT website, username, password, content FROM pass_form"; // Ensure table name is correct
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Vault - ChronoPass</title>
    <link rel="stylesheet" href="style.css"> 
    <style>
        /* Add to style.css */
table {
    width: 90%;
    margin: 30px auto;
    border-collapse: collapse;
    box-shadow: 0 5px 15px rgba(0,0,0,0.1); /* Soft shadow makes it pop */
    border-radius: 10px; /* Rounded corners */
    overflow: hidden; /* Keeps corners rounded */
}

th {
    background-color: #007bff; /* Match your brand blue */
    color: white;
    text-transform: uppercase;
    font-size: 14px;
    letter-spacing: 1px;
    padding: 15px;
}

td {
    padding: 15px;
    border-bottom: 1px solid #eee;
    color: #555;
}

tr:hover {
    background-color: #f1f9ff; /* Highlights the row you are pointing at */
    transition: 0.2s;
}

/* Style that Delete button specifically */
a[href*="delete.php"] {
    background-color: #ffeff0;
    color: #d63384;
    padding: 5px 10px;
    border-radius: 5px;
    font-size: 12px;
    font-weight: bold;
}
    </style>
</head>
<body>

    <h1 style="text-align:center; color: white;">My Password Vault</h1>

    <table>
        <tr>
            <th>Website</th>
            <th>Username</th>
            <th>Password</th>
            <th>Content</th>
        </tr>
        
        <?php
        // 3. Loop through data and display in table
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row["website"]) . "</td>";
                echo "<td>" . htmlspecialchars($row["username"]) . "</td>";
                echo "<td>" . htmlspecialchars($row["password"]) . "</td>";
                echo "<td>" . htmlspecialchars($row["content"]) . "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='4'>No passwords saved yet</td></tr>";
        }
        $conn->close();
        ?>
    </table>

    <div style="text-align: center;">
        <a href="Home.html" style="color: white; text-decoration: underline;">Back to Home</a>
    </div>

</body>
</html>
