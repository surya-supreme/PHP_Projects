<!DOCTYPE html>
<html>
<head>
    <title>Temperature Converter</title>
    <style>
        body {
            font-family: 'Courier New', monospace;
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background-color: #f5f5f5;
        }
        .container {
            background-color: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        h2 {
            text-align: center;
            color: #333;
        }
        label {
            display: inline-block;
            width: 150px;
            margin-bottom: 10px;
        }
        input, select {
            padding: 8px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
            width: 200px;
        }
        button {
            padding: 10px 20px;
            margin-right: 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-weight: bold;
        }
        button[type="submit"] {
            background-color: #4CAF50;
            color: white;
        }
        button[type="button"] {
            background-color: #f44336;
            color: white;
        }
        button:hover {
            opacity: 0.8;
        }
        .result {
            margin-top: 20px;
            padding: 20px;
            background-color: #f9f9f9;
            border-left: 4px solid #4CAF50;
        }
        .error {
            margin-top: 20px;
            padding: 20px;
            background-color: #ffe6e6;
            border-left: 4px solid #f44336;
            color: #d32f2f;
        }
        .result h3, .error h3 {
            margin-top: 0;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Temperature Converter</h2>
    
    <form method="POST" action="">
        <label>Enter Temperature:</label>
        <input type="number" name="temperature" step="any" required>
        <br>

        <label>Enter unit (C/F/K):</label>
        <select name="unit" required>
            <option value="">Select Unit</option>
            <option value="C">C</option>
            <option value="F">F</option>
            <option value="K">K</option>
        </select>
        <br><br>

        <button type="submit" name="convert">Convert</button>
        <button type="button" onclick="window.location.href='<?php echo $_SERVER['PHP_SELF']; ?>'">Clear</button>
    </form>

<?php
// ==========================================
// CONVERSION FUNCTIONS
// ==========================================

function celsiusToFahrenheit($celsius) {
    return ($celsius * 9/5) + 32;
}

function celsiusToKelvin($celsius) {
    return $celsius + 273.15;
}

function fahrenheitToCelsius($fahrenheit) {
    return ($fahrenheit - 32) * 5/9;
}

function fahrenheitToKelvin($fahrenheit) {
    return ($fahrenheit - 32) * 5/9 + 273.15;
}

function kelvinToCelsius($kelvin) {
    return $kelvin - 273.15;
}

function kelvinToFahrenheit($kelvin) {
    return ($kelvin - 273.15) * 9/5 + 32;
}

// ==========================================
// VALIDATION FUNCTIONS
// ==========================================

function isValidTemperature($value) {
    return is_numeric($value);
}

function isValidUnit($unit) {
    $unit = strtoupper(trim($unit));
    return in_array($unit, ['C', 'F', 'K']);
}

function isAboveAbsoluteZero($temperature, $unit) {
    $unit = strtoupper($unit);
    
    switch ($unit) {
        case 'C':
            return $temperature >= -273.15;
        case 'F':
            return $temperature >= -459.67;
        case 'K':
            return $temperature >= 0;
        default:
            return false;
    }
}

// ==========================================
// UTILITY FUNCTIONS
// ==========================================

function formatTemperature($temperature, $unit, $decimals = 2) {
    $unit = strtoupper($unit);
    $value = number_format($temperature, $decimals);
    
    if ($unit == 'K') {
        return $value . 'K';
    } else {
        return $value . '°' . $unit;
    }
}

// ==========================================
// MAIN CONVERSION FUNCTION
// ==========================================

function convertTemperature($temperature, $fromUnit) {
    $fromUnit = strtoupper($fromUnit);
    
    // Convert to Celsius first
    switch ($fromUnit) {
        case 'C':
            $celsius = $temperature;
            break;
        case 'F':
            $celsius = fahrenheitToCelsius($temperature);
            break;
        case 'K':
            $celsius = kelvinToCelsius($temperature);
            break;
        default:
            return null;
    }
    
    // Convert from Celsius to all units
    return [
        'celsius' => $celsius,
        'fahrenheit' => celsiusToFahrenheit($celsius),
        'kelvin' => celsiusToKelvin($celsius)
    ];
}

// ==========================================
// PROCESS FORM SUBMISSION
// ==========================================

if (isset($_POST['convert'])) {
    
    $temperature = $_POST['temperature'];
    $unit = $_POST['unit'];
    
    // Validate temperature
    if (!isValidTemperature($temperature)) {
        echo '<div class="error">';
        echo '<h3>❌ Error: Please enter a valid number!</h3>';
        echo '</div>';
    }
    // Validate unit
    elseif (!isValidUnit($unit)) {
        echo '<div class="error">';
        echo '<h3>❌ Error: Please enter C, F, or K!</h3>';
        echo '</div>';
    }
    // Check for absolute zero violation
    elseif (!isAboveAbsoluteZero($temperature, $unit)) {
        echo '<div class="error">';
        echo '<h3>❌ Error: Temperature is below absolute zero!</h3>';
        echo '<p><strong>Minimum values:</strong></p>';
        echo '<ul>';
        echo '<li>Celsius: -273.15°C</li>';
        echo '<li>Fahrenheit: -459.67°F</li>';
        echo '<li>Kelvin: 0K</li>';
        echo '</ul>';
        echo '</div>';
    }
    // All validations passed - convert temperature
    else {
        $unit = strtoupper(trim($unit));
        $conversions = convertTemperature($temperature, $unit);
        
        echo '<div class="result">';
        echo '<h3>=== Temperature Converter ===</h3>';
        echo '<p><strong>Input:</strong> ' . formatTemperature($temperature, $unit) . '</p>';
        echo '<h4>Conversions:</h4>';
        echo '<p>&nbsp;&nbsp;Celsius:&nbsp;&nbsp;&nbsp;&nbsp;' . formatTemperature($conversions['celsius'], 'C') . '</p>';
        echo '<p>&nbsp;&nbsp;Fahrenheit: ' . formatTemperature($conversions['fahrenheit'], 'F') . '</p>';
        echo '<p>&nbsp;&nbsp;Kelvin:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . formatTemperature($conversions['kelvin'], 'K') . '</p>';
        echo '</div>';
    }
}
?>

</div>

</body>
</html>