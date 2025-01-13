<?php

// ---------------------------
// ENQUEUE STYLES AND SCRIPTS
// ---------------------------
// Function to enqueue styles and scripts for the theme
function theme_files() {
    wp_enqueue_style( 'main-style', get_stylesheet_uri() );
}

add_action('wp_enqueue_scripts', 'theme_files');

// ------------------------------------------
// ENQUEUE SPECIFIC LOGIC RELEVANT SCRIPTS
// ------------------------------------------
// ENQUEUE JQUERRY AND EXAM VALIDATION SCRIPT
// ------------------------------------------
function enqueue_custom_scripts() {
    // Enqueue jQuery (WordPress ships with jQuery by default)
    wp_enqueue_script('jquery');

    // Enqueue your custom JavaScript file (exam_validation.js)
   wp_enqueue_script('exam-validation', get_template_directory_uri() . '/js/exam_validation.js', array('jquery'), null, true);
}
add_action('wp_enqueue_scripts', 'enqueue_custom_scripts');
//------------------------------
// ENQUEUE LEKCIJE BUTTON STUFF
//------------------------------
function enqueue_finish_lesson_script() {
    wp_enqueue_script('finish-lesson', get_template_directory_uri() . '/js/finish-lesson.js', array('jquery'), null, true);
    wp_localize_script('finish-lesson', 'finishLessonParams', array(
        'ajaxurl' => admin_url('admin-ajax.php'),
    ));
}

add_action('wp_enqueue_scripts', 'enqueue_finish_lesson_script');

function handle_finish_lesson() {
    if (!is_user_logged_in()) {
        wp_send_json_error(array('message' => 'You must be logged in.'));
    }

    $user_id = get_current_user_id();
    $lekcija_id = $_POST['lekcija_id'];

    // Save that the user finished the lesson (using usermeta)
    update_user_meta($user_id, 'finished_lekcija_' . $lekcija_id, true);

    wp_send_json_success(array('message' => 'Lekcija završena'));
}

add_action('wp_ajax_finish_lesson', 'handle_finish_lesson');


//ENQUEUE LEKCIJE TOGGLE SCRIPT
function enqueue_lekcije_toggle_script() {
    // Enqueue the script only for the page with the 'E-Škola' template
    if (is_page_template('page-e-skola.php')) {
        wp_enqueue_script(
            'lekcije-toggle', // Handle
            get_template_directory_uri() . '/js/lekcije-toggle.js', // Path to your JavaScript file
            array('jquery'), // Dependency (if you're using jQuery)
            null, // Version (set to null to not specify a version)
            true // Load in footer (set to true for better performance)
        );
    }
}
add_action('wp_enqueue_scripts', 'enqueue_lekcije_toggle_script');

// END OF STYLE AND SCRIPT ENQUEUE
// --------------------------------
// ADDING FEATURES
// ---------------------------
function sscp_features() {
  add_theme_support('title-tag');
}
add_action( 'after_setup_theme', 'sscp_features');

function remove_comments_menu_item() {
    // Remove the Comments menu item
    remove_menu_page('edit-comments.php');
}
add_action('admin_menu', 'remove_comments_menu_item', 999);
// END OF FEATURES

// ---------------------------
// ACF STYLING
// ---------------------------
function my_acf_admin_head() {
?>
<style type="text/css">
       /*.acf-fields {
        display: flex;
        flex-wrap: wrap;
        justify-content: center; 
        align-items: center;
        gap: 10px; 
    }*/


        .acf-field[data-name="question_type"],
        .acf-field[data-name="answer_1"],
        .acf-field[data-name="answer_2"],
        .acf-field[data-name="answer_3"],
        .acf-field[data-name="answer_4"],
        .acf-field[data-name="text_answer"] {
            display: inline-block;
            width: 72%;

        }

        .acf-field[data-name="kljucno"],
        .acf-field[data-name="answer_1_correct"],
        .acf-field[data-name="answer_2_correct"],
        .acf-field[data-name="answer_3_correct"],
        .acf-field[data-name="answer_4_correct"],
        .acf-field[data-name="correct_text_answer"] {
            display: inline-block;
            width: 25%;
        }

</style>
<?php
}

add_action('acf/input/admin_head', 'my_acf_admin_head');

// ---------------------------
// TEST VALIDATION
// ---------------------------
function enqueue_exam_validation_script() {
    // Enqueue the JavaScript file
    wp_enqueue_script(
        'exam-validation', // Handle for the script
        get_template_directory_uri() . '/js/exam-validation.js', // Path to the script (adjust the path based on your theme structure)
        array('jquery'), // Dependencies, in this case we are depending on jQuery
        null, // Version (optional, can be set to null or specify version number)
        true // Load the script in the footer
    );

    // Add localized variables to pass PHP variables (like admin-ajax URL) to JavaScript
    wp_localize_script(
        'exam-validation', // Handle of the enqueued script
        'examValidationVars', // Name of the JavaScript object to store variables
        array(
            'admin_ajax_url' => admin_url('admin-ajax.php') // URL for AJAX requests
        )
    );
}
add_action('wp_enqueue_scripts', 'enqueue_exam_validation_script');

// ---------------------------
// ROLES SECTION
// ---------------------------
// CREATING A MULTIPLE CHOICE ROLE PICKER





// ---------------------------
// SUPERUSER ROLE
// ---------------------------

// Add the Super Admin role
function add_superadmin_role() {
    add_role(
        'superadmin', // Role slug
        'Super Admin', // Role name
        array(
            'read' => true,
            'manage_options' => true, // Allows admin capabilities
            'edit_posts' => true,
            'delete_posts' => true,
            'publish_posts' => true,
            // Add more capabilities as needed
        )
    );
}
add_action('init', 'add_superadmin_role');

// Add custom field in user profile
function add_superadmin_role_to_user_profile($user) {
    // Check if the user has the 'superadmin' role
    $is_superadmin = in_array('superadmin', (array) $user->roles);

    ?>
    <h3>Super Admin Role</h3>
    <table class="form-table">
        <tr>
            <th><label for="superadmin_role">Super Admin</label></th>
            <td>
                <input 
                    type="checkbox" 
                    name="superadmin_role" 
                    id="superadmin_role" 
                    value="1" 
                    <?php checked($is_superadmin, true); ?> 
                />
                <span class="description">Check this to assign the Super Admin role to this user.</span>
            </td>
        </tr>
    </table>
    <?php
}

add_action('show_user_profile', 'add_superadmin_role_to_user_profile');
add_action('edit_user_profile', 'add_superadmin_role_to_user_profile');

// Save the Super Admin role when the profile is updated
function save_superadmin_role_to_user_profile($user_id) {
    // Verify that the current user has permission to edit
    if (!current_user_can('edit_user', $user_id)) {
        return;
    }

    // Fetch the user object
    $user = new WP_User($user_id);

    // Handle the checkbox
    if (isset($_POST['superadmin_role']) && $_POST['superadmin_role'] == '1') {
        // Assign the Super Admin role
        if (!$user->has_role('superadmin')) {
            $user->add_role('superadmin');
        }
    } else {
        // Remove the Super Admin role if unchecked
        if ($user->has_role('superadmin')) {
            $user->remove_role('superadmin');
        }
    }
}

add_action('personal_options_update', 'save_superadmin_role_to_user_profile');
add_action('edit_user_profile_update', 'save_superadmin_role_to_user_profile');



//.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-
// NUCLEAR OPTIONS
//.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-
// REMOVING A USER ROLE FROM THE DATABASE
/*
function remove_superuser_role() {
  if (get_role('superuser')) {
    remove_role('superuser');
    }
    }
    add_action('init', 'remove_superuser_role');

    function remove_superadmin_role() {
  if (get_role('superadmin')) {
    remove_role('superadmin');
    }
    }
    add_action('init', 'remove_superadmin_role');
*/
?>