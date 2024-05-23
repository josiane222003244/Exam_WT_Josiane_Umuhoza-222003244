<?php
// Check if the 'query' GET parameter is set
if (isset($_GET['query']) && !empty($_GET['query'])) {
    // Connection details
    include('db_connection.php');


    // Sanitize input to prevent SQL injection
    $searchTerm = $connection->real_escape_string($_GET['query']);

    // Queries for different tables
    $queries = [
        'category' => "SELECT name FROM category WHERE name LIKE '%$searchTerm%'",
        'product' => "SELECT id FROM product WHERE id LIKE '%$searchTerm%'",
        'Product_in' => "SELECT id FROM Product_in WHERE id LIKE '%$searchTerm%'",
        'product_out' => "SELECT id FROM product_out WHERE id LIKE '%$searchTerm%'",
        'shop' => "SELECT name FROM shop WHERE name LIKE '%$searchTerm%'",
    ];

    // Output search results
    echo "<h2><u>Search Results:</u></h2>";

    foreach ($queries as $table => $sql) {
        $result = $connection->query($sql);
        echo "<h3>Table of $table:</h3>";
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<p>" . $row[array_keys($row)[0]] . "</p>"; // Dynamic field extraction from result
            }
        } else {
            echo "<p>No results found in $table matching the search term: '$searchTerm'</p>";
        }
    }

    // Close the connection
    $connection->close();
} else {
    echo "<p>No search term was provided.</p>";
}
?>
