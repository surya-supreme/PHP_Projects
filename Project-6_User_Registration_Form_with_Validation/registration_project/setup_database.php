<?php
/**
 * Automatic Database Setup Script
 * Run this file ONCE to create the database and tables automatically
 */

// Database configuration
define('DB_HOST', 'localhost');
define('DB_USER', 'root');        // Change if your MySQL username is different
define('DB_PASS', '');            // Change if your MySQL has a password
define('DB_NAME', 'registration_db');

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Database Setup</title>
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
            margin: 15px 0;
        }
        .error {
            background: #f8d7da;
            border: 1px solid #f5c6cb;
            color: #721c24;
            padding: 15px;
            border-radius: 5px;
            margin: 15px 0;
        }
        .warning {
            background: #fff3cd;
            border: 1px solid #ffeeba;
            color: #856404;
            padding: 15px;
            border-radius: 5px;
            margin: 15px 0;
        }
        .info {
            background: #d1ecf1;
            border: 1px solid #bee5eb;
            color: #0c5460;
            padding: 15px;
            border-radius: 5px;
            margin: 15px 0;
        }
        .step {
            background: #f8f9fa;
            padding: 15px;
            margin: 10px 0;
            border-left: 4px solid #3498db;
            border-radius: 4px;
        }
        .btn {
            display: inline-block;
            padding: 12px 24px;
            background: #3498db;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            margin: 10px 5px;
            border: none;
            cursor: pointer;
            font-size: 16px;
        }
        .btn:hover {
            background: #2980b9;
        }
        .btn-success {
            background: #27ae60;
        }
        .btn-success:hover {
            background: #229954;
        }
        code {
            background: #f4f4f4;
            padding: 2px 6px;
            border-radius: 3px;
            font-family: monospace;
            color: #e74c3c;
        }
        pre {
            background: #2c3e50;
            color: #ecf0f1;
            padding: 15px;
            border-radius: 5px;
            overflow-x: auto;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🗄️ Automatic Database Setup</h1>
        
        <?php
        if (isset($_POST['setup_database'])) {
            echo "<h2>Running Setup...</h2>";
            
            try {
                // Step 1: Connect to MySQL without selecting database
                echo "<div class='step'><strong>Step 1:</strong> Connecting to MySQL server...</div>";
                $conn = new mysqli(DB_HOST, DB_USER, DB_PASS);
                
                if ($conn->connect_error) {
                    throw new Exception("Connection failed: " . $conn->connect_error);
                }
                echo "<div class='success'>✅ Connected to MySQL server successfully!</div>";
                
                // Step 2: Create database
                echo "<div class='step'><strong>Step 2:</strong> Creating database '<code>" . DB_NAME . "</code>'...</div>";
                $sql = "CREATE DATABASE IF NOT EXISTS " . DB_NAME;
                if ($conn->query($sql) === TRUE) {
                    echo "<div class='success'>✅ Database created successfully!</div>";
                } else {
                    throw new Exception("Error creating database: " . $conn->error);
                }
                
                // Step 3: Select database
                echo "<div class='step'><strong>Step 3:</strong> Selecting database...</div>";
                $conn->select_db(DB_NAME);
                echo "<div class='success'>✅ Database selected!</div>";
                
                // Step 4: Create users table
                echo "<div class='step'><strong>Step 4:</strong> Creating 'users' table...</div>";
                $sql = "CREATE TABLE IF NOT EXISTS users (
                    id INT(11) NOT NULL AUTO_INCREMENT,
                    username VARCHAR(50) NOT NULL UNIQUE,
                    email VARCHAR(100) NOT NULL UNIQUE,
                    password VARCHAR(255) NOT NULL,
                    full_name VARCHAR(100) NOT NULL,
                    phone VARCHAR(15) DEFAULT NULL,
                    date_of_birth DATE DEFAULT NULL,
                    gender ENUM('Male','Female','Other') DEFAULT NULL,
                    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                    last_login TIMESTAMP NULL DEFAULT NULL,
                    PRIMARY KEY (id)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
                
                if ($conn->query($sql) === TRUE) {
                    echo "<div class='success'>✅ Table 'users' created successfully!</div>";
                } else {
                    throw new Exception("Error creating table: " . $conn->error);
                }
                
                // Step 5: Create activity_log table
                echo "<div class='step'><strong>Step 5:</strong> Creating 'activity_log' table...</div>";
                $sql = "CREATE TABLE IF NOT EXISTS activity_log (
                    id INT(11) NOT NULL AUTO_INCREMENT,
                    user_id INT(11) NOT NULL,
                    action VARCHAR(100) NOT NULL,
                    ip_address VARCHAR(45) DEFAULT NULL,
                    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                    PRIMARY KEY (id),
                    KEY user_id (user_id),
                    CONSTRAINT activity_log_ibfk_1 FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
                
                if ($conn->query($sql) === TRUE) {
                    echo "<div class='success'>✅ Table 'activity_log' created successfully!</div>";
                } else {
                    throw new Exception("Error creating table: " . $conn->error);
                }
                
                // Step 6: Verify setup
                echo "<div class='step'><strong>Step 6:</strong> Verifying setup...</div>";
                $result = $conn->query("SHOW TABLES");
                $tables = [];
                while ($row = $result->fetch_array()) {
                    $tables[] = $row[0];
                }
                
                echo "<div class='info'>";
                echo "<strong>Database Information:</strong><br>";
                echo "Database Name: <code>" . DB_NAME . "</code><br>";
                echo "Tables Created: <code>" . implode(", ", $tables) . "</code><br>";
                echo "Total Tables: " . count($tables);
                echo "</div>";
                
                $conn->close();
                
                echo "<div class='success' style='font-size: 18px; margin-top: 20px;'>";
                echo "<strong>🎉 Setup Complete!</strong><br><br>";
                echo "Your database is now ready to use!<br>";
                echo "You can now proceed to register users.";
                echo "</div>";
                
                echo "<div style='text-align: center; margin-top: 20px;'>";
                echo "<a href='index.php' class='btn btn-success'>Go to Registration Form</a>";
                echo "<a href='test_connection.php' class='btn'>Test Connection</a>";
                echo "</div>";
                
            } catch (Exception $e) {
                echo "<div class='error'>";
                echo "<strong>❌ Setup Failed!</strong><br><br>";
                echo "Error: " . htmlspecialchars($e->getMessage());
                echo "</div>";
                
                echo "<div class='info'>";
                echo "<strong>Common Solutions:</strong><br>";
                echo "1. Make sure MySQL/MariaDB is running (check XAMPP/WAMP)<br>";
                echo "2. Verify database credentials in this file:<br>";
                echo "<pre>define('DB_HOST', '" . DB_HOST . "');\ndefine('DB_USER', '" . DB_USER . "');\ndefine('DB_PASS', '" . (empty(DB_PASS) ? '(empty)' : '****') . "');</pre>";
                echo "3. Try connecting manually: <code>mysql -u " . DB_USER . " -p</code><br>";
                echo "4. Check if port 3306 is being used by another service";
                echo "</div>";
                
                echo "<div style='text-align: center; margin-top: 20px;'>";
                echo "<form method='post'>";
                echo "<button type='submit' name='setup_database' class='btn'>Try Again</button>";
                echo "</form>";
                echo "</div>";
            }
            
        } else {
            // Show setup form
            ?>
            
            <div class="warning">
                <strong>⚠️ Before You Begin:</strong><br>
                Make sure MySQL/MariaDB is running! Check your XAMPP/WAMP control panel.
            </div>
            
            <div class="info">
                <strong>What This Script Does:</strong><br>
                1. Connects to your MySQL server<br>
                2. Creates the database '<code>registration_db</code>'<br>
                3. Creates the '<code>users</code>' table<br>
                4. Creates the '<code>activity_log</code>' table<br>
                5. Verifies everything is set up correctly
            </div>
            
            <div class="info">
                <strong>Current Configuration:</strong><br>
                Database Host: <code><?php echo DB_HOST; ?></code><br>
                Database User: <code><?php echo DB_USER; ?></code><br>
                Database Password: <code><?php echo empty(DB_PASS) ? '(empty)' : '(set)'; ?></code><br>
                Database Name: <code><?php echo DB_NAME; ?></code>
            </div>
            
            <div class="step">
                <strong>If your MySQL credentials are different:</strong><br>
                Edit the top of this file (<code>setup_database.php</code>) and change:
                <pre>define('DB_USER', 'root');  // Your MySQL username
define('DB_PASS', '');       // Your MySQL password</pre>
            </div>
            
            <div style="text-align: center; margin-top: 30px;">
                <form method="post">
                    <button type="submit" name="setup_database" class="btn btn-success" style="font-size: 18px; padding: 15px 30px;">
                        🚀 Run Database Setup
                    </button>
                </form>
            </div>
            
            <div class="info" style="margin-top: 30px;">
                <strong>Alternative Manual Setup:</strong><br>
                If automatic setup doesn't work, you can set up manually:
                <ol>
                    <li>Open phpMyAdmin: <a href="http://localhost/phpmyadmin" target="_blank">http://localhost/phpmyadmin</a></li>
                    <li>Click "New" to create a database</li>
                    <li>Name it: <code>registration_db</code></li>
                    <li>Click "Create"</li>
                    <li>Click "Import" tab</li>
                    <li>Choose file: <code>database_setup.sql</code></li>
                    <li>Click "Go"</li>
                </ol>
            </div>
            
            <?php
        }
        ?>
    </div>
</body>
</html>
