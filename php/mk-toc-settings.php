<?php
/**
 * Created by PhpStorm.
 * User: mkanzler
 * Date: 02.08.17
 * Time: 16:04
 */

function mk_toc_settings_init() {
    register_setting('mk_toc_settings', 'mk_toc_smooth');
    register_setting('mk_toc_settings', 'mk_toc_top_offset');
    register_setting('mk_toc_settings', 'mk_toc_default_heading');

    add_settings_section(
        'mk_toc_section_general',
        __( 'General', 'mk_toc' ),
        'mk_toc_section_general_cb',
        'mk_toc_settings'
    );

    add_settings_field(
        'mk_toc_smooth',
        __('Enable Smooth Scrolling', 'mk_toc'),
        'mk_toc_smooth_field_cb',
        'mk_toc_settings',
        'mk_toc_section_general',
        [
            'label_for' => 'mk_toc_smooth',
            'class' => 'mk_toc_setting',
            'description' => __('Enable Smooth Scrolling Animation if a link anchor is clicked.', 'mk_toc')
        ]
    );

    add_settings_field(
        'mk_toc_top_offset',
        __('Offset for heading anchors in text', 'mk_toc'),
        'mk_toc_top_offset_field_cb',
        'mk_toc_settings',
        'mk_toc_section_general',
        [
            'label_for' => 'mk_toc_top_offset',
            'class' => 'mk_toc_setting',
            'description' => __('Set an amount of px to add an offset from the top of the window, if a anchor link is used to scroll to a specific section.', 'mk_toc'),
            'warning' => __('This is only working when smooth scrolling is activated!', 'mk_toc')
        ]
    );

    add_settings_field(
        'mk_toc_default_heading',
        __('Default Heading over the ToC', 'mk_toc'),
        'mk_toc_default_heading_field_cb',
        'mk_toc_settings',
        'mk_toc_section_general',
        [
            'label_for' => 'mk_toc_default_heading',
            'class' => 'mk_toc_setting',
            'description' => __('Sets the default heading over every ToC you insert. You can give a custom heading for every ToC if you change the title parameter in the shortcode.', 'mk_toc'),
        ]
    );
}
add_action( 'admin_init', 'mk_toc_settings_init' );


function mk_toc_section_general_cb( $args ) {
    ?>
    <p id="<?php echo esc_attr( $args['id'] ); ?>"><?php esc_html_e( '', 'mk_toc' ); ?></p>
    <?php
}

function mk_toc_smooth_field_cb( $args ) {
    $options = get_option('mk_toc_smooth', 0);
    echo '<input type="checkbox" id="'.$args['label_for'].'" name="'.$args['label_for'].'" class="'.$args['class'].'" value="1" ' . checked(1, $options, false) . '/>';
    ?>
    <p class="description">
        <?php esc_html_e( $args['description'], 'mk_toc' ); ?>
    </p>
    <?php
}

function mk_toc_top_offset_field_cb( $args ) {
    $options = get_option('mk_toc_top_offset', 0);
    $smooth = get_option('mk_toc_smooth', 0);

    echo '<input type="text" id="'.$args['label_for'].'" name="'.$args['label_for'].'" class="'.$args['class'].'" value="'.$options.'" '.disabled($smooth, false, false).'/> px';
    ?>
    <p class="description">
        <?php esc_html_e( $args['description'], 'mk_toc' ); ?>
    </p>
    <p class="description">
        <?php esc_html_e( $args['warning'], 'mk_toc' ); ?>
    </p>
    <?php
}

function mk_toc_default_heading_field_cb( $args ) {
    $options = get_option('mk_toc_default_heading', '');

    echo '<input type="text" id="'.$args['label_for'].'" name="'.$args['label_for'].'" class="'.$args['class'].'" value="'.$options.'"/>';
    ?>
    <p class="description">
        <?php esc_html_e( $args['description'], 'mk_toc' ); ?>
    </p>
    <?php
}

/*** top level menu ***/
function mk_toc_settings_page() {
    add_menu_page(
        'MK Table of Contents',
        'MK ToC',
        'manage_options',
        'mk_toc_settings',
        'mk_toc_settings_page_html',
        'dashicons-text'
    );
}
add_action( 'admin_menu', 'mk_toc_settings_page' );

function mk_toc_settings_page_html() {
    if (!current_user_can( 'manage_options')) {
        return;
    }

    if(isset($_GET['settings-updated'])) {
        add_settings_error('mk_toc_smooth', 'mk_toc_smooth', __('All Settings saved', 'mk_toc'), 'updated' );
    }

    settings_errors('mk_toc_smooth');
    settings_errors('mk_toc_top_offset');
    settings_errors('mk_toc_default_heading');

    ?>
    <div class="wrap">
        <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
        <form action="options.php" method="post">
            <?php
            settings_fields('mk_toc_settings');
            do_settings_sections('mk_toc_settings');
            submit_button(__('Save Settings', 'mk_toc'));
            ?>
        </form>
    </div>
    <?php
}