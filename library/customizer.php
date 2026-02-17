<?php
/**
 * Cielos Theme Customizer
 *
 * @package Cielos
 * @since   Cielos 1.0.0
 */

/**
 * Register customizer settings
 */
function cielos_customize_register( $wp_customize ) {

    // ========== Theme Options Panel ==========
    $wp_customize->add_panel( 'cielos_theme_options', array(
        'title'       => __( 'Theme Options', 'cielos' ),
        'description' => __( 'Customize theme settings', 'cielos' ),
        'priority'    => 30,
    ) );

    // ========== Header Section ==========
    $wp_customize->add_section( 'cielos_header_section', array(
        'title'    => __( 'Header', 'cielos' ),
        'panel'    => 'cielos_theme_options',
        'priority' => 10,
    ) );

    // Header pattern
    $wp_customize->add_setting( 'cielos_header_pattern', array(
        'default'           => 'default',
        'sanitize_callback' => 'cielos_sanitize_header_pattern',
    ) );
    $wp_customize->add_control( 'cielos_header_pattern', array(
        'label'       => __( 'Header Layout', 'cielos' ),
        'description' => __( 'Select the header layout pattern', 'cielos' ),
        'section'     => 'cielos_header_section',
        'type'        => 'select',
        'choices'     => array(
            'default'     => __( 'Default (Logo left + Nav right)', 'cielos' ),
            'centered'    => __( 'Centered (Logo + Nav centered)', 'cielos' ),
            'transparent' => __( 'Transparent (Overlay on hero)', 'cielos' ),
            'minimal'     => __( 'Minimal (Fullscreen nav)', 'cielos' ),
            'split'       => __( 'Split (Primary left + Logo center + Secondary right)', 'cielos' ),
        ),
    ) );

    // Sticky header
    $wp_customize->add_setting( 'cielos_sticky_header', array(
        'default'           => true,
        'sanitize_callback' => 'wp_validate_boolean',
    ) );
    $wp_customize->add_control( 'cielos_sticky_header', array(
        'label'   => __( 'Enable sticky header', 'cielos' ),
        'section' => 'cielos_header_section',
        'type'    => 'checkbox',
    ) );

    // ========== Colors Section ==========
    $wp_customize->add_section( 'cielos_colors_section', array(
        'title'    => __( 'Theme Colors', 'cielos' ),
        'panel'    => 'cielos_theme_options',
        'priority' => 20,
    ) );

    // Primary color
    $wp_customize->add_setting( 'cielos_primary_color', array(
        'default'           => '#3b82f6',
        'sanitize_callback' => 'sanitize_hex_color',
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'cielos_primary_color', array(
        'label'   => __( 'Primary Color', 'cielos' ),
        'section' => 'cielos_colors_section',
    ) ) );

    // Accent color
    $wp_customize->add_setting( 'cielos_accent_color', array(
        'default'           => '#10b981',
        'sanitize_callback' => 'sanitize_hex_color',
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'cielos_accent_color', array(
        'label'   => __( 'Accent Color', 'cielos' ),
        'section' => 'cielos_colors_section',
    ) ) );

    // ========== Footer Section ==========
    $wp_customize->add_section( 'cielos_footer_section', array(
        'title'    => __( 'Footer', 'cielos' ),
        'panel'    => 'cielos_theme_options',
        'priority' => 30,
    ) );

    // Footer pattern
    $wp_customize->add_setting( 'cielos_footer_pattern', array(
        'default'           => 'default',
        'sanitize_callback' => 'cielos_sanitize_footer_pattern',
    ) );
    $wp_customize->add_control( 'cielos_footer_pattern', array(
        'label'       => __( 'Footer Layout', 'cielos' ),
        'description' => __( 'Select the footer layout pattern', 'cielos' ),
        'section'     => 'cielos_footer_section',
        'type'        => 'select',
        'choices'     => array(
            'default'  => __( 'Default (3-column widgets)', 'cielos' ),
            'minimal'  => __( 'Minimal (Copyright + social)', 'cielos' ),
            'rich'     => __( 'Rich (Full-featured 5-column)', 'cielos' ),
            'centered' => __( 'Centered (Logo + nav centered)', 'cielos' ),
            'band'     => __( 'Band (Two-tier dark bar)', 'cielos' ),
        ),
    ) );

    // Copyright text
    $wp_customize->add_setting( 'cielos_copyright_text', array(
        'default'           => '',
        'sanitize_callback' => 'wp_kses_post',
    ) );
    $wp_customize->add_control( 'cielos_copyright_text', array(
        'label'       => __( 'Copyright Text', 'cielos' ),
        'description' => __( 'Leave empty to use default', 'cielos' ),
        'section'     => 'cielos_footer_section',
        'type'        => 'textarea',
    ) );

    // ========== Analytics Section ==========
    $wp_customize->add_section( 'cielos_analytics_section', array(
        'title'       => __( 'Analytics', 'cielos' ),
        'description' => __( 'Add tracking codes', 'cielos' ),
        'panel'       => 'cielos_theme_options',
        'priority'    => 40,
    ) );

    // Google Analytics ID
    $wp_customize->add_setting( 'cielos_google_analytics_id', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    $wp_customize->add_control( 'cielos_google_analytics_id', array(
        'label'       => __( 'Google Analytics ID', 'cielos' ),
        'description' => __( 'Enter your GA4 Measurement ID (G-XXXXXXXXXX)', 'cielos' ),
        'section'     => 'cielos_analytics_section',
        'type'        => 'text',
    ) );

    // Google Tag Manager ID
    $wp_customize->add_setting( 'cielos_gtm_id', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    $wp_customize->add_control( 'cielos_gtm_id', array(
        'label'       => __( 'Google Tag Manager ID', 'cielos' ),
        'description' => __( 'Enter your GTM ID (GTM-XXXXXXX)', 'cielos' ),
        'section'     => 'cielos_analytics_section',
        'type'        => 'text',
    ) );
}
add_action( 'customize_register', 'cielos_customize_register' );

/**
 * Sanitize header pattern selection
 */
function cielos_sanitize_header_pattern( $value ) {
    $valid = array( 'default', 'centered', 'transparent', 'minimal', 'split' );
    return in_array( $value, $valid, true ) ? $value : 'default';
}

/**
 * Sanitize footer pattern selection
 */
function cielos_sanitize_footer_pattern( $value ) {
    $valid = array( 'default', 'minimal', 'rich', 'centered', 'band' );
    return in_array( $value, $valid, true ) ? $value : 'default';
}

/**
 * Output custom CSS from customizer settings
 */
function cielos_customizer_css() {
    $primary = get_theme_mod( 'cielos_primary_color', '#3b82f6' );
    $accent  = get_theme_mod( 'cielos_accent_color', '#10b981' );
    ?>
    <style id="cielos-customizer-css">
        :root {
            --c-primary: <?php echo esc_attr( $primary ); ?>;
            --c-accent: <?php echo esc_attr( $accent ); ?>;
        }
    </style>
    <?php
}
add_action( 'wp_head', 'cielos_customizer_css', 100 );

/**
 * Output Google Analytics tracking code
 */
function cielos_analytics_tracking() {
    $ga_id  = get_theme_mod( 'cielos_google_analytics_id', '' );
    $gtm_id = get_theme_mod( 'cielos_gtm_id', '' );

    if ( ! empty( $ga_id ) ) : ?>
        <!-- Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=<?php echo esc_attr( $ga_id ); ?>"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());
            gtag('config', '<?php echo esc_js( $ga_id ); ?>');
        </script>
    <?php endif;

    if ( ! empty( $gtm_id ) ) : ?>
        <!-- Google Tag Manager -->
        <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
        new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
        j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
        'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
        })(window,document,'script','dataLayer','<?php echo esc_js( $gtm_id ); ?>');</script>
    <?php endif;
}
add_action( 'wp_head', 'cielos_analytics_tracking', 1 );

/**
 * Output GTM noscript tag
 */
function cielos_gtm_noscript() {
    $gtm_id = get_theme_mod( 'cielos_gtm_id', '' );
    if ( ! empty( $gtm_id ) ) : ?>
        <!-- Google Tag Manager (noscript) -->
        <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=<?php echo esc_attr( $gtm_id ); ?>"
        height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <?php endif;
}
add_action( 'wp_body_open', 'cielos_gtm_noscript', 1 );
