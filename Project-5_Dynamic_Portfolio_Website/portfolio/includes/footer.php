<footer class="site-footer">
        <div class="container">
            <div class="footer-content">
                <!-- Contact Info -->
                <div class="footer-section">
                    <h3>Contact</h3>
                    <p>📧 <?php echo $owner['email']; ?></p>
                    <p>📱 <?php echo $owner['phone']; ?></p>
                    <p>📍 <?php echo $owner['location']; ?></p>
                </div>

                <!-- Quick Links -->
                <div class="footer-section">
                    <h3>Quick Links</h3>
                    <ul class="footer-links">
                        <?php foreach ($nav_items as $item): ?>
                            <li>
                                <a href="<?php echo $item['url']; ?>">
                                    <?php echo $item['icon'] . ' ' . $item['name']; ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>

                <!-- Social Media -->
                <div class="footer-section">
                    <h3>Connect</h3>
                    <div class="social-links">
                        <?php foreach ($social_links as $social): ?>
                            <a href="<?php echo $social['url']; ?>" 
                               class="social-link" 
                               target="_blank"
                               title="<?php echo $social['platform']; ?>">
                                <?php echo $social['icon']; ?>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

            <!-- Copyright -->
            <div class="footer-bottom">
                <p>&copy; <?php echo $current_year; ?> <?php echo $owner['name']; ?>. All rights reserved.</p>
                <p class="footer-credit">Built with PHP & ❤️</p>
            </div>
        </div>
    </footer>
</body>
</html>