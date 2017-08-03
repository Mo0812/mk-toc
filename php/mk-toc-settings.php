<?php
/**
 * Created by PhpStorm.
 * User: mkanzler
 * Date: 02.08.17
 * Time: 16:04
 */

function mk_toc_settings_init() {
    register_setting( 'mk_toc_settings', 'mk_toc_alwayson' );

    add_settings_section(
        'mk_toc_section_general',
        __( 'General', 'mk_toc' ),
        'mk_toc_section_general_cb',
        'mk_toc_settings'
    );

    add_settings_field(
        'mk_toc_alwayson',
        __( 'Enable TOC on every post', 'mk_toc' ),
        'mk_toc_alwayson_field_cb',
        'mk_toc_settings',
        'mk_toc_section_general',
        [
            'label_for' => 'mk_toc_alwayson',
            'class' => 'mk_toc_setting',
            'description' => 'Enable TOC per default on every post, you can opt-out it in specific posts.'
        ]
    );
}
add_action( 'admin_init', 'mk_toc_settings_init' );


function mk_toc_section_general_cb( $args ) {
    ?>
    <p id="<?php echo esc_attr( $args['id'] ); ?>"><?php esc_html_e( '', 'mk_toc' ); ?></p>
    <?php
}

function mk_toc_alwayson_field_cb( $args ) {
    $options = get_option( 'mk_toc_alwayson' );
    echo '<input type="checkbox" id="'.$args['label_for'].'" name="'.$args['label_for'].'" class="'.$args['class'].'" value="1" ' . checked(1, $options, false) . '/>';
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
    if ( ! current_user_can( 'manage_options' ) ) {
        return;
    }

    if ( isset( $_GET['settings-updated'] ) ) {
        add_settings_error( 'mk_toc_alwayson', 'mk_toc_alwayson', __( 'Settings Saved', 'mk_toc' ), 'updated' );
    }

    settings_errors( 'mk_toc_alwayson' );
    ?>
    <div class="wrap">
        <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
        <form action="options.php" method="post">
            <?php
            settings_fields( 'mk_toc_settings' );
            do_settings_sections( 'mk_toc_settings' );
            submit_button( 'Save Settings' );
            ?>
        </form>
    </div>
    <?php
}