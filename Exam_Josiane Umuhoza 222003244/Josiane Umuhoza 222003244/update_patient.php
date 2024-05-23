<?php
include('db_connection.php');

// Check if Product_Id is set
if (isset($_REQUEST['id'])) {
  $id = $_REQUEST['id'];
//product (id,barcode,category_id, name,cost,quantity,total_cost,created_at
  // Prepare statement with parameterized query to prevent SQL injection (security improvement)
  $stmt = $connection->prepare("SELECT * FROM product WHERE id=?");
  $stmt->bind_param("i", $id);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $a = $row['id'];
    $b = $row['barcode'];
    $c = $row['category_id'];
    $d = $row['name'];
    $e = $row['cost'];
    $f = $row['quantity'];
    $g = $row['total_cost'];
    $h = $row['created_at'];
  } else {
    echo "Product not found.";
  }
}

$stmt->close(); // Close the statement after use

?>

<!DOCTYPE html>
<html>
<head>
    <title>Update products</title>
 <!-- JavaScript validation and content load for update or modify data-->
    <script>
        function confirmUpdate() {
            return confirm('Are you sure you want to update this record?');
        }
    </script>
</head>
<body>
    <!-- Update products form -->
    <h2><u>Update Form of products</u></h2>
    <form method="POST" onsubmit="return confirmUpdate();">
    <label for="bcode">barcode:</label>
    <input type="text" name="bcode" value="<?php echo isset($b) ? $b : ''; ?>">
    <br><br>

    <label for="catid">category_id:</label>
    <input type="number" name="catid" value="<?php echo isset($c) ? $c : ''; ?>">
    <br><br>

    <label for="pname">name:</label>
    <input type="text" name="pname" value="<?php echo isset($d) ? $d : ''; ?>">
    <br><br>

    <label for="cost">cost:</label>
    <input type="number" name="cost" value="<?php echo isset($e) ? $e : ''; ?>">
    <br><br>

    <label for="qty">quantity:</label>
    <input type="number" name="qty" value="<?php echo isset($f) ? $f : ''; ?>">
    <br><br>

    <label for="totcost">total_cost:</label>
    <input type="number" name="totcost" value="<?php echo isset($g) ? $g : ''; ?>">
    <br><br>

    <label for="crted_at">created_at:</label>
    <input type="date" name="crted_at" value="<?php echo isset($h) ? $h : ''; ?>">
    <br><br>
    <input type="submit" name="up" value="Update">

  </form>
</body>
</html>

<?php
if (isset($_POST['up'])) {
  // Retrieve updated values from form
  $barcode = $_POST['bcode'];
  $category_id, = $_POST['catid'];
  $name = $_POST['pname'];
  $cost = $_POST['cost'];
  $quantity = $_POST['qty'];
  $total_cost = $_POST['totcost'];
  $created_at = $_POST['crted_at'];

  // Update the product in the database (prepared statement again for security)
  $stmt = $connection->prepare("UPDATE product SET barcode=?, category_id=?, name=?, cost=?, quantity=?, total_cost=?, created_at=? WHERE  id=?");
  $stmt->bind_param("sisssssi", $barcode, $category_id, $name, $cost, $quantity, $total_cost, $created_at, $id);
  $stmt->execute();

  // Redirect to product.php
  header('Location: product.php');
  exit(); // Ensure no other content is sent after redirection
}

// Close the connection (important to close after use)
mysqli_close($connection);
?>
