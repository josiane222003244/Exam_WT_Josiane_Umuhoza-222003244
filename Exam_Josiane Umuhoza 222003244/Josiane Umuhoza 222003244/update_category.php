<?php
include('db_connection.php');

// Check if category_Id is set
if (isset($_REQUEST['id'])) {
  $id = $_REQUEST['id'];
//category (id,name, description,created_at
  // Prepare statement with parameterized query to prevent SQL injection (security improvement)
  $stmt = $connection->prepare("SELECT * FROM category WHERE id=?");
  $stmt->bind_param("i", $id);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $a = $row['id'];
    $b = $row['name'];
    $c = $row['description'];
    $d = $row['created_at'];

  } else {
    echo "category not found.";
  }
}

$stmt->close(); // Close the statement after use

?>

<!DOCTYPE html>
<html>
<head>
    <title>Update category</title>
 <!-- JavaScript validation and content load for update or modify data-->
    <script>
        function confirmUpdate() {
            return confirm('Are you sure you want to update this record?');
        }
    </script>
</head>
<body>
    <!-- Update category form -->
    <h2><u>Update Form of category</u></h2>
    <form method="POST" onsubmit="return confirmUpdate();">
    <label for="catname">name:</label>
    <input type="text" name="catname" value="<?php echo isset($b) ? $b : ''; ?>">
    <br><br>

    <label for="descrptn">description:</label>
    <input type="text" name="descrptn" value="<?php echo isset($c) ? $c : ''; ?>">
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
  $name = $_POST['catname'];
  $description = $_POST['descrptn'];
  $created_at = $_POST['crtid'];
//category (id,name, description,created_at
  // Update the category in the database (prepared statement again for security)
  $stmt = $connection->prepare("UPDATE category SET name=?, description=?, created_at=? WHERE  id=?");
  $stmt->bind_param("sssi", $name, $description, $created_at, $id);
  $stmt->execute();

  // Redirect to category.php
  header('Location: category.php');
  exit(); // Ensure no other content is sent after redirection
}

// Close the connection (important to close after use)
mysqli_close($connection);
?>
