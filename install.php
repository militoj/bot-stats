<?php
$servername = "192.168.0.47";
$username = "root";
$password = "BPS4mysql";
$dbname = "bps";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT Super_Origin.Name, Super_Origin.City, Super_Origin.State, super_heroes.Awesome FROM Super_Origin join super_heroes on super_heroes.name=Super_Origin.name";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo "Name: " . $row["Name"]. " - Location: " . $row["City"]. ", " . $row["State"]. "Are they awesome though?". $row["Awesome"]. "<br>";
    }
} else {
    echo "0 results";
}
$conn->close();
?>
