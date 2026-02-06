<?php
/**
 * Database Connection Test Script
 * Use this to verify your database setup is correct
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Database Connection Test</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background: #f5f5f5;
        }
        .container {
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        h1 {
            color: #2c3e50;
            border-bottom: 3px solid #3498db;
            padding-bottom: 10px;
        }
        .success {
            background: #d4edda;
            border: 1px solid #c3e6cb;
            color: #155724;
            padding: 15px;
            border-radius: 5px;
            margin: 10px 0;
        }
        .error {
            background: #f8d7da;
            border: 1px solid #f5c6cb;
            color: #721c24;
            padding: 15px;
            border-radius: 5px;
            margin: 10px 0;
        }
        .info {
            background: #d1ecf1;
            border: 1px solid #bee5eb;
            color: #0c5460;
            padding: 15px;
            border-radius: 5px;
            margin: 10px 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        th, td {
            padding: 12px;
            text-align: left;
            border: 1px solid #ddd;
        }
        th {
            background: #3498db;
            color: white;
        }
        tr:nth-child(even) {
            background: #f9f9f9;
        }
        .back-link {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background: #3498db;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
        .back-link:hover {
            background: #2980b9;
        }
        code {
            background: #f4f4f4;
            padding: 2px 6px;
            border-radius: 3px;
            font-family: monospace;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🔍 Database Connection Test</h1>
        
        <?php
        require_once 'config.php';
        
        $allChecks = true;
        
        // Test 1: PHP Version
        echo "<h2>Test 1: PHP Version</h2>";
        $phpVersion = phpversion();
        if (version_compare($phpVersion, '7.4', '>=')) {
            echo "<div class='success'>✅ PHP Version: $phpVersion (Supported)</div>";
        } else {
            echo "<div class='error'>❌ PHP Version: $phpVersion (Requires 7.4 or higher)</div>";
            $allChecks = false;
        }
        
        // Test 2: Required Extensions
        echo "<h2>Test 2: Required PHP Extensions</h2>";
        $extensions = ['mysqli', 'session', 'json'];
        foreach ($extensions as $ext) {
            if (extension_loaded($ext)) {
                echo "<div class='success'>✅ Extension '$ext' is loaded</div>";
            } else {
                echo "<div class='error'>❌ Extension '$ext' is NOT loaded</div>";
                $allChecks = false;
            }
        }
        
        // Test 3: Database Connection
        echo "<h2>Test 3: Database Connection</h2>";
        try {
            $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
            
            if ($conn->connect_error) {
                throw new Exception($conn->connect_error);
            }
            
            echo "<div class='success'>✅ Successfully connected to database!</div>";
            echo "<div class='info'>";
            echo "<strong>Connection Details:</strong><br>";
            echo "Host: " . DB_HOST . "<br>";
            echo "User: " . DB_USER . "<br>";
            echo "Database: " . DB_NAME . "<br>";
            echo "Character Set: " . $conn->character_set_name();
            echo "</div>";
            
            // Test 4: Check if users table exists
            echo "<h2>Test 4: Database Tables</h2>";
            $result = $conn->query("SHOW TABLES LIKE 'users'");
            if ($result->num_rows > 0) {
                echo "<div class='success'>✅ Table 'users' exists</div>";
                
                // Test 5: Table structure
                echo "<h2>Test 5: Table Structure</h2>";
                $result = $conn->query("DESCRIBE users");
                if ($result->num_rows > 0) {
                    echo "<table>";
                    echo "<tr><th>Field</th><th>Type</th><th>Null</th><th>Key</th><th>Default</th><th>Extra</th></tr>";
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row['Field']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['Type']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['Null']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['Key']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['Default'] ?? 'NULL') . "</td>";
                        echo "<td>" . htmlspecialchars($row['Extra']) . "</td>";
                        echo "</tr>";
                    }
                    echo "</table>";
                    echo "<div class='success'>✅ Table structure is correct</div>";
                }
                
                // Test 6: Count existing users
                echo "<h2>Test 6: Existing Users</h2>";
                $result = $conn->query("SELECT COUNT(*) as count FROM users");
                $row = $result->fetch_assoc();
                $userCount = $row['count'];
                echo "<div class='info'>📊 Total registered users: <strong>" . $userCount . "</strong></div>";
                
                if ($userCount > 0) {
                    echo "<h3>Recent Users:</h3>";
                    $result = $conn->query("SELECT id, username, email, full_name, created_at FROM users ORDER BY id DESC LIMIT 5");
                    if ($result->num_rows > 0) {
                        echo "<table>";
                        echo "<tr><th>ID</th><th>Username</th><th>Email</th><th>Full Name</th><th>Created At</th></tr>";
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($row['id']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['username']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['full_name']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['created_at']) . "</td>";
                            echo "</tr>";
                        }
                        echo "</table>";
                    }
                }
                
            } else {
                echo "<div class='error'>❌ Table 'users' does NOT exist!</div>";
                echo "<div class='info'><strong>Solution:</strong> Import the <code>database_setup.sql</code> file using phpMyAdmin or MySQL command line.</div>";
                $allChecks = false;
            }
            
            // Test 7: Check other tables
            echo "<h2>Test 7: Additional Tables</h2>";
            $result = $conn->query("SHOW TABLES");
            if ($result->num_rows > 0) {
                echo "<div class='info'><strong>Available tables:</strong><br>";
                while ($row = $result->fetch_array()) {
                    echo "• " . $row[0] . "<br>";
                }
                echo "</div>";
            }
            
            $conn->close();
            
        } catch (Exception $e) {
            echo "<div class='error'>❌ Database Connection Failed!</div>";
            echo "<div class='error'><strong>Error:</strong> " . htmlspecialchars($e->getMessage()) . "</div>";
            echo "<div class='info'>";
            echo "<strong>Common Solutions:</strong><br>";
            echo "1. Make sure MySQL/MariaDB is running<br>";
            echo "2. Check database credentials in <code>config.php</code><br>";
            echo "3. Verify database '<code>" . DB_NAME . "</code>' exists<br>";
            echo "4. Try: <code>mysql -u " . DB_USER . " -p</code> to test manually<br>";
            echo "</div>";
            $allChecks = false;
        }
        
        // Final Summary
        echo "<h2>📋 Summary</h2>";
        if ($allChecks) {
            echo "<div class='success'>";
            echo "<h3>✅ All Tests Passed!</h3>";
            echo "<p>Your database is properly configured and ready to use.</p>";
            echo "<p>You can now proceed to test the registration form.</p>";
            echo "</div>";
        } else {
            echo "<div class='error'>";
            echo "<h3>⚠️ Some Tests Failed</h3>";
            echo "<p>Please fix the issues above before using the registration system.</p>";
            echo "<p>Check the <code>TROUBLESHOOTING.md</code> file for detailed solutions.</p>";
            echo "</div>";
        }
        ?>
        
        <div style="margin-top: 30px; text-align: center;">
            <a href="index.php" class="back-link">← Back to Registration Form</a>
            <a href="README.md" class="back-link" style="background: #27ae60;">📖 Read Documentation</a>
        </div>
    </div>
</body>
</html>
