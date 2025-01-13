<?php
// -------------------------------------
// ADDING POST TYPES AND RENAMING POSTS
// -------------------------------------
function rename_posts_menu() {
    global $menu, $submenu;

    // Rename the "Posts" menu item
    $menu[5][0] = 'Redovna nastava'; // Replace 'Articles' with your desired name
}
add_action('admin_menu', 'rename_posts_menu');

// Lekcije
function sscp_post_types() {
  register_post_type('lekcije', array(
    'public' => true,
    'supports' => array('title', 'editor'),
    'rewrite' => array('slug' => 'lekcije'),
    'menu_icon' => 'dashicons-welcome-learn-more',
    'show_in_rest' => true,
    'supports' => array('title', 'editor', 'author', 'thumbnail'),
    'taxonomies' => array('category' ),
    'labels' => array(
      'name' => 'Lekcije',
      'add_new_item' => 'Stvori novu lekciju',
      'edit_item' => 'Editiraj Lekciju',
      'all_items' => 'Sve lekcije',
      'singular_name' => 'Lekcija'
    )
  ));

  // Ispiti
  register_post_type('ispiti', array(
    'public' => true,
        'supports' => array('title', 'editor'),
    'rewrite' => array('slug' => 'ispiti'),
    'menu_icon' => 'dashicons-text-page',
    'show_in_rest' => true,
    'labels' => array(
      'name' => 'Ispiti',
      'add_new_item' => 'Stvori novi ispit',
      'edit_item' => 'Editiraj Ispit',
      'all_items' => 'Svi ispiti',
      'singular_name' => 'Ispit'
    )
  ));

  //Ispitna pitanja
    register_post_type('pitanja', array(
    'public' => true,
        'supports' => array('title', 'editor'),
    'rewrite' => array('slug' => 'pitanja'),
    'menu_icon' => 'dashicons-forms',
    'show_in_rest' => true,
    'taxonomies'          => array('topics', 'category' ),
    'labels' => array(
      'name' => 'Ispitna pitanja',
      'add_new_item' => 'Stvori novo pitanje',
      'edit_item' => 'Editiraj pitanje',
      'all_items' => 'Sva pitanja',
      'singular_name' => 'Pitanje'
    )
  ));
    /*//Nastava postovi
    register_post_type('nastava', array(
    'public' => true,
        'supports' => array('title', 'editor'),
    'rewrite' => array('slug' => 'nastava'),
    'menu_icon' => 'dashicons-book',
    'show_in_rest' => true,
    'labels' => array(
      'name' => 'Nastava',
      'add_new_item' => 'Stvori novu objavu',
      'edit_item' => 'Editiraj objavu',
      'all_items' => 'Sve objave',
      'singular_name' => 'Objava'
    )
  ));*/

    //Autoškola postovi
    register_post_type('autoskola', array(
    'public' => true,
        'supports' => array('title', 'editor'),
    'rewrite' => array('slug' => 'autoskola'),
    'menu_icon' => 'dashicons-car',
    'show_in_rest' => true,
    'labels' => array(
      'name' => 'Autoškola',
      'add_new_item' => 'Stvori novu objavu',
      'edit_item' => 'Editiraj objavu',
      'all_items' => 'Sve objave',
      'singular_name' => 'AŠ Objava'
    )
  ));
  //Obrazovanje odraslik postovi
    register_post_type('odrasli', array(
    'public' => true,
        'supports' => array('title', 'editor'),
    'rewrite' => array('slug' => 'obrazovanje-odraslih'),
    'menu_icon' => 'dashicons-groups',
    'show_in_rest' => true,
    'labels' => array(
      'name' => 'Obr. odraslih',
      'add_new_item' => 'Stvori novu objavu',
      'edit_item' => 'Editiraj objavu',
      'all_items' => 'Sve objave',
      'singular_name' => 'Ob. odraslih Objava'
    )
  ));
  //Projekti
    register_post_type('projekti', array(
    'public' => true,
        'supports' => array('title', 'editor'),
    'rewrite' => array('slug' => 'projekti'),
    'menu_icon' => 'dashicons-awards',
    'show_in_rest' => true,
    'labels' => array(
      'name' => 'Projekti',
      'add_new_item' => 'Stvori novi projekt',
      'edit_item' => 'Editiraj projekt',
      'all_items' => 'Svi projekti',
      'singular_name' => 'Projekt'
    )
  ));
}
add_action('init', 'sscp_post_types');

// ----------------------------------
// ADDING LEKCIJE SUBMENUS AND LOGIC
// ----------------------------------
// PREGLED, NASTAVNICI, RAZREDI SUBMENU
// -------------------------------------

function lekcije_custom_submenus() {
    add_submenu_page(
        'edit.php?post_type=lekcije', // Parent slug (Lekcije menu)
        'Pregled',                    // Page title
        'Pregled',                    // Menu title
        'manage_options',             // Capability (admin only)
        'pregled',                    // Menu slug (unique identifier)
        'pregled_page_callback',       // Callback function to render the page content
        0
    );
        add_submenu_page(
        'edit.php?post_type=lekcije', // Parent slug (Lekcije menu)
        'Nastavnici',                    // Page title
        'Nastavnici',                    // Menu title
        'manage_options',             // Capability (admin only)
        'nastavnici',                    // Menu slug (unique identifier)
        'nastavnici_page_callback',       // Callback function to render the page content
        1
    );
        add_submenu_page(
        'edit.php?post_type=lekcije', // Parent slug (Lekcije menu)
        'Razredi',                    // Page title
        'Razredi',                    // Menu title
        'manage_options',             // Capability (admin only)
        'razredi',                    // Menu slug (unique identifier)
        'razredi_page_callback',       // Callback function to render the page content
        2
    );
}
add_action('admin_menu', 'lekcije_custom_submenus');


// CREATING PREGLED LOGIC

// Callback function for "Pregled" page
function pregled_page_callback() {
    ?>
    <div class="wrap">
        <h1>Pregled Lekcija</h1>
        <p>Ovdje možete vidjeti napredak korisnika i završene lekcije.</p>

        <table class="wp-list-table widefat fixed striped">
            <thead>
                <tr>
                    <th scope="col">Korisnik</th>
                    <th scope="col">Završene Lekcije</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Get all users
                $users = get_users();

                // Loop through users
                foreach ($users as $user) {
                    $user_id = $user->ID;
                    $user_name = $user->display_name;

                    // Fetch all Lekcije posts
                    $finished_lekcije = [];
                    $lekcije_posts = get_posts([
                        'post_type' => 'lekcije',
                        'posts_per_page' => -1,
                    ]);

                    // Check if the user has completed each Lekcija
                    foreach ($lekcije_posts as $lekcija) {
                        $lekcija_id = $lekcija->ID;
                        $is_finished = get_user_meta($user_id, 'finished_lekcija_' . $lekcija_id, true);

                        if ($is_finished) {
                            $finished_lekcije[] = $lekcija->post_title;
                        }
                    }

                    // Output user progress
                    echo '<tr>';
                    echo '<td>' . esc_html($user_name) . '</td>';
                    echo '<td>' . (!empty($finished_lekcije) ? implode(', ', $finished_lekcije) : 'Nema završenih lekcija') . '</td>';
                    echo '</tr>';
                }
                ?>
            </tbody>
        </table>
    </div>
    <?php
}

// ----------------------------------
// NASTAVNICI SUBMENU
// ----------------------------------

function nastavnici_page_callback() {
    // Check if form is submitted to add a new user
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_nastavnik'])) {
        $first_name = sanitize_text_field($_POST['ime']);
        $last_name = sanitize_text_field($_POST['prezime']);
        $username = sanitize_user($_POST['username']);
        $password = sanitize_text_field($_POST['password']);
        $role = sanitize_text_field($_POST['role']);

        // Create the user
        $user_id = wp_create_user($username, $password);
        if (!is_wp_error($user_id)) {
            wp_update_user([
                'ID' => $user_id,
                'first_name' => $first_name,
                'last_name' => $last_name,
            ]);

            update_user_meta($user_id, '_plaintext_password', $password); // Save plaintext password for admin viewing
            $user = new WP_User($user_id);
            $user->set_role($role);
            echo '<div class="updated"><p>Korisnik je uspješno dodan.</p></div>';
        } else {
            echo '<div class="error"><p>Greška: ' . esc_html($user_id->get_error_message()) . '</p></div>';
        }
    }

    // Check if a user is being removed
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['remove_user_id'])) {
        $user_id_to_remove = intval($_POST['remove_user_id']);
        if ($user_id_to_remove) {
            wp_delete_user($user_id_to_remove);
            echo '<div class="updated"><p>Korisnik je uspješno uklonjen.</p></div>';
        }
    }

    // Fetch all users with any role
    $users = get_users();

    // Add User Form
    echo '<h1>Dodaj novog nastavnika</h1>';
    echo '<form method="post">';
    echo '<table class="form-table">';
    echo '<tr><th><label for="ime">Ime</label></th><td><input type="text" name="ime" id="ime" required></td></tr>';
    echo '<tr><th><label for="prezime">Prezime</label></th><td><input type="text" name="prezime" id="prezime" required></td></tr>';
    echo '<tr><th><label for="username">Korisničko ime</label></th><td><input type="text" name="username" id="username" required></td></tr>';
    echo '<tr><th><label for="password">Lozinka</label></th><td><input type="password" name="password" id="password" required></td></tr>';
    echo '<tr><th><label for="role">Uloga</label></th><td>';
    echo '<select name="role" id="role" required>';
    foreach (wp_roles()->roles as $role_key => $role_details) {
        echo '<option value="' . esc_attr($role_key) . '">' . esc_html($role_details['name']) . '</option>';
    }
    echo '</select>';
    echo '</td></tr>';
    echo '</table>';
    echo '<button type="submit" name="add_nastavnik" class="button button-primary">Dodaj nastavnika</button>';
    echo '</form>';

    // User Table
    echo '<h1>Popis nastavnika</h1>';
    echo '<table class="wp-list-table widefat fixed striped">';
    echo '<thead><tr>';
    echo '<th>Ime</th>';
    echo '<th>Prezime</th>';
    echo '<th>Korisničko ime</th>';
    echo '<th>Lozinka</th>';
    echo '<th>Uloga</th>';
    echo '<th>Akcija</th>';
    echo '</tr></thead>';
    echo '<tbody>';

    foreach ($users as $user) {
        $first_name = get_user_meta($user->ID, 'first_name', true);
        $last_name = get_user_meta($user->ID, 'last_name', true);
        $password = get_user_meta($user->ID, '_plaintext_password', true); // Fetch the stored plaintext password
        $roles = implode(', ', $user->roles); // Fetch roles

        echo '<tr>';
        echo '<td>' . esc_html($first_name) . '</td>';
        echo '<td>' . esc_html($last_name) . '</td>';
        echo '<td>' . esc_html($user->user_login) . '</td>';
        echo '<td>' . esc_html($password) . '</td>'; // Display password directly
        echo '<td>' . esc_html($roles) . '</td>';
        echo '<td><form method="post">';
        echo '<input type="hidden" name="remove_user_id" value="' . esc_attr($user->ID) . '">';
        echo '<button type="submit" class="button button-secondary">Ukloni</button>';
        echo '</form></td>';
        echo '</tr>';
    }

    echo '</tbody>';
    echo '</table>';
}


?>