<?php
// Set page-specific variables
$page_title = "Projects";

// Include configuration
require_once 'config.php';

// Include header template
include 'includes/header.php';
?>

<main>
    <div class="container">
        <h1 class="page-title">My Projects</h1>
        
        <!-- Filter Buttons -->
        <div class="filter-buttons">
            <a href="projects.php" 
               class="filter-btn <?php echo !isset($_GET['status']) ? 'active' : ''; ?>">
                All Projects
            </a>
            <a href="projects.php?status=completed" 
               class="filter-btn <?php echo (isset($_GET['status']) && $_GET['status'] === 'completed') ? 'active' : ''; ?>">
                Completed
            </a>
            <a href="projects.php?status=in-progress" 
               class="filter-btn <?php echo (isset($_GET['status']) && $_GET['status'] === 'in-progress') ? 'active' : ''; ?>">
                In Progress
            </a>
            <a href="projects.php?status=planning" 
               class="filter-btn <?php echo (isset($_GET['status']) && $_GET['status'] === 'planning') ? 'active' : ''; ?>">
                Planning
            </a>
        </div>

        <!-- Projects Grid -->
        <div class="projects-grid">
            <?php
            // Filter projects based on status
            $filtered_projects = $projects;
            
            if (isset($_GET['status'])) {
                $filtered_projects = array_filter($projects, function($project) {
                    return $project['status'] === $_GET['status'];
                });
            }
            
            // Check if any projects match the filter
            if (count($filtered_projects) === 0): ?>
                <div style="text-align: center; padding: 40px; color: #666; grid-column: 1 / -1;">
                    <p style="font-size: 1.2em;">No projects found with this status.</p>
                </div>
            <?php else: ?>
                <?php foreach ($filtered_projects as $project): ?>
                    <div class="project-card">
                        <!-- Project Icon -->
                        <div class="project-icon"><?php echo $project['image']; ?></div>
                        
                        <!-- Project Title -->
                        <h3 class="project-title"><?php echo $project['title']; ?></h3>
                        
                        <!-- Project Description -->
                        <p class="project-description"><?php echo $project['description']; ?></p>
                        
                        <!-- Technologies -->
                        <div class="project-tech">
                            <?php foreach ($project['technologies'] as $tech): ?>
                                <span class="tech-tag"><?php echo $tech; ?></span>
                            <?php endforeach; ?>
                        </div>
                        
                        <!-- Status Badge -->
                        <div>
                            <?php
                            // Determine status class
                            $status_class = 'status-' . $project['status'];
                            $status_text = ucwords(str_replace('-', ' ', $project['status']));
                            ?>
                            <span class="project-status <?php echo $status_class; ?>">
                                <?php echo $status_text; ?>
                            </span>
                        </div>
                        
                        <!-- Project Date -->
                        <p style="margin-top: 15px; color: #999; font-size: 0.9em;">
                            📅 <?php echo date('F Y', strtotime($project['date'] . '-01')); ?>
                        </p>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</main>

<?php
// Include footer template
include 'includes/footer.php';
?>