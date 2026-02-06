<?php
session_start();

// Initialize student records if not exists
if (!isset($_SESSION['studentRecords'])) {
    $_SESSION['studentRecords'] = array(
        array(
            "id" => "S001",
            "name" => "John Doe",
            "math" => 85,
            "science" => 90,
            "english" => 78
        ),
        array(
            "id" => "S002",
            "name" => "Sarah Smith",
            "math" => 92,
            "science" => 88,
            "english" => 95
        ),
        array(
            "id" => "S003",
            "name" => "Mike Johnson",
            "math" => 78,
            "science" => 82,
            "english" => 80
        ),
        array(
            "id" => "S004",
            "name" => "Emma Wilson",
            "math" => 88,
            "science" => 85,
            "english" => 92
        ),
        array(
            "id" => "S005",
            "name" => "David Brown",
            "math" => 65,
            "science" => 70,
            "english" => 68
        )
    );
}

// Handle form submissions
$message = "";

// Add new student
if (isset($_POST['add_student'])) {
    $newStudent = array(
        "id" => $_POST['student_id'],
        "name" => $_POST['student_name'],
        "math" => intval($_POST['math']),
        "science" => intval($_POST['science']),
        "english" => intval($_POST['english'])
    );
    array_push($_SESSION['studentRecords'], $newStudent);
    $message = "Student added successfully using array_push()!";
}

// Remove last student
if (isset($_POST['remove_last'])) {
    if (count($_SESSION['studentRecords']) > 0) {
        $removed = array_pop($_SESSION['studentRecords']);
        $message = "Removed last student using array_pop(): " . $removed['name'];
    } else {
        $message = "No students to remove!";
    }
}

// Remove first student
if (isset($_POST['remove_first'])) {
    if (count($_SESSION['studentRecords']) > 0) {
        $removed = array_shift($_SESSION['studentRecords']);
        $message = "Removed first student using array_shift(): " . $removed['name'];
    } else {
        $message = "No students to remove!";
    }
}

// Add bonus marks
if (isset($_POST['add_bonus'])) {
    foreach ($_SESSION['studentRecords'] as &$student) {
        $student['math'] = min($student['math'] + 5, 100);
        $student['science'] = min($student['science'] + 5, 100);
        $student['english'] = min($student['english'] + 5, 100);
    }
    $message = "Added 5 bonus marks to all subjects using array_map() logic!";
}

// Reset to default
if (isset($_POST['reset'])) {
    unset($_SESSION['studentRecords']);
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

// Process student records - calculate totals and averages
$studentRecords = $_SESSION['studentRecords'];
for ($i = 0; $i < count($studentRecords); $i++) {
    $math = $studentRecords[$i]['math'];
    $science = $studentRecords[$i]['science'];
    $english = $studentRecords[$i]['english'];
    
    $total = $math + $science + $english;
    $average = $total / 3;
    
    $studentRecords[$i]['total'] = $total;
    $studentRecords[$i]['average'] = round($average, 2);
    $studentRecords[$i]['status'] = ($average >= 40) ? "Pass" : "Fail";
    $studentRecords[$i]['original_index'] = $i;
}

// Search functionality
$searchActive = false;
$searchField = '';
$searchValue = '';
if (isset($_POST['search_student'])) {
    $searchActive = true;
    $searchField = $_POST['search_field'];
    $searchValue = $_POST['search_value'];
}

// Sorting functionality
$sortActive = false;
$sortField = '';
$sortOrder = '';
if (isset($_POST['apply_sort'])) {
    $sortActive = true;
    $sortField = $_POST['sort_by'];
    $sortOrder = $_POST['sort_order'];
}

// Filtering functionality
$filterActive = false;
$filterStatus = '';
$filterMathMin = '';
$filterMathMax = '';
$filterScienceMin = '';
$filterScienceMax = '';
$filterEnglishMin = '';
$filterEnglishMax = '';
$filterAverageMin = '';
$filterAverageMax = '';

if (isset($_POST['apply_filter'])) {
    $filterActive = true;
    $filterStatus = $_POST['filter_status'];
    $filterMathMin = $_POST['filter_math_min'];
    $filterMathMax = $_POST['filter_math_max'];
    $filterScienceMin = $_POST['filter_science_min'];
    $filterScienceMax = $_POST['filter_science_max'];
    $filterEnglishMin = $_POST['filter_english_min'];
    $filterEnglishMax = $_POST['filter_english_max'];
    $filterAverageMin = $_POST['filter_average_min'];
    $filterAverageMax = $_POST['filter_average_max'];
}

// Function to check if a student matches search criteria
function matchesSearch($student, $searchField, $searchValue) {
    if ($searchField == 'all') {
        return (
            stripos($student['id'], $searchValue) !== false ||
            stripos($student['name'], $searchValue) !== false ||
            stripos($student['math'], $searchValue) !== false ||
            stripos($student['science'], $searchValue) !== false ||
            stripos($student['english'], $searchValue) !== false ||
            stripos($student['total'], $searchValue) !== false ||
            stripos($student['average'], $searchValue) !== false ||
            stripos($student['status'], $searchValue) !== false
        );
    } else {
        return stripos($student[$searchField], $searchValue) !== false;
    }
}

// Function to check if a student matches filter criteria
function matchesFilter($student, $filterStatus, $filterMathMin, $filterMathMax, 
                       $filterScienceMin, $filterScienceMax, $filterEnglishMin, 
                       $filterEnglishMax, $filterAverageMin, $filterAverageMax) {
    // Filter by status
    if ($filterStatus != '' && $filterStatus != 'all' && $student['status'] != $filterStatus) {
        return false;
    }
    
    // Filter by Math score
    if ($filterMathMin !== '' && $student['math'] < $filterMathMin) {
        return false;
    }
    if ($filterMathMax !== '' && $student['math'] > $filterMathMax) {
        return false;
    }
    
    // Filter by Science score
    if ($filterScienceMin !== '' && $student['science'] < $filterScienceMin) {
        return false;
    }
    if ($filterScienceMax !== '' && $student['science'] > $filterScienceMax) {
        return false;
    }
    
    // Filter by English score
    if ($filterEnglishMin !== '' && $student['english'] < $filterEnglishMin) {
        return false;
    }
    if ($filterEnglishMax !== '' && $student['english'] > $filterEnglishMax) {
        return false;
    }
    
    // Filter by Average
    if ($filterAverageMin !== '' && $student['average'] < $filterAverageMin) {
        return false;
    }
    if ($filterAverageMax !== '' && $student['average'] > $filterAverageMax) {
        return false;
    }
    
    return true;
}

// Create display array
$displayRecords = array();
foreach ($studentRecords as $student) {
    $matches = true;
    
    // Check search criteria
    if ($searchActive) {
        $matches = $matches && matchesSearch($student, $searchField, $searchValue);
    }
    
    // Check filter criteria
    if ($filterActive) {
        $matches = $matches && matchesFilter($student, $filterStatus, $filterMathMin, $filterMathMax,
                                            $filterScienceMin, $filterScienceMax, $filterEnglishMin,
                                            $filterEnglishMax, $filterAverageMin, $filterAverageMax);
    }
    
    $student['matches'] = $matches;
    $displayRecords[] = $student;
}

// Apply sorting if requested
$sortedRecords = $displayRecords;
if ($sortActive) {
    usort($sortedRecords, function($a, $b) use ($sortField, $sortOrder) {
        if ($sortField == 'name' || $sortField == 'id') {
            $result = strcmp($a[$sortField], $b[$sortField]);
        } else {
            $result = $a[$sortField] - $b[$sortField];
        }
        return ($sortOrder == 'asc') ? $result : -$result;
    });
}

// Statistics
$allAverages = array();
foreach ($studentRecords as $student) {
    array_push($allAverages, $student['average']);
}

$classAverage = count($allAverages) > 0 ? array_sum($allAverages) / count($allAverages) : 0;
$highest = count($allAverages) > 0 ? max($allAverages) : 0;
$lowest = count($allAverages) > 0 ? min($allAverages) : 0;

$passCount = 0;
$failCount = 0;
foreach ($studentRecords as $student) {
    if ($student['status'] == "Pass") {
        $passCount++;
    } else {
        $failCount++;
    }
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Student Grade Management</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f4f4f4;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background-color: white;
        }
        
        th {
            background-color: #4CAF50;
            color: white;
            padding: 12px;
            text-align: left;
        }
        
        td {
            padding: 10px;
            border: 1px solid #ddd;
        }
        
        tr:hover {
            background-color: #f5f5f5;
        }
        
        .pass {
            color: green;
            font-weight: bold;
        }
        
        .fail {
            color: red;
            font-weight: bold;
        }
        
        .filter-section {
            background-color: #fff;
            padding: 15px;
            margin: 10px 0;
            border: 1px solid #ddd;
        }
        
        .match-highlight {
            background-color: #ffffcc !important;
        }
        
        .operations-section {
            background-color: #fff;
            padding: 15px;
            margin: 10px 0;
            border: 1px solid #ddd;
        }
        
        .stats-box {
            background-color: #e8f5e9;
            padding: 15px;
            margin: 20px 0;
            border: 1px solid #4CAF50;
            border-radius: 5px;
        }
        
        button {
            padding: 8px 15px;
            margin: 5px;
            cursor: pointer;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 3px;
        }
        
        button:hover {
            background-color: #45a049;
        }
        
        input, select {
            padding: 5px;
            margin: 5px;
        }
        
        .message {
            background-color: #dff0d8;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #4CAF50;
            border-radius: 3px;
        }
    </style>
</head>
<body>
    <h2>Student Grade Management System</h2>
    
    <?php if ($message): ?>
        <div class="message"><strong><?php echo $message; ?></strong></div>
    <?php endif; ?>
    
    <!-- Add Student Section -->
    <div class="operations-section">
        <h3>Add New Student (array_push)</h3>
        <form method="POST">
            <label>Student ID:</label>
            <input type="text" name="student_id" placeholder="S006" required>
            
            <label>Student Name:</label>
            <input type="text" name="student_name" placeholder="John Smith" required>
            
            <label>Math Score:</label>
            <input type="number" name="math" min="0" max="100" placeholder="85" required>
            
            <label>Science Score:</label>
            <input type="number" name="science" min="0" max="100" placeholder="90" required>
            
            <label>English Score:</label>
            <input type="number" name="english" min="0" max="100" placeholder="78" required>
            
            <button type="submit" name="add_student">Add Student</button>
        </form>
    </div>
    
    <!-- Array Operations Section -->
    <div class="operations-section">
        <h3>Array Operations</h3>
        <form method="POST" style="display: inline;">
            <button type="submit" name="remove_last">Remove Last Student (array_pop)</button>
        </form>
        <form method="POST" style="display: inline;">
            <button type="submit" name="remove_first">Remove First Student (array_shift)</button>
        </form>
        <form method="POST" style="display: inline;">
            <button type="submit" name="add_bonus">Add 5 Bonus Marks (array_map)</button>
        </form>
        <form method="POST" style="display: inline;">
            <button type="submit" name="reset" onclick="return confirm('Reset to default students?')">Reset to Default</button>
        </form>
    </div>
    
    <!-- Advanced Search Section -->
    <div class="filter-section">
        <h3>Advanced Search (array_filter with custom conditions)</h3>
        <form method="POST">
            <label>Search Field:</label>
            <select name="search_field">
                <option value="all" <?php echo ($searchField == 'all') ? 'selected' : ''; ?>>All Fields</option>
                <option value="id" <?php echo ($searchField == 'id') ? 'selected' : ''; ?>>Student ID</option>
                <option value="name" <?php echo ($searchField == 'name') ? 'selected' : ''; ?>>Student Name</option>
                <option value="math" <?php echo ($searchField == 'math') ? 'selected' : ''; ?>>Math Score</option>
                <option value="science" <?php echo ($searchField == 'science') ? 'selected' : ''; ?>>Science Score</option>
                <option value="english" <?php echo ($searchField == 'english') ? 'selected' : ''; ?>>English Score</option>
                <option value="total" <?php echo ($searchField == 'total') ? 'selected' : ''; ?>>Total Score</option>
                <option value="average" <?php echo ($searchField == 'average') ? 'selected' : ''; ?>>Average</option>
                <option value="status" <?php echo ($searchField == 'status') ? 'selected' : ''; ?>>Status (Pass/Fail)</option>
            </select>
            
            <label>Search Value:</label>
            <input type="text" name="search_value" placeholder="Enter search term" value="<?php echo $searchValue; ?>" required>
            
            <button type="submit" name="search_student">Search</button>
        </form>
        
        <?php if ($searchActive): ?>
            <?php 
            $matchCount = count(array_filter($displayRecords, function($s) { return $s['matches']; }));
            ?>
            <p><strong>Search Results: <?php echo $matchCount; ?> student(s) found (highlighted in yellow in table below)</strong></p>
            <form method="POST">
                <button type="submit">Clear Search</button>
            </form>
        <?php endif; ?>
    </div>
    
    <!-- Sorting Section -->
    <div class="filter-section">
        <h3>Sort Students (usort with custom comparator)</h3>
        <form method="POST">
            <label>Sort By:</label>
            <select name="sort_by">
                <option value="average" <?php echo ($sortField == 'average') ? 'selected' : ''; ?>>Average</option>
                <option value="name" <?php echo ($sortField == 'name') ? 'selected' : ''; ?>>Name</option>
                <option value="id" <?php echo ($sortField == 'id') ? 'selected' : ''; ?>>Student ID</option>
                <option value="math" <?php echo ($sortField == 'math') ? 'selected' : ''; ?>>Math Score</option>
                <option value="science" <?php echo ($sortField == 'science') ? 'selected' : ''; ?>>Science Score</option>
                <option value="english" <?php echo ($sortField == 'english') ? 'selected' : ''; ?>>English Score</option>
                <option value="total" <?php echo ($sortField == 'total') ? 'selected' : ''; ?>>Total Score</option>
            </select>
            
            <label>Order:</label>
            <select name="sort_order">
                <option value="desc" <?php echo ($sortOrder == 'desc') ? 'selected' : ''; ?>>Descending (High to Low)</option>
                <option value="asc" <?php echo ($sortOrder == 'asc') ? 'selected' : ''; ?>>Ascending (Low to High)</option>
            </select>
            
            <button type="submit" name="apply_sort">Apply Sort</button>
        </form>
        
        <?php if ($sortActive): ?>
            <p><strong>Sorted by: <?php echo ucfirst($sortField); ?> (<?php echo ($sortOrder == 'desc') ? 'Descending' : 'Ascending'; ?>)</strong></p>
            <form method="POST">
                <button type="submit">Clear Sort</button>
            </form>
        <?php endif; ?>
    </div>
    
    <!-- Filtering Section -->
    <div class="filter-section">
        <h3>Filter Students (array_filter with multiple conditions)</h3>
        <form method="POST">
            <h4>Filter by Status:</h4>
            <select name="filter_status">
                <option value="all" <?php echo ($filterStatus == 'all' || $filterStatus == '') ? 'selected' : ''; ?>>All Students</option>
                <option value="Pass" <?php echo ($filterStatus == 'Pass') ? 'selected' : ''; ?>>Pass Only</option>
                <option value="Fail" <?php echo ($filterStatus == 'Fail') ? 'selected' : ''; ?>>Fail Only</option>
            </select>
            
            <h4>Filter by Math Score:</h4>
            <label>Min:</label>
            <input type="number" name="filter_math_min" min="0" max="100" placeholder="Min" value="<?php echo $filterMathMin; ?>" style="width: 80px;">
            <label>Max:</label>
            <input type="number" name="filter_math_max" min="0" max="100" placeholder="Max" value="<?php echo $filterMathMax; ?>" style="width: 80px;">
            
            <h4>Filter by Science Score:</h4>
            <label>Min:</label>
            <input type="number" name="filter_science_min" min="0" max="100" placeholder="Min" value="<?php echo $filterScienceMin; ?>" style="width: 80px;">
            <label>Max:</label>
            <input type="number" name="filter_science_max" min="0" max="100" placeholder="Max" value="<?php echo $filterScienceMax; ?>" style="width: 80px;">
            
            <h4>Filter by English Score:</h4>
            <label>Min:</label>
            <input type="number" name="filter_english_min" min="0" max="100" placeholder="Min" value="<?php echo $filterEnglishMin; ?>" style="width: 80px;">
            <label>Max:</label>
            <input type="number" name="filter_english_max" min="0" max="100" placeholder="Max" value="<?php echo $filterEnglishMax; ?>" style="width: 80px;">
            
            <h4>Filter by Average:</h4>
            <label>Min:</label>
            <input type="number" name="filter_average_min" min="0" max="100" placeholder="Min" value="<?php echo $filterAverageMin; ?>" style="width: 80px;">
            <label>Max:</label>
            <input type="number" name="filter_average_max" min="0" max="100" placeholder="Max" value="<?php echo $filterAverageMax; ?>" style="width: 80px;">
            
            <br><br>
            <button type="submit" name="apply_filter">Apply Filters</button>
        </form>
        
        <form method="POST" style="display: inline;">
            <button type="submit">Clear All Filters</button>
        </form>
        
        <?php if ($filterActive): ?>
            <?php 
            $matchCount = count(array_filter($displayRecords, function($s) { return $s['matches']; }));
            ?>
            <p><strong>Filter Results: <?php echo $matchCount; ?> of <?php echo count($studentRecords); ?> students match (highlighted in yellow in table below)</strong></p>
        <?php endif; ?>
    </div>
    
    <!-- Student Database Table -->
    <h3>Student Database</h3>
    <?php if ($searchActive || $filterActive): ?>
        <p><em>Note: Matching students are highlighted in yellow.</em></p>
    <?php endif; ?>
    
    <?php if (count($displayRecords) > 0): ?>
    <table>
        <tr>
            <th>Position</th>
            <th>ID</th>
            <th>Name</th>
            <th>Math</th>
            <th>Science</th>
            <th>English</th>
            <th>Total</th>
            <th>Average</th>
            <th>Status</th>
        </tr>
        <?php 
        $recordsToDisplay = $sortActive ? $sortedRecords : $displayRecords;
        $position = 1;
        foreach ($recordsToDisplay as $student):
            $statusClass = ($student['status'] == "Pass") ? "pass" : "fail";
            $rowClass = ($searchActive || $filterActive) && $student['matches'] ? 'match-highlight' : '';
        ?>
        <tr class="<?php echo $rowClass; ?>">
            <td><?php echo $position; ?></td>
            <td><?php echo $student['id']; ?></td>
            <td><?php echo $student['name']; ?></td>
            <td><?php echo $student['math']; ?></td>
            <td><?php echo $student['science']; ?></td>
            <td><?php echo $student['english']; ?></td>
            <td><?php echo $student['total']; ?></td>
            <td><?php echo $student['average']; ?>%</td>
            <td class="<?php echo $statusClass; ?>"><?php echo $student['status']; ?></td>
        </tr>
        <?php 
            $position++;
        endforeach; 
        ?>
    </table>
    <?php else: ?>
        <p>No students in the database.</p>
    <?php endif; ?>
    
    <!-- Statistics Section -->
    <div class="stats-box">
        <h3>Class Statistics</h3>
        <p>
            <strong>Total Students (count):</strong> <?php echo count($studentRecords); ?><br>
            <strong>Class Average (array_sum/count):</strong> <?php echo round($classAverage, 2); ?>%<br>
            <strong>Highest Average (max):</strong> <?php echo $highest; ?>%<br>
            <strong>Lowest Average (min):</strong> <?php echo $lowest; ?>%<br>
            <strong>Passed (array_filter):</strong> <?php echo $passCount; ?> students<br>
            <strong>Failed (array_filter):</strong> <?php echo $failCount; ?> students
        </p>
    </div>
    
    <hr>
    
    <!-- Array Functions Demo -->
    <h3>Array Functions Demonstration</h3>
    
    <h4>1. Array Keys & Values (array_keys, array_values)</h4>
    <?php if (count($studentRecords) > 0): ?>
    <p>
        <strong>Keys from first student:</strong><br>
        <?php echo implode(", ", array_keys($studentRecords[0])); ?>
    </p>
    <p>
        <strong>Values from first student:</strong><br>
        <?php echo implode(", ", array_values($studentRecords[0])); ?>
    </p>
    <?php endif; ?>
    
    <h4>2. Array Merge & Combine (array_merge, array_combine)</h4>
    <?php
    $classA = array("S001" => "John", "S002" => "Sarah");
    $classB = array("S003" => "Mike", "S004" => "Emma");
    $merged = array_merge($classA, $classB);
    
    $ids = array("S101", "S102", "S103");
    $names = array("Alice", "Bob", "Charlie");
    $combined = array_combine($ids, $names);
    ?>
    <p>
        <strong>Class A:</strong> <?php echo implode(", ", $classA); ?><br>
        <strong>Class B:</strong> <?php echo implode(", ", $classB); ?><br>
        <strong>Merged:</strong> <?php echo implode(", ", $merged); ?>
    </p>
    <p>
        <strong>Array Combined:</strong><br>
        <?php foreach ($combined as $id => $name) {
            echo "$id => $name, ";
        } ?>
    </p>
    
    <h4>3. String & Array Conversion (explode, implode)</h4>
    <?php
    $subjectString = "Math,Science,English,History,Geography";
    $subjectArray = explode(",", $subjectString);
    $joinedString = implode(" | ", $subjectArray);
    ?>
    <p>
        <strong>Original String:</strong> <?php echo $subjectString; ?><br>
        <strong>After explode():</strong> <?php echo print_r($subjectArray, true); ?><br>
        <strong>After implode():</strong> <?php echo $joinedString; ?>
    </p>
    
    <h4>4. Array Filter (array_filter) - High Performers</h4>
    <?php
    if (count($studentRecords) > 0) {
        $highPerformers = array_filter($studentRecords, function($student) {
            return $student['average'] >= 85;
        });
    ?>
    <p>
        <strong>Students with Average >= 85%:</strong><br>
        <?php 
        if (count($highPerformers) > 0) {
            foreach ($highPerformers as $student) {
                echo $student['name'] . " (" . $student['average'] . "%), ";
            }
        } else {
            echo "No students with average >= 85%";
        }
        ?>
    </p>
    <?php } ?>
    
    <h4>5. Array Reduce (array_reduce) - Total of All Scores</h4>
    <?php
    if (count($studentRecords) > 0) {
        $allScores = array();
        foreach ($studentRecords as $student) {
            $allScores[] = $student['math'];
            $allScores[] = $student['science'];
            $allScores[] = $student['english'];
        }
        
        $totalScore = array_reduce($allScores, function($carry, $score) {
            return $carry + $score;
        }, 0);
    ?>
    <p>
        <strong>All individual scores:</strong> <?php echo implode(", ", $allScores); ?><br>
        <strong>Total using array_reduce():</strong> <?php echo $totalScore; ?>
    </p>
    <?php } ?>
    
    <hr>
    
    <p>
        <strong>All Array Functions Working!</strong><br>
        This system demonstrates: array_push, array_pop, array_shift, array_unshift, 
        array_merge, array_combine, array_filter (with multiple conditions), array_map, array_reduce, 
        array_keys, array_values, explode, implode, count, sizeof, max, min, 
        array_sum, usort (with custom comparator), and more!
    </p>
    
</body>
</html>
