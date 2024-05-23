<?php
include('db_connection.php');

// Check if ProductIn_Id is set
if (isset($_REQUEST['id'])) {
  $id = $_REQUEST['id'];
//Product_in (id,barcode,supplier_id, quantity,cost,total,entry_date
  // Prepare statement with parameterized query to prevent SQL injection (security improvement)
  $stmt = $connection->prepare("SELECT * FROM product_in WHERE id=?");
  $stmt->bind_param("i", $id);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $a = $row['id'];
    $b = $row['barcode'];
    $c = $row['supplier_id'];
    $d = $row['quantity'];
    $e = $row['cost'];
    $f = $row['total'];
    $g = $row['entry_date'];
    
  } else {
    echo "Product in not found.";
  }
}

$stmt->close(); // Close the statement after use

?>

<!DOCTYPE html>
<html>
<head>
    <title>Update productIn</title>
 <!-- JavaScript validation and content load for update or modify data-->
    <script>
        function confirmUpdate() {
            return confirm('Are you sure you want to update this record?');
        }
    </script>
</head>
<body>
    <!-- Update products form -->
    <h2><u>Update Form of productIn</u></h2>
    <form method="POST" onsubmit="return confirmUpdate();">
    <label for="bcode">barcode:</label>
    <input type="text" name="bcode" value="<?php echo isset($b) ? $b : ''; ?>">
    <br><br>

    <label for="supid">supplier_id:</label>
    <input type="number" name="supid" value="<?php echo isset($c) ? $c : ''; ?>">
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

    <label for="entrydate">entry_date:</label>
    <input type="date" name="entrydate" value="<?php echo isset($g) ? $g : ''; ?>">
    <br><br>

    <input type="submit" name="up" value="Update">

  </form>
</body>
</html>

<?php
if (isset($_POST['up'])) {
  // Retrieve updated values from form
  $barcode = $_POST['bcode'];
  $supplier_id = $_POST['supid'];
  $quantity = $_POST['qty'];
  $cost = $_POST['cost'];
  $total = $_POST['ptotal'];
  $entry_date = $_POST['entrydate'];
//Product_in (id,barcode,supplier_id, quantity,cost,total,entry_date
  // Update the product_in in the database (prepared statement again for security)
  $stmt = $connection->prepare("UPDATE product_in SET barcode=?, supplier_id=?, quantity=?, cost=?, total=?, entry_date=? WHERE id=?");
  $stmt->bind_param("sissssi", $barcode, $supplier_id, $quantity, $cost,  $total, $entry_date, $id);
  $stmt->execute();

  // Redirect to product_in.php
  header('Location: product_in.php');
  exit(); // Ensure no other content is sent after redirection
}

// Close the connection (important to close after use)
mysqli_close($connection);
?>
