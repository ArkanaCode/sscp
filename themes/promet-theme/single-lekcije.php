<?php
get_header();
$user_id = get_current_user_id();
$lekcija_id = get_the_ID();  // Get the current lesson's ID
$finished = get_user_meta($user_id, 'finished_lekcija_' . $lekcija_id, true); // Check if the lesson is finished

// If the lesson is finished, the button will be green and disabled
$button_text = $finished ? 'Lekcija završena' : 'Završi lekciju';
$button_color = $finished ? 'green' : '#ff9900';
$disabled_attr = $finished ? 'disabled' : ''; // Disable the button if finished
?>

<!-- Button HTML -->
<button id="finish-lesson-btn" data-lekcija-id="<?php echo esc_attr($lekcija_id); ?>" style="background-color: <?php echo esc_attr($button_color); ?>" <?php echo esc_attr($disabled_attr); ?>>
    <?php echo esc_html($button_text); ?>
</button>

<?php
//------------------------------------------
// Retrieve the files uploaded through ACF
//------------------------------------------
$files = get_field('lekcija_files');
if ($files) {
    foreach ($files as $file) {
        echo '<a href="' . esc_url($file['url']) . '" target="_blank">' . esc_html($file['title']) . '</a><br>';
    }
}
get_footer();
?>