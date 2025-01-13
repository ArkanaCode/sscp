<!-- footer.php -->

<footer>
    <div class="site-footer">
        <p>&copy; <?php echo date('Y'); ?> <?php bloginfo( 'name' ); ?>. All Rights Reserved.</p>
    </div>
    
    <?php wp_footer(); // Always include wp_footer() to ensure other hooks/scripts are included ?>

</footer>
</body>
</html>
