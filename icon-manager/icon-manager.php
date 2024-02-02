<?php
/*
Plugin Name: Icon Manager
Description: Plugin to manage icons.
Version: 1.0
Author: Your Name
*/

// Make sure this file is called directly
if (!defined('WPINC')) {
    die;
}

// Global WordPress database class
global $wpdb;

// Table name with prefix
$table_name = $wpdb->prefix . 'icons';

// Check if the table already exists
if ($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
    // Table does not exist, create it

    // Collation for the database
    $charset_collate = $wpdb->get_charset_collate();

    // SQL statement for table creation
    $sql = "CREATE TABLE $table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        name VARCHAR(100) NOT NULL,
        value VARCHAR(255) NOT NULL,
        PRIMARY KEY (id)
    ) $charset_collate;";

    // Include the upgrade file
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

    // Execute the SQL and create the table
    dbDelta($sql);
}

register_uninstall_hook(__FILE__, 'icon_manager_uninstall');

// Callback function for uninstallation
function icon_manager_uninstall() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'icons';

    // Drop the table if it exists
    $wpdb->query("DROP TABLE IF EXISTS $table_name");
}

function get_icon($name) {
    global $wpdb;
    $table_name = $wpdb->prefix . 'icons';
    $icon = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table_name WHERE name = %s", $name), ARRAY_A);
    if ($icon) {
        return '<i class="' . esc_attr($icon['value']) . '"></i>';
    } else {
        return ''; // Return an empty string if the icon is not found
    }
}

if (!function_exists('icon')) {
    function icon($name) {
        echo get_icon($name);
    }
}

function set_icon($name, $value) {
    global $wpdb;
    $table_name = $wpdb->prefix . 'icons';

    // Check if the icon already exists
    $existing_icon = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table_name WHERE name = %s", $name), ARRAY_A);

    if ($existing_icon) {
        // Icon already exists, update its value
        $wpdb->update(
            $table_name,
            array('value' => $value),
            array('id' => $existing_icon['id'])
        );
    } else {
        // Icon doesn't exist, insert a new row
        $wpdb->insert(
            $table_name,
            array(
                'name'  => $name,
                'value' => $value,
            )
        );
    }
}

function icon_manager_menu_page() {
    add_management_page(
        'Icon Manager',
        'Icon Manager',
        'manage_options',
        'icon-manager',
        'icon_manager_page_content'
    );
}
add_action('admin_menu', 'icon_manager_menu_page');

// Callback function for the menu page
function icon_manager_page_content() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'icons';

    $icons = $wpdb->get_results("SELECT * FROM $table_name", ARRAY_A);

    ?>
    <div class="wrap">
        <h1>Icon Manager</h1>

        <table class="wp-list-table widefat fixed striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Value</th>
                  
                </tr>
            </thead>
            <tbody>
                <?php foreach ($icons as $icon) : ?>
                    <tr>
                        <td><?php echo esc_html($icon['id']); ?></td>
                        <td><?php echo esc_html($icon['name']); ?></td>
                        <td><?php echo esc_html($icon['value']); ?></td>
                        
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php
}