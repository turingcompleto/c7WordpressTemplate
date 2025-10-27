<!-- Footer -->
<footer class="site-footer">
    <div class="footer-content">
        
        <!-- Contact Info -->
        <?php if (is_active_sidebar('footer-1')) : ?>
            <?php dynamic_sidebar('footer-1'); ?>
        <?php else : ?>
            <div class="footer-section">
                <h3><?php _e('Contact', 'asmobius'); ?></h3>
                <ul>
                    <li><a href="mailto:info@example.com">info@example.com</a></li>
                    <li><a href="tel:+123456789">+1 234 567 89</a></li>
                </ul>
            </div>
        <?php endif; ?>

        <!-- Quick Links -->
        <?php if (is_active_sidebar('footer-2')) : ?>
            <?php dynamic_sidebar('footer-2'); ?>
        <?php else : ?>
            <div class="footer-section">
                <h3><?php _e('Links', 'asmobius'); ?></h3>
                <ul>
                    <li><a href="<?php echo home_url('/'); ?>">Home</a></li>
                    <li><a href="<?php echo get_post_type_archive_link('project'); ?>">Works</a></li>
                    <li><a href="<?php echo home_url('/about'); ?>">About</a></li>
                    <li><a href="<?php echo home_url('/contact'); ?>">Contact</a></li>
                </ul>
            </div>
        <?php endif; ?>

        <!-- Social Media -->
        <?php if (is_active_sidebar('footer-3')) : ?>
            <?php dynamic_sidebar('footer-3'); ?>
        <?php else : ?>
            <div class="footer-section">
                <h3><?php _e('Follow', 'asmobius'); ?></h3>
                <ul>
                    <li><a href="#" target="_blank" rel="noopener">Instagram</a></li>
                    <li><a href="#" target="_blank" rel="noopener">Facebook</a></li>
                    <li><a href="#" target="_blank" rel="noopener">LinkedIn</a></li>
                </ul>
            </div>
        <?php endif; ?>
        
    </div>

    <div class="footer-bottom">
        <p>&copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?>. All rights reserved.</p>
        <div class="footer-links">
            <a href="<?php echo home_url('/privacy-policy'); ?>">Privacy</a>
            <a href="<?php echo home_url('/terms'); ?>">Terms</a>
        </div>
    </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>