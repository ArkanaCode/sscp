<?php
// Get the related questions for the current post
$related_questions = get_field('related_questions'); // Use the field name you set earlier

if ($related_questions) {
    echo '<h3>Related Questions:</h3>';
    echo '<ul>';

    foreach ($related_questions as $question) {
        // Display each question as a linked title
        echo '<li><a href="' . get_permalink($question->ID) . '">' . get_the_title($question->ID) . '</a></li>';
    }

    echo '</ul>';
} else {
    echo '<p>No related questions found for this test.</p>';
}
?>
