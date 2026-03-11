<footer class="site-footer">
    <div class="container">
        <div class="footer-inner">
            <p class="footer-copy">
                &copy; <?php echo date('Y'); ?>
                <a href="<?php echo esc_url(home_url('/')); ?>"><?php bloginfo('name'); ?></a>
                — Todos los derechos reservados.
            </p>
            <nav class="footer-links" aria-label="Legal">
                <a href="<?php echo esc_url(get_permalink(get_page_by_path('aviso-legal'))); ?>">Aviso legal</a>
                <a href="<?php echo esc_url(get_permalink(get_page_by_path('politica-de-privacidad'))); ?>">Privacidad</a>
                <a href="<?php echo esc_url(get_permalink(get_page_by_path('politica-de-cookies'))); ?>">Cookies</a>
            </nav>
        </div>
    </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
