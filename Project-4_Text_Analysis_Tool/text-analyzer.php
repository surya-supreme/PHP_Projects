<?php
// Function 1: Count Words
function countWords($text) {
    $text = trim($text);
    if (empty($text)) return 0;
    return str_word_count($text);
}

// Function 2: Count Characters
function countCharacters($text) {
    return [
        'with_spaces' => strlen($text),
        'without_spaces' => strlen(str_replace(' ', '', $text))
    ];
}

// Function 3: Count Sentences
function countSentences($text) {
    $count = preg_match_all('/[.!?]+/', $text);
    return $count > 0 ? $count : 1;
}

// Function 4: Count Paragraphs
function countParagraphs($text) {
    $paragraphs = preg_split('/\n\s*\n/', trim($text));
    return count(array_filter($paragraphs));
}

// Function 5: Average Word Length
function averageWordLength($text) {
    $words = str_word_count($text, 1);
    if (empty($words)) return 0;
    
    $totalLength = 0;
    foreach ($words as $word) {
        $totalLength += strlen($word);
    }
    
    return round($totalLength / count($words), 2);
}

// Function 6: Find Longest Word
function findLongestWord($text) {
    $words = str_word_count($text, 1);
    if (empty($words)) return '';
    
    $longest = '';
    foreach ($words as $word) {
        if (strlen($word) > strlen($longest)) {
            $longest = $word;
        }
    }
    return $longest;
}

// Function 7: Find Shortest Word
function findShortestWord($text) {
    $words = str_word_count($text, 1);
    if (empty($words)) return '';
    
    $shortest = $words[0];
    foreach ($words as $word) {
        if (strlen($word) < strlen($shortest)) {
            $shortest = $word;
        }
    }
    return $shortest;
}

// Function 8: Get Most Common Words
function getMostCommonWords($text, $limit = 5) {
    $words = str_word_count(strtolower($text), 1);
    
    // Remove common words
    $stopWords = ['the', 'a', 'an', 'and', 'or', 'but', 'in', 'on', 'at', 'to', 'for', 'of', 'with', 'is', 'was', 'are', 'be', 'this', 'that'];
    $words = array_diff($words, $stopWords);
    
    $wordCount = array_count_values($words);
    arsort($wordCount);
    
    return array_slice($wordCount, 0, $limit, true);
}

// Function 9: Calculate Reading Time
function calculateReadingTime($text) {
    $wordCount = countWords($text);
    $minutes = floor($wordCount / 200);
    $seconds = floor(($wordCount % 200) / (200 / 60));
    
    if ($minutes == 0) {
        return "$seconds seconds";
    } else {
        return "$minutes min $seconds sec";
    }
}

// Function 10: Extract Emails
function extractEmails($text) {
    $pattern = '/[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}/';
    preg_match_all($pattern, $text, $matches);
    return array_unique($matches[0]);
}

// Function 11: Extract URLs
function extractURLs($text) {
    $pattern = '/https?:\/\/[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}[^\s]*/';
    preg_match_all($pattern, $text, $matches);
    return array_unique($matches[0]);
}

// Function 12: Extract Hashtags
function extractHashtags($text) {
    $pattern = '/#[a-zA-Z0-9_]+/';
    preg_match_all($pattern, $text, $matches);
    return array_unique($matches[0]);
}

// Function 13: Extract Mentions
function extractMentions($text) {
    $pattern = '/@[a-zA-Z0-9_]+/';
    preg_match_all($pattern, $text, $matches);
    return array_unique($matches[0]);
}

// Handle Clear Button
if (isset($_POST['clear'])) {
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Text Analysis Tool</title>
    <style>
        /* Reset and Base Styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background: #f5f5f5;
            min-height: 100vh;
            padding: 20px;
            line-height: 1.6;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            background: white;
            border: 1px solid #ddd;
        }

        /* Header */
        header {
            background: #333;
            color: white;
            padding: 30px;
            text-align: center;
            border-bottom: 1px solid #ddd;
        }

        header h1 {
            font-size: 2em;
            margin-bottom: 10px;
        }

        header p {
            font-size: 1em;
        }

        /* Main Content */
        main {
            padding: 30px;
        }

        /* Form Styles */
        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            font-size: 1em;
            font-weight: bold;
            margin-bottom: 10px;
            color: #333;
        }

        .form-group textarea {
            width: 100%;
            padding: 10px;
            font-size: 1em;
            border: 1px solid #ccc;
            resize: vertical;
            font-family: Arial, sans-serif;
        }

        .form-group textarea:focus {
            outline: none;
            border-color: #666;
        }

        /* Button Styles */
        .button-group {
            display: flex;
            gap: 10px;
            margin-top: 20px;
        }

        .btn {
            padding: 12px 24px;
            font-size: 1em;
            border: 1px solid #ccc;
            cursor: pointer;
            font-weight: normal;
        }

        .btn-primary {
            background: #333;
            color: white;
            flex: 1;
        }

        .btn-primary:hover {
            background: #555;
        }

        .btn-secondary {
            background: #f5f5f5;
            color: #333;
        }

        .btn-secondary:hover {
            background: #e5e5e5;
        }

        /* Results Section */
        .results {
            margin-top: 40px;
        }

        .results h2 {
            font-size: 1.5em;
            color: #333;
            margin-bottom: 30px;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
        }

        /* Stats Grid */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 15px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: #f9f9f9;
            border: 1px solid #ddd;
            padding: 20px;
            text-align: center;
        }

        .stat-value {
            font-size: 2em;
            font-weight: bold;
            margin-bottom: 5px;
            color: #333;
        }

        .stat-label {
            font-size: 0.9em;
            color: #666;
        }

        /* Analysis Section */
        .analysis-section {
            background: #f9f9f9;
            padding: 20px;
            border: 1px solid #ddd;
            margin-bottom: 20px;
        }

        .analysis-section h3 {
            font-size: 1.2em;
            color: #333;
            margin-bottom: 15px;
            border-bottom: 1px solid #ddd;
            padding-bottom: 8px;
        }

        .info-box {
            background: white;
            padding: 15px;
            border: 1px solid #ddd;
        }

        .info-box p {
            margin: 10px 0;
            font-size: 1em;
        }

        .highlight {
            color: #333;
            font-weight: bold;
        }

        /* Word List */
        .word-list {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .word-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: white;
            padding: 12px;
            border: 1px solid #ddd;
        }

        .word-item .word {
            font-weight: bold;
            color: #333;
            font-size: 1em;
        }

        .word-item .count {
            background: #333;
            color: white;
            padding: 4px 12px;
            font-weight: bold;
        }

        /* Tags */
        .tags {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        .tag {
            display: inline-block;
            background: white;
            padding: 6px 12px;
            font-size: 0.9em;
            color: #333;
            border: 1px solid #ccc;
        }

        .tag-hashtag {
            background: #f0f0f0;
            border-color: #999;
        }

        .tag-mention {
            background: #f0f0f0;
            border-color: #999;
        }

        /* Footer */
        footer {
            background: #f9f9f9;
            padding: 20px;
            text-align: center;
            color: #666;
            border-top: 1px solid #ddd;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            header h1 {
                font-size: 1.5em;
            }
            
            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }
            
            .button-group {
                flex-direction: column;
            }
            
            main {
                padding: 20px;
            }
        }

        @media (max-width: 480px) {
            .stats-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <h1>Text Analysis Tool</h1>
            <p>Analyze your text and get detailed statistics</p>
        </header>

        <main>
            <!-- Text Input Form -->
            <form method="POST" action="">
                <div class="form-group">
                    <label for="text">Enter Your Text:</label>
                    <textarea 
                        name="text" 
                        id="text" 
                        rows="10" 
                        placeholder="Type or paste your text here...

Try including:
- Multiple paragraphs
- Email addresses (email@example.com)
- URLs (https://example.com)
- Hashtags (#coding)
- Mentions (@username)"
                        required
                    ><?php echo isset($_POST['text']) ? htmlspecialchars($_POST['text']) : ''; ?></textarea>
                </div>

                <div class="button-group">
                    <button type="submit" name="analyze" class="btn btn-primary">
                        Analyze Text
                    </button>
                    <button type="submit" name="clear" class="btn btn-secondary">
                        Clear
                    </button>
                </div>
            </form>

            <?php
            if (isset($_POST['analyze']) && !empty($_POST['text'])) {
                $text = $_POST['text'];
                
                // Get all statistics
                $wordCount = countWords($text);
                $chars = countCharacters($text);
                $sentences = countSentences($text);
                $paragraphs = countParagraphs($text);
                $avgWordLength = averageWordLength($text);
                $longestWord = findLongestWord($text);
                $shortestWord = findShortestWord($text);
                $commonWords = getMostCommonWords($text);
                $readingTime = calculateReadingTime($text);
                $emails = extractEmails($text);
                $urls = extractURLs($text);
                $hashtags = extractHashtags($text);
                $mentions = extractMentions($text);
                ?>

                <div class="results">
                    <h2>Analysis Results</h2>

                    <!-- Basic Statistics -->
                    <div class="stats-grid">
                        <div class="stat-card">
                            <div class="stat-value"><?php echo $wordCount; ?></div>
                            <div class="stat-label">Words</div>
                        </div>
                        
                        <div class="stat-card">
                            <div class="stat-value"><?php echo $chars['with_spaces']; ?></div>
                            <div class="stat-label">Characters</div>
                        </div>
                        
                        <div class="stat-card">
                            <div class="stat-value"><?php echo $sentences; ?></div>
                            <div class="stat-label">Sentences</div>
                        </div>
                        
                        <div class="stat-card">
                            <div class="stat-value"><?php echo $paragraphs; ?></div>
                            <div class="stat-label">Paragraphs</div>
                        </div>
                        
                        <div class="stat-card">
                            <div class="stat-value"><?php echo $readingTime; ?></div>
                            <div class="stat-label">Reading Time</div>
                        </div>
                        
                        <div class="stat-card">
                            <div class="stat-value"><?php echo $avgWordLength; ?></div>
                            <div class="stat-label">Avg Word Length</div>
                        </div>
                    </div>

                    <!-- Word Analysis -->
                    <div class="analysis-section">
                        <h3>Word Analysis</h3>
                        <div class="info-box">
                            <p><strong>Longest Word:</strong> <span class="highlight"><?php echo $longestWord; ?></span> (<?php echo strlen($longestWord); ?> letters)</p>
                            <p><strong>Shortest Word:</strong> <span class="highlight"><?php echo $shortestWord; ?></span> (<?php echo strlen($shortestWord); ?> letters)</p>
                            <p><strong>Characters (no spaces):</strong> <span class="highlight"><?php echo $chars['without_spaces']; ?></span></p>
                        </div>
                    </div>

                    <!-- Most Common Words -->
                    <?php if (!empty($commonWords)): ?>
                    <div class="analysis-section">
                        <h3>Most Common Words</h3>
                        <div class="word-list">
                            <?php foreach ($commonWords as $word => $count): ?>
                                <div class="word-item">
                                    <span class="word"><?php echo $word; ?></span>
                                    <span class="count"><?php echo $count; ?>x</span>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <?php endif; ?>

                    <!-- Email Addresses -->
                    <?php if (!empty($emails)): ?>
                    <div class="analysis-section">
                        <h3>Email Addresses Found (<?php echo count($emails); ?>)</h3>
                        <div class="tags">
                            <?php foreach ($emails as $email): ?>
                                <span class="tag"><?php echo $email; ?></span>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <?php endif; ?>

                    <!-- URLs -->
                    <?php if (!empty($urls)): ?>
                    <div class="analysis-section">
                        <h3>URLs Found (<?php echo count($urls); ?>)</h3>
                        <div class="tags">
                            <?php foreach ($urls as $url): ?>
                                <span class="tag"><?php echo $url; ?></span>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <?php endif; ?>

                    <!-- Hashtags -->
                    <?php if (!empty($hashtags)): ?>
                    <div class="analysis-section">
                        <h3>Hashtags Found (<?php echo count($hashtags); ?>)</h3>
                        <div class="tags">
                            <?php foreach ($hashtags as $hashtag): ?>
                                <span class="tag tag-hashtag"><?php echo $hashtag; ?></span>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <?php endif; ?>

                    <!-- Mentions -->
                    <?php if (!empty($mentions)): ?>
                    <div class="analysis-section">
                        <h3>Mentions Found (<?php echo count($mentions); ?>)</h3>
                        <div class="tags">
                            <?php foreach ($mentions as $mention): ?>
                                <span class="tag tag-mention"><?php echo $mention; ?></span>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
                
                <?php
            }
            ?>

        </main>

        <footer>
            <p>Created using PHP String Functions & Regex</p>
        </footer>
    </div>
</body>
</html>