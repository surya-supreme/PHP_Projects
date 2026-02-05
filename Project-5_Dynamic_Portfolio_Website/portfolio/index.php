<?php
// Set page-specific variables
$page_title = "Home";

// Include configuration
require_once 'config.php';

// Include header template
include 'includes/header.php';
?>

<main>
    <div class="container">
        <!-- Welcome Section -->
        <section class="section">
            <h1 class="page-title">Welcome to My Portfolio</h1>
            
            <div class="welcome-text">
                <p>
                    Hi! I'm <strong><?php echo $owner['name']; ?></strong>, 
                    a <strong><?php echo $owner['title']; ?></strong> based in 
                    <strong><?php echo $owner['location']; ?></strong>. 
                    I build dynamic web applications using modern technologies.
                </p>
            </div>

            <!-- Quick Stats -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon">💼</div>
                    <div class="stat-value"><?php echo count($projects); ?></div>
                    <div class="stat-label">Projects</div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-icon">🚀</div>
                    <div class="stat-value">
                        <?php 
                        $completed = array_filter($projects, function($p) { 
                            return $p['status'] === 'completed'; 
                        });
                        echo count($completed);
                        ?>
                    </div>
                    <div class="stat-label">Completed</div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-icon">⚡</div>
                    <div class="stat-value"><?php echo count($skills); ?></div>
                    <div class="stat-label">Skills</div>
                </div>
            </div>
        </section>

        <!-- Skills Section -->
        <section class="section">
            <h2>🎯 My Skills</h2>
            <div class="skills-grid">
                <?php foreach ($skills as $skill): ?>
                    <div class="skill-item">
                        <div class="skill-header">
                            <span class="skill-name"><?php echo $skill['name']; ?></span>
                            <span class="skill-percent"><?php echo $skill['level']; ?>%</span>
                        </div>
                        <div class="progress-bar">
                            <div class="progress-fill" 
                                 style="width: <?php echo $skill['level']; ?>%; 
                                        background: <?php echo $skill['color']; ?>;">
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>
    </div>
</main>

<?php
// Include footer template
include 'includes/footer.php';
?>