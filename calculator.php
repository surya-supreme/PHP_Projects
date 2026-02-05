<!DOCTYPE html>
<html>
<head>
    <title>Simple Calculator</title>
</head>
<body>
<h2>Simple Calculator</h2>
<form method="POST" action="">
    <!-- First Number -->
    <label>First Number:</label>
    <input type="number" name="num1" step="any" required>
    <br><br>
    <!-- Operation Selector -->
    <label>Operation:</label>
    <select name="operation">
        <option value="add">Addition</option>
        <option value="subtract">Subtraction</option>
        <option value="multiply">Multiplication</option>
        <option value="divide">Division</option>
    </select>
    <br><br>
    <!-- Second Number -->
    <label>Second Number:</label>
    <input type="number" name="num2" step="any" required>
    <br><br>
    <!-- Submit Button -->
    <button type="submit" name="calculate">Calculate</button>
    <button type="button" onclick="window.location.href='<?php echo $_SERVER['PHP_SELF']; ?>'">Clear</button>
</form>
<?php
if (isset($_POST['calculate'])) {
    $num1 = $_POST['num1'];
    $num2 = $_POST['num2'];
    $operation = $_POST['operation'];
    if ($operation == "add") {
        $result = $num1 + $num2;
        echo "<h3>Result: $num1 + $num2 = $result</h3>";
    }
    elseif ($operation == "subtract") {
        $result = $num1 - $num2;
        echo "<h3>Result: $num1 - $num2 = $result</h3>";
    }
    elseif ($operation == "multiply") {
        $result = $num1 * $num2;
        echo "<h3>Result: $num1 × $num2 = $result</h3>";
    }
    elseif ($operation == "divide") {
        if ($num2 != 0) {
            $result = $num1 / $num2;
            echo "<h3>Result: $num1 / $num2 = $result</h3>";
        } else {
            echo "<h3>Error: Cannot divide by zero!</h3>";
        }
    }
}
?>
</body>
</html>