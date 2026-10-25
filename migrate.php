<?php
require 'config.php';

echo "<h2>Database Migration Tool</h2>";

try {
    // 1. Create Table if not exists
    $createTableSql = "CREATE TABLE IF NOT EXISTS users (
        id INT(11) AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(50) NOT NULL UNIQUE,
        email VARCHAR(100) NOT NULL UNIQUE,
        password VARCHAR(255) NOT NULL,
        full_name VARCHAR(100),
        phone VARCHAR(20),
        address TEXT,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

    $pdo->exec($createTableSql);
    echo "<p style='color:green;'>✓ Table 'users' is up to date.</p>";

    // 2. Dynamic Column Updates
    // Define the columns that SHOULD exist in the table
    $requiredColumns = [
        'username' => 'VARCHAR(50) NOT NULL',
        'email'    => 'VARCHAR(100) NOT NULL',
        'password' => 'VARCHAR(255) NOT NULL',
        'full_name'=> 'VARCHAR(100)',
        'phone'    => 'VARCHAR(20)',
        'address'  => 'TEXT',
        'created_at' => 'TIMESTAMP DEFAULT CURRENT_TIMESTAMP'
    ];

    // Fetch current columns from the database
    $stmt = $pdo->query("DESCRIBE users");
    $currentColumns = $stmt->fetchAll(PDO::FETCH_COLUMN);

    foreach ($requiredColumns as $column => $definition) {
        if (!in_array($column, $currentColumns)) {
            echo "<p style='color:orange;'>Updating: Adding missing column $column...</p>";
            $pdo->exec("ALTER TABLE users ADD COLUMN $column $definition");
            echo "<p style='color:green;'>✓ Added $column successfully.</p>";
        }
    }

    echo "<p><strong>Migration completed successfully!</strong></p>";
    echo "<p><a href='login.php'>Go to Login Page</a></p>";

} catch (PDOException $e) {
    echo "<p style='color:red;'>Migration Error: " . $e->getMessage() . "</p>";
}
?>
