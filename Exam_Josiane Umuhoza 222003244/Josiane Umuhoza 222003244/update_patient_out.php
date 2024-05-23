<?php
include('db_connection.php');

// Check if Productout_Id is set
if (isset($_REQUEST['id'])) {
  $id = $_REQUEST['id'];
//product_out (id,barcode,shop_id, quantity,cost,total,exit_date
  // Prepare statement with parameterized query to prevent SQL injection (security improvement)
  $stmt = $connection->prepare("SELECT * FROM product WHERE id=?");
  $stmt->bind_param("i", $id);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $a = $row['id'];
    $b = $row['barcode'];
    $c = $row['shop_id'];
    $d = $row['quantity'];
    $e = $row['cost'];
    $f = $row['total'];
    $g = $row['exit_date'];
    
  } else {
    echo "Product out not found.";
  }
}

$stmt->close(); // Close the statement after use

?>

<!DOCTYPE html>
<html>
<head>
    <title>Update productout</title>
 <!-- JavaScript validation and content load for update or modify data-->
    <script>
        function confirmUpdate() {
            return confirm('Are you sure you want to update this record?');
        }
    </script>
</head>
<body>
    <!-- Update products form -->
    <h2><u>Update Form of productout</u></h2>
    <form method="POST" onsubmit="return confirmUpdate();">
    <label for="bcode">barcode:</label>
    <input type="text" name="bcode" value="<?php echo isset($b) ? $b : ''; ?>">
    <br><br>

    <label for="shpid">shop_id:</label>
    <input type="number" name="shpid" value="<?php echo isset($c) ? $c : ''; ?>">
    <br><br>

    <label for="qty">quantity:</label>
    <input type="number" name="qty" value="<?php echo isset($d) ? $d : ''; ?>">
    <br><br>

    <label for="cost">cost:</label>
    <input type="number" name="cost" value="<?php echo isset($e) ? $e : ''; ?>">
    <br><br>

    <label for="ptotal">total:</label>
    <input type="number" name="ptotal" value="<?php echo isset($f) ? $f : ''; ?>">
    <br><br>

    <label for="extdate">exit_date:</label>
    <input type="date" name="extdate" value="<?php echo isset($g) ? $g : ''; ?>">
    <br><br>

    <input type="submit" name="up" value="Update">

  </form>
</body>
</html>

<?php
if (isset($_POST['up'])) {
  // Retrieve updated values from form
  $barcode = $_POST['bcode'];
  $shop_id = $_POST['shpid'];
  $quantity = $_POST['qty'];
  $cost = $_POST['cost'];
  $total = $_POST['ptotal'];
  $exit_date = $_POST['extdate'];
  
//product_out (id,barcode,shop_id, quantity,cost,total,exit_date
  // Update the product_out in the database (prepared statement again for security)
  $stmt = $connection->prepare("UPDATE product_out SET barcode=?, shop_id=?, quantity=?, cost=?, total=?, exit_date=? WHERE id=?");
  $stmt->bind_param("sissssi", $barcode, $supplier_id, $quantity, $cost,  $total, $entry_date, $id);
  $stmt->execute();

  // Redirect to product_out.php
  header('Location: product_out.php');
  exit(); // Ensure no other content is sent after redirection
}

// Close the connection (important to close after use)
mysqli_close($connection);
?>
