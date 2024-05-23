<?php
include('db_connection.php');

// Check if shop_Id is set
if (isset($_REQUEST['id'])) {
  $id = $_REQUEST['id'];
//shop (id,name,address, created_at
  // Prepare statement with parameterized query to prevent SQL injection (security improvement)
  $stmt = $connection->prepare("SELECT * FROM shop WHERE id=?");
  $stmt->bind_param("i", $id);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $a = $row['id'];
    $b = $row['name'];
    $c = $row['address'];
    $d = $row['created_at'];

  } else {
    echo "shop not found.";
  }
}

$stmt->close(); // Close the statement after use

?>

<!DOCTYPE html>
<html>
<head>
    <title>Update shop</title>
 <!-- JavaScript validation and content load for update or modify data-->
    <script>
        function confirmUpdate() {
            return confirm('Are you sure you want to update this record?');
        }
    </script>
</head>
<body>
    <!-- Update shop form -->
    <h2><u>Update Form of shop</u></h2>
    <form method="POST" onsubmit="return confirmUpdate();">
    <label for="shopname">name:</label>
    <input type="text" name="shopname" value="<?php echo isset($b) ? $b : ''; ?>">
    <br><br>

    <label for="adrs">address:</label>
    <input type="text" name="adrs" value="<?php echo isset($c) ? $c : ''; ?>">
    <br><br>

    <label for="crtid">created_at:</label>
    <input type="date" name="crtid" value="<?php echo isset($d) ? $d : ''; ?>">
    <br><br>
    
    <input type="submit" name="up" value="Update">

  </form>
</body>
</html>

<?php
if (isset($_POST['up'])) {
  // Retrieve updated values from form
  $name = $_POST['shopname'];
  $address = $_POST['adrs'];
  $created_at = $_POST['crtid'];
//shop (id,name,address, created_at
  // Update the shop in the database (prepared statement again for security)
  $stmt = $connection->prepare("UPDATE shop SET name=?, address=?, created_at=? WHERE id=?");
  $stmt->bind_param("sssi", $name, $address, $created_at, $id);
  $stmt->execute();

  // Redirect to shop.php
  header('Location: shop.php');
  exit(); // Ensure no other content is sent after redirection
}

// Close the connection (important to close after use)
mysqli_close($connection);
?>
