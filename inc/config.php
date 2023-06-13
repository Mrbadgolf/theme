<?php

    /** Theme Options Config File */

    if ( ! class_exists( 'Redux' ) ) {
        return;
    }
	
    // This is your option name where all the Redux data is stored.
    $opt_name = "secretlab";
    // Allowed HTML tags for escaping of translite texts
    $allowed_html = array(
        'a' => array(
            'href' => array(),
            'title' => array(),
            'target' => array(),
        ),
        'br' => array(),
        'em' => array(),
        'strong' => array(),
        'h1' => array(),
        'h2' => array(),
        'h3' => array(),
        'h4' => array(),
        'h5' => array(),
        'h6' => array(),
        'p' => array(
            'style' => array(),
        ),
        'b' => array(),
        'i' => array(),
        'u' => array(),
        'ol' => array(),
        'ul' => array(),
        'li' => array(),
        'code' => array(),
        'del' => array()
    );

    // Background Patterns Reader
    $sample_patterns_path = ReduxFramework::$_dir . '/patterns/';
    $sample_patterns_url  = ReduxFramework::$_url . '/patterns/';
    $sample_patterns      = array();

    if ( is_dir( $sample_patterns_path ) ) {

        if ( $sample_patterns_dir = opendir( $sample_patterns_path ) ) {
            $sample_patterns = array();

            while ( ( $sample_patterns_file = readdir( $sample_patterns_dir ) ) !== false ) {

                if ( stristr( $sample_patterns_file, '.png' ) !== false || stristr( $sample_patterns_file, '.jpg' ) !== false ) {
                    $name              = explode( '.', $sample_patterns_file );
                    $name              = str_replace( '.' . end( $name ), '', $sample_patterns_file );
                    $sample_patterns[] = array(
                        'alt' => $name,
                        'img' => $sample_patterns_url . $sample_patterns_file
                    );
                }
            }
        }
    }

    function get_sidebars() {
        $sidebars = array();
	    foreach ($GLOBALS['wp_registered_sidebars'] as $sb) {
	        $sidebars[$sb['id']] = $sb['name']; 
	    }
        return $sidebars;		
	}

function thelawyer_get_sliders_array() {

    global $wpdb;

    $arr = array( 0 => 'none');

    if (class_exists('LS_Sliders')) {
        $sliders = LS_Sliders::find();
        foreach ($sliders as $slider) {
            $arr['lay_'.$slider['id']] = $slider['name'];
        }
    }
    
	$RsExists = count($wpdb->get_results($wpdb->prepare("SELECT * FROM information_schema.tables WHERE table_schema = '%s' AND table_name = '".$wpdb->prefix."revslider_sliders' LIMIT 1", $wpdb->dbname), ARRAY_A));
    if ($RsExists > 0) {
		$revSliders = $wpdb->get_results($wpdb->prepare("SELECT title, alias FROM ".$wpdb->prefix."revslider_sliders WHERE title<>%s", "nonsense"), ARRAY_A); 
        if (count($revSliders) > 0) {
            foreach ($revSliders as $slider) {
                $arr['rev_'.$slider['alias']] = $slider['title'];
            }
        }
    }	

    if (count($arr) == 1) {
        $arr = array( 0 => esc_attr__('The Theme Support Layer Slider and Slider Revolution, but couldn\'t find it. Install one of the plug-ins to choose the slider to display in the header.', 'the-lawyer') );
    }

    return $arr;
}

    /*=== Adding custom CSS for Theme Options design ===*/
    function addPanelCSS() {
        wp_register_style(
            'redux-custom-css',
            esc_url(get_template_directory_uri()) . '/inc/redux-custom-css.css',
            array( 'redux-admin-css' ), // Be sure to include redux-admin-css so it's appended after the core css is applied
            time(),
            'all'
        );
        wp_enqueue_style('redux-custom-css');
    }
    // This example assumes your opt_name is set to redux_demo, replace with your opt_name value
    add_action( 'redux/page/secretlab/enqueue', 'addPanelCSS' );

     /* ---> SET ARGUMENTS
     * All the possible arguments for Redux.
     * For full documentation on arguments, please refer to: https://github.com/ReduxFramework/ReduxFramework/wiki/Arguments
     * */

    $theme = wp_get_theme(); // For use with some settings. Not necessary.

    $args = array(
        // TYPICAL -> Change these values as you need/desire
        'opt_name'             => $opt_name,
        // This is where your data is stored in the database and also becomes your global variable name.
        'display_name'         => $theme->get( 'The Lawyer' ),
        // Name that appears at the top of your panel
        'display_version'      => $theme->get( 'Version 1.0' ),
        // Version that appears at the top of your panel
        'menu_type'            => 'menu',
        //Specify if the admin menu should appear or not. Options: menu or submenu (Under appearance only)
        'allow_sub_menu'       => true,
        // Show the sections below the admin menu item or not
        'menu_title'           => esc_attr__( 'Theme Options', 'the-lawyer' ),
        'page_title'           => esc_attr__( 'The Lawyer Theme Options', 'the-lawyer' ),
        // You will need to generate a Google API key to use this feature.
        // Please visit: https://developers.google.com/fonts/docs/developer_api#Auth
        'google_api_key'       => 'AIzaSyDipjsETF4ETmbL_Z-0HwJ610s15rHQSx8',
        // Set it you want google fonts to update weekly. A google_api_key value is required.
        'google_update_weekly' => false,
        // Must be defined to add google fonts to the typography module
        'async_typography'     => true,
        // Use a asynchronous font on the front end or font string
        //'disable_google_fonts_link' => true,                    // Disable this in case you want to create your own google fonts loader
        'admin_bar'            => true,
        // Show the panel pages on the admin bar
        'admin_bar_icon'       => 'dashicons-portfolio',
        // Choose an icon for the admin bar menu
        'admin_bar_priority'   => 50,
        // Choose an priority for the admin bar menu
        'global_variable'      => 'secretlab',
        // Set a different name for your global variable other than the opt_name
        'dev_mode'             => false,
        // Show the time the page took to load, etc
        'update_notice'        => true,
        // If dev_mode is enabled, will notify developer of updated versions available in the GitHub Repo
        'customizer'           => false,
        // Enable basic customizer support
        //'open_expanded'     => true,                    // Allow you to start the panel in an expanded way initially.
        //'disable_save_warn' => true,                    // Disable the save warning when a user changes a field

        // OPTIONAL -> Give you extra features
        'page_priority'        => null,
        // Order where the menu appears in the admin area. If there is any conflict, something will not show. Warning.
        'page_parent'          => 'themes.php',
        // For a full list of options, visit: http://codex.wordpress.org/Function_Reference/add_submenu_page#Parameters
        'page_permissions'     => 'manage_options',
        // Permissions needed to access the options panel.
        'menu_icon'            => '',
        // Specify a custom URL to an icon
        'last_tab'             => '',
        // Force your panel to always open to a specific tab (by id)
        'page_icon'            => 'icon-themes',
        // Icon displayed in the admin panel next to your menu_title
        'page_slug'            => '_options',
        // Page slug used to denote the panel
        'save_defaults'        => true,
        // On load save the defaults to DB before user clicks save or not
        'default_show'         => false,
        // If true, shows the default value next to each field that is not the default value.
        'default_mark'         => '',
        // What to print by the field's title if the value shown is default. Suggested: *
        'show_import_export'   => true,
        // Shows the Import/Export panel when not used as a field.

        // CAREFUL -> These options are for advanced use only
        'transient_time'       => 60 * MINUTE_IN_SECONDS,
        'output'               => true,
        // Global shut-off for dynamic CSS output by the framework. Will also disable google fonts output
        'output_tag'           => true,
        // Allows dynamic CSS to be generated for customizer and google fonts, but stops the dynamic CSS from going to the head
        'footer_credit'     => esc_attr__('Developed with love by www.SecretLab.pw', 'the-lawyer'),   // Disable the footer credit of Redux. Please leave if you can help it.

        // FUTURE -> Not in use yet, but reserved or partially implemented. Use at your own risk.
        'database'             => '',
        // possible: options, theme_mods, theme_mods_expanded, transient. Not fully functional, warning!

        'use_cdn'              => true,
        // If you prefer not to use the CDN for Select2, Ace Editor, and others, you may download the Redux Vendor Support plugin yourself and run locally or embed it in your code.

        'compiler'             => true,
		
		'disable_tracking'     => true,

        // HINTS
        'hints'                => array(
            'icon'          => 'el el-question-sign',
            'icon_position' => 'right',
            'icon_color'    => 'lightgray',
            'icon_size'     => 'normal',
            'tip_style'     => array(
                'color'   => 'light',
                'shadow'  => true,
                'rounded' => false,
                'style'   => '',
            ),
            'tip_position'  => array(
                'my' => 'top left',
                'at' => 'bottom right',
            ),
            'tip_effect'    => array(
                'show' => array(
                    'effect'   => 'slide',
                    'duration' => '500',
                    'event'    => 'mouseover',
                ),
                'hide' => array(
                    'effect'   => 'slide',
                    'duration' => '500',
                    'event'    => 'click mouseleave',
                ),
            ),
        )
    );

    // ADMIN BAR LINKS -> Setup custom links in the admin bar menu as external links.
    $args['admin_bar_links'][] = array(
        'id'    => 'sl-docs',
        'href'  => 'http://secretlab.pw/documentation/',
        'title' => esc_attr__( 'Documentation', 'the-lawyer' ),
    );

    $args['admin_bar_links'][] = array(
        'id'    => 'sl-support',
        'href'  => 'http://secretlab.pw/helpdesk/',
        'title' => esc_attr__( 'Support', 'the-lawyer' ),
    );

    $args['admin_bar_links'][] = array(
        'id'    => 'sl-extensions',
        'href'  => 'http://secretlab.pw/',
        'title' => esc_attr__( 'SecretLab', 'the-lawyer' ),
    );


    // Add content after the form.
    $args['footer_text'] = '<p>'.esc_attr__( 'Support Panel: ', 'the-lawyer' ).'<a href="http://secretlab.pw/helpdesk/" target="_blank">http://secretlab.pw/helpdesk/</a></p>';

    Redux::setArgs( $opt_name, $args );



    /*
     As of Redux 3.5+, there is an extensive API. This API can be used in a mix/match mode allowing for
    */

    // -> START General Settings Tab with no subsections
Redux::setSection( $opt_name, array(
    'title'  => esc_attr__( 'General Setting', 'the-lawyer' ),
    'id'     => 'general',
    'icon'   => 'el el-home',
    'fields' => array(
        array(
            'id'       => 'comp-name',
            'type'     => 'text',
            'title'    => esc_attr__( 'Company Name', 'the-lawyer' ),
            'subtitle' => esc_attr__( 'For any section about company.', 'the-lawyer' ),
            'default'  => 'The Lawyer'
        ),
        array(
            'id'       => 'index-page',
            'type'     => 'select',
            'data'     => 'pages',
            'title'    => esc_attr__( 'Frontpage Setting', 'the-lawyer' ),
            'desc'     => esc_attr__( 'Select which page to display on your Frontpage. If left blank the Blog will be displayed', 'the-lawyer' ),
            'default'  => '0'
        ),
	
        array(
            'id'       => 'logo-head',
            'type'     => 'media',
            'title'    => esc_attr__( 'Logo for Header 1 and 4', 'the-lawyer' ),
            'subtitle' => esc_attr__( 'Recommended size - height 50-55px, width 150-400px', 'the-lawyer' ),
			'default'  => array(
				'url'=> esc_url(get_template_directory_uri()).'/images/logo.png'
			),
        ),
        array(
            'id'       => 'logo-head-dark',
            'type'     => 'media',
            'title'    => esc_attr__( 'Dark Logo for Header 2', 'the-lawyer' ),

            'subtitle' => esc_attr__( 'Recommended size - height 50-55px, width 150-400px', 'the-lawyer' ),
            'default'  => array(
                'url'=> esc_url(get_template_directory_uri()).'/images/logodark.png'
            ),
        ),
        array(
            'id'       => 'logo-head3',
            'type'     => 'media',
            'title'    => esc_attr__( 'Logo for Header 3', 'the-lawyer' ),
            'subtitle' => esc_attr__( 'Recommended size - height 50-100px, width 150-400px', 'the-lawyer' ),
            'default'  => array(
                'url'=> esc_url(get_template_directory_uri()).'/images/logo3.png'
            ),
        ),
        array(
            'id'       => 'logo-footer',
            'type'     => 'media',
            'title'    => esc_attr__( 'Logo for Footer', 'the-lawyer' ),
            'subtitle' => esc_attr__( 'Recommended size - height 50-100px, width 150-400px', 'the-lawyer' ),
            'default'  => array(
                'url'=> esc_url(get_template_directory_uri()).'/images/logofooter.png'
            ),
        ),
        array(
            'id'       => 'apple-touch-icon',
            'type'     => 'media',
            'title'    => esc_attr__( 'Apple Touch Icon', 'the-lawyer' ),
            'subtitle' => esc_attr__( 'Recomended size - 144 x 144px', 'the-lawyer' ),
            'default'  => array(
                'url'=> esc_url(get_template_directory_uri()).'/images/apple-touch-icon-144x144.png'
            ),
        ),
        array(
            'id'       => 'favicon',
            'type'     => 'media',
            'title'    => esc_attr__( 'Favicon', 'the-lawyer' ),
            'subtitle' => esc_attr__( 'Upload your favicon', 'the-lawyer' ),
            'default'  => array(
                'url'=> esc_url(get_template_directory_uri()).'/images/favicon.ico'
            ),
        ),

        array(
            'id'       => 'pageloader',
            'type'     => 'switch',
            'title'    => esc_attr__( 'Display Page Loader', 'the-lawyer' ),
            'subtitle'    => esc_attr__( 'Do you want to show page loader, when website is loading?', 'the-lawyer' ),
            'default'  => true,
            'indent'   => true
        ),
        array(
            'id'       => 'pageloaderimage',
            'type'     => 'media',
            'title'    => esc_attr__( 'Icon for Page Loader', 'the-lawyer' ),
            'subtitle' => esc_attr__( 'Upload your icon. It displays, when page is loading', 'the-lawyer' ),
            'default'  => array(
                'url'=> esc_url(get_template_directory_uri()).'/images/animation.png'
            ),
            'required' => array( 'pageloader', '=', true ),
        ),
        array(
            'id'        => 'pageloadercolor',
            'type'      => 'color_rgba',
            'title'     => esc_attr__('Choose Background Color for Page Loader', 'the-lawyer' ),
            'output'    => array('background-color' => '#page-preloader'),
            'default'   => array(
                'color'     => '#f8f8f8',
                'alpha'     => 1
            ),
            'required' => array( 'pageloader', '=', true ),
        ),
    )
) );

/*
 * <--- END SECTIONS
 */
// -> START Contacts Settings Tab with no subsections
Redux::setSection( $opt_name, array(
    'title'  => esc_attr__( 'Contacts &amp; Map', 'the-lawyer' ),
    'id'     => 'contacts',
    'icon'   => 'el el-envelope',
    'fields' => array(
        array(
            'id'       => 'phone',
            'type'     => 'multi_text',
            'title'    => esc_attr__( 'Phone Number', 'the-lawyer' ),
            'subtitle' => esc_attr__( 'One number per one field', 'the-lawyer' ),
            'default'  => array(
                '+1 123 120 25 25',
                '+1 097 567 87 87',
                '+1 123 456 78 90'
            ),
        ),
        array(
            'id'       => 'email',
            'type'     => 'multi_text',
            'title'    => esc_attr__( 'E-mail', 'the-lawyer' ),
            'subtitle' => esc_attr__( 'One e-mail per one field', 'the-lawyer' ),
            'desc'     => esc_attr__( 'For any section about company', 'the-lawyer' ),
            'validate' => 'email',
            'msg'      => 'Wrong e-mail address',
            'default'  => array(
                'lawyer@example.com',
                'lawyer2@example.com'
            ),
        ),
        array(
            'id'       => 'business_hours',
            'type'     => 'text',
            'title'    => esc_attr__( 'Business Hours', 'the-lawyer' ),
            'default'  => 'Mon-Fri 10am - 6pm',
        ),
        array(
            'id'       => 'office_address',
            'type'     => 'text',
            'title'    => esc_attr__( 'Office Address', 'the-lawyer' ),
            'default'  => '350 Fifth Avenue  NY, USA',
        ),
        array(
            'id'       => 'phone_text',
            'type'     => 'text',
            'title'    => esc_attr__( 'Text for Phone at header #8', 'the-lawyer' ),
            'default'  => 'Live Help',
        ),
        array(
            'id'       => 'business_hours_text',
            'type'     => 'text',
            'title'    => esc_attr__( 'Text for Business Hours at header #8', 'the-lawyer' ),
            'default'  => 'Meeting Time',
        ),
        array(
            'id'       => 'office_address_text',
            'type'     => 'text',
            'title'    => esc_attr__( 'Text for Office Address at header #8', 'the-lawyer' ),
            'default'  => 'Office Address',
        ),
    )
) );

/*
 * <--- END SECTIONS
 */
// -> START Design Tab
Redux::setSection( $opt_name, array(
    'title'  => esc_attr__( 'Social', 'the-lawyer' ),
    'id'     => 'social',
    'icon'   => 'el el-adult',
    'fields' => array(
        array(
            'id'       => 'header-social-buttons',
            'type'     => 'switch',
            'title'    => esc_attr__( 'Display social buttons', 'the-lawyer' ),
            'default'  => true,
            'indent'   => true
        ),
        array(
            'id'       => 'header-social-buttons-section',
            'type'     => 'section',
            'indent'   => true
        ),
            array(
                'id'       => 'social_link_facebook',
                'type'     => 'text',
                'title'    => esc_attr__( 'Facebook', 'the-lawyer' ),
                'subtitle' => esc_attr__( 'type here link to your facebook profile or page', 'the-lawyer' ),
                'required' => array( 'header-social-buttons', '=', true ),
                'default'  => 'http://fb.com/',
            ),

            array(
                'id'       => 'social_link_twitter',
                'type'     => 'text',
                'title'    => esc_attr__( 'Twitter', 'the-lawyer' ),
                'subtitle' => esc_attr__( 'type here link to your twitter profile', 'the-lawyer' ),
                'required' => array( 'header-social-buttons', '=', true ),
                'default'  => 'http://twitter.com/',
            ),
            array(
                'id'       => 'social_link_myspace',
                'type'     => 'text',
                'title'    => esc_attr__( 'MySpace', 'the-lawyer' ),
                'subtitle' => esc_attr__( 'type here link to your MySpace profile', 'the-lawyer' ),
                'required' => array( 'header-social-buttons', '=', true ),
            ),
            array(
                'id'       => 'social_link_linkedin',
                'type'     => 'text',
                'title'    => esc_attr__( 'LinkedIn', 'the-lawyer' ),
                'subtitle' => esc_attr__( 'type here link to your LinkedIn profile', 'the-lawyer' ),
                'required' => array( 'header-social-buttons', '=', true ),
                'default'  => 'http://linkedin.com/',
            ),
            array(
                'id'       => 'social_link_google',
                'type'     => 'text',
                'title'    => esc_attr__( 'Google+', 'the-lawyer' ),
                'subtitle' => esc_attr__( 'type here link to your Google+ profile or page', 'the-lawyer' ),
                'required' => array( 'header-social-buttons', '=', true ),
                'default'  => 'http://plus.google.com/',
            ),
            array(
                'id'       => 'social_link_tumblr',
                'type'     => 'text',
                'title'    => esc_attr__( 'Tumblr', 'the-lawyer' ),
                'subtitle' => esc_attr__( 'type here link to your Tumblr', 'the-lawyer' ),
                'required' => array( 'header-social-buttons', '=', true ),
            ),
            array(
                'id'       => 'social_link_pinterest',
                'type'     => 'text',
                'title'    => esc_attr__( 'Pinterest', 'the-lawyer' ),
                'subtitle' => esc_attr__( 'type here link to your Pinterest', 'the-lawyer' ),
                'required' => array( 'header-social-buttons', '=', true ),
            ),
            array(
                'id'       => 'social_link_youtube',
                'type'     => 'text',
                'title'    => esc_attr__( 'YouTube', 'the-lawyer' ),
                'subtitle' => esc_attr__( 'type here link to your YouTube', 'the-lawyer' ),
                'required' => array( 'header-social-buttons', '=', true ),
            ),
            array(
                'id'       => 'social_link_instagram',
                'type'     => 'text',
                'title'    => esc_attr__( 'Instagram', 'the-lawyer' ),
                'subtitle' => esc_attr__( 'type here link to your Instagram', 'the-lawyer' ),
                'required' => array( 'header-social-buttons', '=', true ),
            ),
            array(
                'id'       => 'social_link_vkcom',
                'type'     => 'text',
                'title'    => esc_attr__( 'vk.com', 'the-lawyer' ),
                'subtitle' => esc_attr__( 'type here link to your vk.com', 'the-lawyer' ),
                'required' => array( 'header-social-buttons', '=', true ),
            ),
            array(
                'id'       => 'social_link_reddit',
                'type'     => 'text',
                'title'    => esc_attr__( 'Reddit', 'the-lawyer' ),
                'subtitle' => esc_attr__( 'type here link to your Reddit', 'the-lawyer' ),
                'required' => array( 'header-social-buttons', '=', true ),
            ),
            array(
                'id'       => 'social_link_blogger',
                'type'     => 'text',
                'title'    => esc_attr__( 'Blogger', 'the-lawyer' ),
                'subtitle' => esc_attr__( 'type here link to your Blogger', 'the-lawyer' ),
                'required' => array( 'header-social-buttons', '=', true ),
            ),
            array(
                'id'       => 'social_link_wordpress',
                'type'     => 'text',
                'title'    => esc_attr__( 'Wordpress', 'the-lawyer' ),
                'subtitle' => esc_attr__( 'type here link to your Wordpress', 'the-lawyer' ),
                'required' => array( 'header-social-buttons', '=', true ),
            ),
            array(
                'id'       => 'social_link_behance',
                'type'     => 'text',
                'title'    => esc_attr__( 'Behance', 'the-lawyer' ),
                'subtitle' => esc_attr__( 'type here link to your Behance', 'the-lawyer' ),
                'required' => array( 'header-social-buttons', '=', true ),
            ),
        array(
            'id'     => 'social_section_end',
            'type'   => 'section',
            'indent' => false,
        ),
    )
) );
/*
 * <--- END SECTIONS
 */
// -> START Design Tab
Redux::setSection( $opt_name, array(
    'title'  => esc_attr__( 'Design', 'the-lawyer' ),
    'id'     => 'design',
    'desc'   => esc_attr__( 'Design settings for customization.', 'the-lawyer' ),
    'icon'   => 'el el-brush',
    'fields' => array(

    )
) );

        // Layout Design Tab
    Redux::setSection( $opt_name, array(
        'title'      => esc_attr__( 'Layout', 'the-lawyer' ),
        'id'         => 'design-layout-subsection',
        'subsection' => true,
        'fields'     => array(
            array(
                'id'            => 'transition',
                'type'          => 'slider',
                'title'         => esc_attr__( 'Transition time', 'the-lawyer' ),
                'subtitle'      => esc_attr__( 'Choose hover effects time in ms', 'the-lawyer' ),
                'desc'          => esc_attr__( 'Slider description. Min: 0, max: 1000, step: 5, default value: 600', 'the-lawyer' ),
                'default'       => 400,
                'min'           => 0,
                'step'          => 5,
                'max'           => 1000,
                'display_value' => 'text'
            ),
            array(
                'id'       => 'rtloption',
                'type'     => 'switch',
                'title'    => esc_attr__( 'Turn RTL mode', 'the-lawyer' ),
                'subtitle' => esc_attr__( 'Press ON if you need to support Right-to-left language', 'the-lawyer' ),
                'default'  => false,
            ),
            array(
                'id'       => 'rtlcarousel',
                'type'     => 'switch',
                'title'    => esc_attr__( 'RTL mode for carousels', 'the-lawyer' ),
                'subtitle' => esc_attr__( 'Press ON if you need to support team|testimonials carousels', 'the-lawyer' ),
                'default'  => false,
            ),

            array(
                'id'       => 'design-css',
                'type'     => 'image_select',
                'title'    => esc_attr__( 'Choose design', 'the-lawyer' ),
                'subtitle' => esc_attr__( 'Also you need to set up color scheme', 'the-lawyer' ),
                //Must provide key => value(array:title|img) pairs for radio options
                'options'  => array(
                    '1' => array(
                        'alt' => 'Design 1: Light Version',
                        'img' => get_template_directory_uri() . '/images/framework/1.jpg'
                    ),
                    '2' => array(
                        'alt' => 'Design 1: Dark version',
                        'img' => get_template_directory_uri() . '/images/framework/2.jpg'
                    ),
                    '3' => array(
                        'alt' => 'Design 2: Light version',
                        'img' => get_template_directory_uri() . '/images/framework/3.jpg'
                    ),
                ),
                'default'  => '1'
            ),

            array(
                'id'       => 'design-layout',
                'type'     => 'image_select',
                'title'    => esc_attr__( 'Choose page layout', 'the-lawyer' ),

                //Must provide key => value(array:title|img) pairs for radio options
                'options'  => array(
                   '1' => array(
                        'alt' => 'Full width layout',
                        'img' => get_template_directory_uri() . '/images/framework/full.gif'
                    ),
                    '2' => array(
                        'alt' => 'Boxed layout, maximum resolution - 1170 px',
                        'img' => get_template_directory_uri() . '/images/framework/boxed.gif'
                    )
                ),
                'default'  => '1'
            ),
                array(
                    'id'        => 'boxed-background-color',
                    'type'      => 'color_rgba',
                    'title'     => esc_attr__('Choose background color for box', 'the-lawyer' ),
                    'output'    => array('background-color' => '.mainbgr'),
                    'default'   => array(
                        'color'     => '#323232',
                        'alpha'     => 1
                    ),
                    'required'  => array('design-layout', '=', '2')
                ),
                array(
                    'id'       => 'boxed-background',
                    'type'     => 'media',
                    'title'    => esc_attr__( 'Box Background', 'the-lawyer' ),
                    'subtitle' => esc_attr__( 'Upload your background for box', 'the-lawyer' ),
                    'output'    => array('background-image' => '.mainbgr'),
                    'default'  => array(
                       'url'=> esc_url(get_template_directory_uri()).'/images/bgr.jpg'
                    ),
                    'required'  => array('design-layout', '=', '2')
                ),
                array(
                    'id'        => 'content-background-color',
                    'type'      => 'color_rgba',
                    'title'     => esc_attr__('Choose background color for content-section', 'the-lawyer' ),
                    'output'    => array('background-color' => 'main'),
                    'default'   => array(
                        'color'     => '#FFF',
                        'alpha'     => 1
                    ),
                    'required'  => array('design-layout', '=', '2')
                ),
            array(
                'id'       => 'sidebar-layout',
                'type'     => 'image_select',
                'title'    => esc_attr__( 'Choose sidebar option', 'the-lawyer' ),

                //Must provide key => value(array:title|img) pairs for radio options
                'options'  => array(
                    '1' => array(
                        'alt' => 'Without sidebar',
                        'img' => get_template_directory_uri() . '/images/framework/nosidebar.gif'
                    ),
                    '2' => array(
                        'alt' => '2 sidebars',
                        'img' => get_template_directory_uri() . '/images/framework/2sidebars.gif'
                    ),
                    '3' => array(
                        'alt' => 'Left sidebar',
                        'img' => get_template_directory_uri() . '/images/framework/leftsidebar.gif'
                    ),
                    '4' => array(
                        'alt' => 'Right sidebar',
                        'img' => get_template_directory_uri() . '/images/framework/rightsidebar.gif'
                    )
                ),
                'default'  => '1'
            ),
            array(
                'id'       => 'single-header',
                'type'     => 'switch',
                'title'    => esc_attr__( 'Display Page H1 Heading', 'the-lawyer' ),
                'subtitle'    => esc_attr__( 'Do you want to show H1 heading for pages?', 'the-lawyer' ),
                'default'  => false,
                'indent'   => false
            ),
            array(
                'id'       => 'single-post-header',
                'type'     => 'switch',
                'title'    => esc_attr__( 'Display Post H1 Heading', 'the-lawyer' ),
                'subtitle'    => esc_attr__( 'Do you want to show H1 heading for blog posts?', 'the-lawyer' ),
                'default'  => false,
                'indent'   => false
            ),
        )
    ) );

    Redux::setSection( $opt_name, array(
        'title'      => esc_attr__( 'Header', 'the-lawyer' ),
        'id'         => 'design-header-subsection',
        'subsection' => true,
        'fields'     => array(
            array(
                'id'        => 'header-layout_info_notice',
                'type'      => 'info',
                'notice'    => true,
                'style'     => 'info',
                'icon'      => 'el-icon-info-sign',
                'title'     => esc_attr__('Note', 'the-lawyer'),
                'desc'      => esc_attr__('Some header required dark version of logo', 'the-lawyer'),
            ),
            array(
                'id'       => 'header-layout',
                'type'     => 'image_select',
                'title'    => esc_attr__( 'Choose header & menu type', 'the-lawyer' ),
                //Must provide key => value(array:title|img) pairs for radio options
                'options'  => array(
                    '1' => array(
                        'alt' => 'Menuline',
                        'img' => get_template_directory_uri() . '/images/framework/h4.jpg'
                    ),
                    '2' => array(
                        'alt' => 'Transparent menu',
                        'img' => get_template_directory_uri() . '/images/framework/h1.jpg'
                    ),
                    '3' => array(
                        'alt' => 'Hidden menu',
                        'img' => get_template_directory_uri() . '/images/framework/h8.jpg'
                    ),
                    '4' => array(
                        'alt' => 'Short header with hidden menu',
                        'img' => get_template_directory_uri() . '/images/framework/h10.jpg'
                    ),
                    '7' => array(
                        'alt' => 'Menu with CTA-button',
                        'img' => get_template_directory_uri() . '/images/framework/h11.jpg'
                    ),
                    '8' => array(
                        'alt' => 'Menu with big topbar',
                        'img' => get_template_directory_uri() . '/images/framework/h12.jpg'
                    ),
                ),
                'default'  => '1'
            ),
            /*======== Slider ==========*/
                 array(
                    'id'       => 'header14_slider',
                    'type'     => 'select',
                    'title'    => esc_attr__( 'Choose Slider', 'the-lawyer' ),
                    'subtitle' => esc_attr__( 'Choose slider for header section', 'the-lawyer' ),
                    //Must provide key => value(array:title|img) pairs for radio options
                    'options'  => thelawyer_get_sliders_array(),
                    'default'  => 'rev_short-slider',
                ),


            array(
                'id'       => 'section-topbar',
                'type'     => 'section',
                'title'    => esc_attr__( 'Topbar Settings', 'the-lawyer' ),
                'indent'   => true, // Indent all options below until the next 'section' option is set.
            ),
            array(
                'id'       => 'header-topbar',
                'type'     => 'switch',
                'title'    => esc_attr__( 'Show header topbar?', 'the-lawyer' ),
                'subtitle' => esc_attr__( 'Topbar with phone number, email and social buttons.', 'the-lawyer' ),
                'default'  => true,
            ),
            array(
                 'id'       => 'header-search',
                 'type'     => 'switch',
                 'title'    => esc_attr__( 'Display search icon in header?', 'the-lawyer' ),
                 'default'  => true
             ),



            array(
                'id'       => 'topbar-cta',
                'type'     => 'switch',
                'title'    => esc_attr__( 'Display Call-to-Action button on header?', 'the-lawyer' ),
                'default'  => true,
            ),

            array(
                'id'       => 'topbar-cta-url',
                'type'     => 'text',
                'title'    => esc_attr__( 'URL of Button', 'the-lawyer' ),
                'subtitle' => esc_attr__( 'URL for Call-to-Action button', 'the-lawyer' ),
                'default'  => '/contacts/',
                'required' => array(array( 'topbar-cta', '=', '1'))
            ),
            array(
                'id'       => 'topbar-cta-buttontext',
                'type'     => 'text',
                'title'    => esc_attr__( 'Text of Button', 'the-lawyer' ),
                'subtitle' => esc_attr__( 'Text for Call-to-Action button', 'the-lawyer' ),
                'default'  => 'Buy the theme!',
                'required' => array(array( 'topbar-cta', '=', '1'))
            ),
            array(
                'id'       => 'tctat',
                'type'     => 'color_rgba',
                'title'    => esc_attr__( 'Button Text Color', 'the-lawyer' ),
                'default'  => array(
                    'color' => '#ffffff',
                    'alpha' => '1'
                ),
                'compiler'  => true,
                'output'    => false,
                'required' => array(array( 'topbar-cta', '=', '1'))
            ),
            array(
                'id'       => 'tctab',
                'type'     => 'color_rgba',
                'title'    => esc_attr__( 'Button Background Color', 'the-lawyer' ),
                'default'  => array(
                    'color' => '#c79d52',
                    'alpha' => '1'
                ),
                'compiler'  => true,
                'output'    => false,
                'required' => array(array( 'topbar-cta', '=', '1'))
            ),
            array(
                'id'       => 'tctath',
                'type'     => 'color_rgba',
                'title'    => esc_attr__( 'Button Text Color (Color)', 'the-lawyer' ),
                'default'  => array(
                    'color' => '#ffffff',
                    'alpha' => '1'
                ),
                'compiler'  => true,
                'output'    => false,
                'required' => array(array( 'topbar-cta', '=', '1'))
            ),
            array(
                'id'       => 'tctabh',
                'type'     => 'color_rgba',
                'title'    => esc_attr__( 'Button Background Color (Color)', 'the-lawyer' ),
                'default'  => array(
                    'color' => '#e5c07d',
                    'alpha' => '1'
                ),
                'compiler'  => true,
                'output'    => false,
                'required' => array(array( 'topbar-cta', '=', '1'))
            ),



            array(
                'id'     => 'section-topbar-end',
                'type'   => 'section',
                'indent' => false, //
            ),

        )
    ) );

    Redux::setSection( $opt_name, array(
        'title'      => esc_attr__( 'Footer', 'the-lawyer' ),
        'id'         => 'design-footer-subsection',
        'subsection' => true,
        'fields'     => array(
            array(
                'id'       => 'footer-type-layout',
                'type'     => 'image_select',
                'title'    => esc_attr__( 'Choose type of footer', 'the-lawyer' ),
                //'required'  => array('footer-type-layout', '=', '1')
                'options'  => array(
                    '1' => array(
                        'alt' => '2 tabs',
                        'img' => get_template_directory_uri() . '/images/framework/footer1.jpg'
                    ),
                    '2' => array(
                        'alt' => 'Customized footer',
                        'img' => get_template_directory_uri() . '/images/framework/footer2.jpg'
                    ),
                ),
                'default'  => '1'
            ),
            array(
                'id'       => 'social-footer',
                'type'     => 'switch',
                'title'    => esc_attr__( 'Display social buttons on the footer?', 'the-lawyer' ),
                'default'  => true,
                'required'  => array('footer-type-layout', '=', '1')
            ),
            array(
                'id'       => 'address-footer',
                'type'     => 'switch',
                'title'    => esc_attr__( 'Display address section on the footer?', 'the-lawyer' ),
                'default'  => true,
                'required'  => array('footer-type-layout', '=', '1')
            ),
            array(
                'id'      => 'copyr-text',
                'type'    => 'text',
                'title'   => esc_attr__( 'Footer Copyright Text', 'the-lawyer' ),
                'subtitle' => esc_attr__( 'For display at footer after "&copy; "', 'the-lawyer' ),
                'default' => 'All Rights Reserved. The Lawyer Agency',
                'required'  => array('footer-type-layout', '=', '1')
            ),
            array(
                'id'       => 'footer-background',
                'type'     => 'background',
                'title'    => esc_attr__( 'Background for footer section', 'the-lawyer' ),
                'output'    => array('background-image, background-color, background-repeat, background-attachment, background-size, background-position' => '.footer'
                ),
                'default'  => array(
                    'background-color' => '#2a2e32',
                    'background-repeat' => 'no-repeat',
                    'background-attachment' => 'fixed',
                    'background-size' => 'cover',
                    'background-position' => 'center top',
                    'background-image' => esc_url(get_template_directory_uri()).'/images/footer-bg.jpg',
                ),
                
            ),

        )
    ) );
Redux::setSection( $opt_name, array(
    'title'      => esc_attr__( 'Menu', 'the-lawyer' ),
    'id'         => 'menudes',
    'subsection' => true,
    'fields'     => array(
        array(
            'id'       => 'search_icon_menu',
            'type'     => 'switch',
            'title'    => esc_attr__( 'Show Search in Header Menu?', 'the-lawyer' ),
            'default'  => true
        ),
        /* === Sticky Setting  === */
                    array(
                        'id'       => 'sticky-menu',
                        'type'     => 'switch',
                        'title'    => esc_attr__( 'Use sticky menu?', 'the-lawyer' ),
                        'default'  => true,
                    ),
        array(
            'id'        => 'header-background-sticky-menu',
            'type'      => 'color_rgba',
            'title'     => esc_attr__( 'Background color for sticky menu on Header 1 and 5', 'the-lawyer' ),
            'output'    => array('background-color' => '#stickymenu.whitelinemenu.fixed'),
            'default'   => array(
                'color'     => '#FFFFFF',
                'alpha'     => 1,
                'important' => true
            ),
            'required' => array(
                array('sticky-menu','!=','0')
            )
        ),
        array(// its for header 2
            'id'        => 'header2-background-sticky-menu',
            'type'      => 'color_rgba',
            'title'     => esc_attr__( 'Background color for sticky menu on Header 2', 'the-lawyer' ),
            'output'    => array('background-color' => '.menuover #stickymenu.whitelinemenu.fixed'),
            'default'   => array(
                'color'     => '#1c2329',
                'alpha'     => 0.85,
                'important' => true
            ),
            'required' => array(
                array('sticky-menu','!=','0')
            )
        ),
        array(// its for header 4
            'id'        => 'header4-background-sticky-menu',
            'type'      => 'color_rgba',
            'title'     => esc_attr__( 'Background color for sticky menu on Header 4', 'the-lawyer' ),
            'output'    => array('background-color' => '.shortheader1 #stickymenu.whitelinemenu.fixed'),
            'default'   => array(
                'color'     => '#FFFFFF',
                'alpha'     => 0.95,
                'important' => true
            ),
            'required' => array(
                array('sticky-menu','!=','0')
            )
        ),
        array(// its for header 5
            'id'        => 'header5-background-sticky-menu',
            'type'      => 'color_rgba',
            'title'     => esc_attr__( 'Background color for sticky menu on Header 5', 'the-lawyer' ),
            'output'    => array('background-color' => '.head7 #stickymenu.whitelinemenu.fixed'),
            'default'   => array(
                'color'     => '#FFFFFF',
                'alpha'     => 0.95,
                'important' => true
            ),
            'required' => array(
                array('sticky-menu','!=','0')
            )
        ),
        array(// its for header 8
            'id'        => 'header8-background-sticky-menu',
            'type'      => 'color_rgba',
            'title'     => esc_attr__( 'Background color for sticky menu on Header 8', 'the-lawyer' ),
            'output'    => array('background-color' => '.head8 #stickymenu.whitelinemenu.fixed'),
            'default'   => array(
                'color'     => '#0e4466',
                'alpha'     => 0.95,
                'important' => true
            ),
            'required' => array(
                array('sticky-menu','!=','0')
            )
        ),

        /* === Headers Sticky END === */
        array(
            'id'       => 'menu-font',
            'type'     => 'typography',
            'title'    => esc_attr__( 'Menu Font', 'the-lawyer' ),
            'subtitle' => esc_attr__( 'Specify the menu font properties.', 'the-lawyer' ),
            'font-backup' => false,
            'google'   => true,
            'color'     => false,
            'default'  => array(
                'font-size'   => '15px',
                'font-family' => 'Roboto',
                'font-weight'  => '500',
                'line-height'   => '23px',
                'subsets'        => 'latin'
            ),
        ),

        //Section START Header 1 and 4 colors
        array(
            'id'       => 'menu-header1-section-start',
            'type'     => 'section',
            'title'    => esc_attr__( 'Colors for menu and topbar for Header 1 and 4', 'the-lawyer' ),
            'indent'   => true, // Indent all options below until the next 'section' option is set.
        ),
        array(
            'id'       => 'mh1c1',
            'type'     => 'color_rgba',
            'title'    => esc_attr__( 'Topbar Background Color', 'the-lawyer' ),
            'default'  => array(
                'color' => '#171b21',
                'alpha' => '1'
            ),
            'compiler'  => true,
            'output'    => false,
        ),
        array(
            'id'       => 'mh1c2',
            'type'     => 'color_rgba',
            'title'    => esc_attr__( 'Text Color for Topbar', 'the-lawyer' ),
            'default'  => array(
                'color' => '#f3f3f3',
                'alpha' => '1'
            ),
            'compiler'  => true,
            'output'    => false,
        ),
        array(
            'id'       => 'mh1c3',
            'type'     => 'color_rgba',
            'title'    => esc_attr__( 'Background Color for Menu Line', 'the-lawyer' ),
            'default'  => array(
                'color' => '#ffffff',
                'alpha' => '1'
            ),
            'compiler'  => true,
            'output'    => false,
        ),
        array(
            'id'       => 'mh1c4',
            'type'     => 'color_rgba',
            'title'    => esc_attr__( 'Top Level Links Color', 'the-lawyer' ),
            'default'  => array(
                'color' => '#5a5a5a',
                'alpha' => '1'
            ),
            'compiler'  => true,
            'output'    => false,
        ),
        array(
            'id'       => 'mh1c5',
            'type'     => 'color_rgba',
            'title'    => esc_attr__( 'Top Level Links Color (hover)', 'the-lawyer' ),
            'default'  => array(
                'color' => '#ffffff',
                'alpha' => '1'
            ),
            'compiler'  => true,
            'output'    => false,
        ),
        array(
            'id'       => 'mh1c6',
            'type'     => 'color_rgba',
            'title'    => esc_attr__( 'Top Level Links Background (hover)', 'the-lawyer' ),
            'default'  => array(
                'color' => '#c79d52',
                'alpha' => '1'
            ),
            'compiler'  => true,
            'output'    => false,
        ),
        array(
            'id'     => 'menu-header1-section-end',
            'type'   => 'section',
            'indent' => false, // Indent all options below until the next 'section' option is set.
        ),
        // Section END
        //Section START Header 2 colors
        array(
            'id'       => 'menu-header2-section-start',
            'type'     => 'section',
            'title'    => esc_attr__( 'Colors for menu and topbar for Header 2', 'the-lawyer' ),
            'indent'   => true, // Indent all options below until the next 'section' option is set.
        ),
        array(
            'id'       => 'mh2c1',
            'type'     => 'color_rgba',
            'title'    => esc_attr__( 'Topbar Background Color', 'the-lawyer' ),
            'default'  => array(
                'color' => '#ffffff',
                'alpha' => '0'
            ),
            'compiler'  => true,
            'output'    => false,
        ),
        array(
            'id'       => 'mh2c2',
            'type'     => 'color_rgba',
            'title'    => esc_attr__( 'Text Color for Topbar', 'the-lawyer' ),
            'default'  => array(
                'color' => '#f3f3f3',
                'alpha' => '1'
            ),
            'compiler'  => true,
            'output'    => false,
        ),
        array(
            'id'       => 'mh2c3',
            'type'     => 'color_rgba',
            'title'    => esc_attr__( 'Background Color for Menu Line', 'the-lawyer' ),
            'default'  => array(
                'color' => '#ffffff',
                'alpha' => '0'
            ),
            'compiler'  => true,
            'output'    => false,
        ),
        array(
            'id'       => 'mh2c4',
            'type'     => 'color_rgba',
            'title'    => esc_attr__( 'Top Level Links Color', 'the-lawyer' ),
            'default'  => array(
                'color' => '#ffffff',
                'alpha' => '1'
            ),
            'compiler'  => true,
            'output'    => false,
        ),
        array(
            'id'       => 'mh2c5',
            'type'     => 'color_rgba',
            'title'    => esc_attr__( 'Top Level Links Color (hover)', 'the-lawyer' ),
            'default'  => array(
                'color' => '#ffffff',
                'alpha' => '1'
            ),
            'compiler'  => true,
            'output'    => false,
        ),
        array(
            'id'       => 'mh2c6',
            'type'     => 'color_rgba',
            'title'    => esc_attr__( 'Top Level Links Border (hover)', 'the-lawyer' ),
            'default'  => array(
                'color' => '#dfb466',
                'alpha' => '1'
            ),
            'compiler'  => true,
            'output'    => false,
        ),
        array(
            'id'     => 'menu-header2-section-end',
            'type'   => 'section',
            'indent' => false, // Indent all options below until the next 'section' option is set.
        ),
        // Section END

        //Section START
        array(
            'id'       => 'menu-header3-section-start',
            'type'     => 'section',
            'title'    => esc_attr__( 'Colors for menu and topbar for Header 3', 'the-lawyer' ),
            'indent'   => true, // Indent all options below until the next 'section' option is set.
        ),

        array(
            'id'       => 'mh3c2',
            'type'     => 'color_rgba',
            'title'    => esc_attr__( 'Text Color for phones and menu button', 'the-lawyer' ),
            'default'  => array(
                'color' => '#ffffff',
                'alpha' => '1'
            ),
            'compiler'  => true,
            'output'    => false,
        ),
        array(
            'id'       => 'mh3c1',
            'type'     => 'color_rgba',
            'title'    => esc_attr__( 'Menu Container Background Color', 'the-lawyer' ),
            'default'  => array(
                'color' => '#000000',
                'alpha' => '0.82'
            ),
            'compiler'  => true,
            'output'    => false,
        ),
        array(
            'id'       => 'mh3c3',
            'type'     => 'color_rgba',
            'title'    => esc_attr__( 'Color for Phone and Close Button in Menu Container', 'the-lawyer' ),
            'default'  => array(
                'color' => '#ffffff',
                'alpha' => '1'
            ),
            'compiler'  => true,
            'output'    => false,
        ),
        array(
            'id'       => 'mh3c4',
            'type'     => 'color_rgba',
            'title'    => esc_attr__( 'Top Level Links Color', 'the-lawyer' ),
            'default'  => array(
                'color' => '#ffffff',
                'alpha' => '1'
            ),
            'compiler'  => true,
            'output'    => false,
        ),
        array(
            'id'       => 'mh3c5',
            'type'     => 'color_rgba',
            'title'    => esc_attr__( 'Top Level Links Color (hover)', 'the-lawyer' ),
            'default'  => array(
                'color' => '#e5c07d',
                'alpha' => '1'
            ),
            'compiler'  => true,
            'output'    => false,
        ),
        array(
            'id'       => 'mh3c6',
            'type'     => 'color_rgba',
            'title'    => esc_attr__( 'Top Level Links Background (hover)', 'the-lawyer' ),
            'default'  => array(
                'color' => '#ffffff',
                'alpha' => '0'
            ),
            'compiler'  => true,
            'output'    => false,
        ),
        array(
            'id'     => 'menu-header3-section-end',
            'type'   => 'section',
            'indent' => false, // Indent all options below until the next 'section' option is set.
        ),
        // Section END

        //Section START Header 7 colors
        array(
            'id'       => 'menu-header5-section-start',
            'type'     => 'section',
            'title'    => esc_attr__( 'Colors for menu and topbar for Header 5', 'the-lawyer' ),
            'indent'   => true, // Indent all options below until the next 'section' option is set.
        ),
        array(
            'id'       => 'mh5c1',
            'type'     => 'color_rgba',
            'title'    => esc_attr__( 'Topbar Background Color', 'the-lawyer' ),
            'default'  => array(
                'color' => '#0e4466',
                'alpha' => '0'
            ),
            'compiler'  => true,
            'output'    => false,
        ),
        array(
            'id'       => 'mh5c2',
            'type'     => 'color_rgba',
            'title'    => esc_attr__( 'Text Color for Topbar', 'the-lawyer' ),
            'default'  => array(
                'color' => '#ffffff',
                'alpha' => '1'
            ),
            'compiler'  => true,
            'output'    => false,
        ),
        array(
            'id'       => 'mh5c3',
            'type'     => 'color_rgba',
            'title'    => esc_attr__( 'Background Color for Menu Line', 'the-lawyer' ),
            'default'  => array(
                'color' => '#ffffff',
                'alpha' => '1'
            ),
            'compiler'  => true,
            'output'    => false,
        ),
        array(
            'id'       => 'mh5c4',
            'type'     => 'color_rgba',
            'title'    => esc_attr__( 'Top Level Links Color', 'the-lawyer' ),
            'default'  => array(
                'color' => '#231f20',
                'alpha' => '1'
            ),
            'compiler'  => true,
            'output'    => false,
        ),
        array(
            'id'       => 'mh5c5',
            'type'     => 'color_rgba',
            'title'    => esc_attr__( 'Top Level Links Color (hover)', 'the-lawyer' ),
            'default'  => array(
                'color' => '#231f20',
                'alpha' => '1'
            ),
            'compiler'  => true,
            'output'    => false,
        ),
        array(
            'id'       => 'mh5c6',
            'type'     => 'color_rgba',
            'title'    => esc_attr__( 'Top Level Links Border (hover)', 'the-lawyer' ),
            'default'  => array(
                'color' => '#fa5c65',
                'alpha' => '1'
            ),
            'compiler'  => true,
            'output'    => false,
        ),
        array(
            'id'     => 'menu-header5-section-end',
            'type'   => 'section',
            'indent' => false, // Indent all options below until the next 'section' option is set.
        ),
        // Section END

        //Section START Header 8 colors
        array(
            'id'       => 'menu-header8-section-start',
            'type'     => 'section',
            'title'    => esc_attr__( 'Colors for menu and topbar for Header 8', 'the-lawyer' ),
            'indent'   => true, // Indent all options below until the next 'section' option is set.
        ),
        array(
            'id'       => 'mh8c1',
            'type'     => 'color_rgba',
            'title'    => esc_attr__( 'Topbar Background Color', 'the-lawyer' ),
            'default'  => array(
                'color' => '#ffffff',
                'alpha' => '1'
            ),
            'compiler'  => true,
            'output'    => false,
        ),
        array(
            'id'       => 'mh8c2',
            'type'     => 'color_rgba',
            'title'    => esc_attr__( 'Text Color for Topbar', 'the-lawyer' ),
            'default'  => array(
                'color' => '#165075',
                'alpha' => '1'
            ),
            'compiler'  => true,
            'output'    => false,
        ),
        array(
            'id'       => 'mh8c3',
            'type'     => 'color_rgba',
            'title'    => esc_attr__( 'Background Color for Menu Line', 'the-lawyer' ),
            'default'  => array(
                'color' => '#ffffff',
                'alpha' => '0'
            ),
            'compiler'  => true,
            'output'    => false,
        ),
        array(
            'id'       => 'mh8c4',
            'type'     => 'color_rgba',
            'title'    => esc_attr__( 'Top Level Links Color', 'the-lawyer' ),
            'default'  => array(
                'color' => '#ffffff',
                'alpha' => '1'
            ),
            'compiler'  => true,
            'output'    => false,
        ),
        array(
            'id'       => 'mh8c5',
            'type'     => 'color_rgba',
            'title'    => esc_attr__( 'Top Level Links Color (hover)', 'the-lawyer' ),
            'default'  => array(
                'color' => '#fa5c65',
                'alpha' => '1'
            ),
            'compiler'  => true,
            'output'    => false,
        ),
        array(
            'id'       => 'mh8c6',
            'type'     => 'color_rgba',
            'title'    => esc_attr__( 'Top Level Links Border (hover)', 'the-lawyer' ),
            'default'  => array(
                'color' => '#fa5c65',
                'alpha' => '1'
            ),
            'compiler'  => true,
            'output'    => false,
        ),
        array(
            'id'     => 'menu-header8-section-end',
            'type'   => 'section',
            'indent' => false, // Indent all options below until the next 'section' option is set.
        ),
        // Section END
    )
));

// Services Design Tab
Redux::setSection( $opt_name, array(
    'title'      => esc_attr__( 'Custom Post Types', 'the-lawyer' ),
    'id'         => 'services-subsection',
    'subsection' => true,
    'fields'     => array(
        array(
            'id'       => 'lawyer_serv_col',
            'type'     => 'radio',
            'title'    => esc_attr__( 'Services Columns', 'the-lawyer' ),
            'subtitle' => esc_attr__( 'How many columns do you want to display on Services List page?', 'the-lawyer' ),
            //Must provide key => value pairs for radio options
            'options'  => array(
                '1' => '2 Columns',
                '2' => '3 Columns',
                '3' => '4 Columns'
            ),
            'default'  => '1'
        ),
        array(
            'id'       => 'services_arch_title',
            'type'     => 'text',
            'title'    => esc_attr__( 'Services Page H1 Heading', 'the-lawyer' ),
            'subtitle' => esc_attr__( 'Set H1 heading for Services Archive page', 'the-lawyer' ),
            'default'  => 'Services List',
        ),
        array(
            'id'       => 'services_arch_desc',
            'type'     => 'editor',
            'title'    => esc_attr__( 'Description Text Under H1 Heading', 'the-lawyer' ),
            'subtitle' => esc_attr__( 'Allowed tags: a, img, br, em, strong, h1, h2, h3, h4, h5, h6, p, b, i, u, ol, ul, li, code, del', 'the-lawyer' ),
            'default'  => '',
        ),
        array(
            'id'       => 'lawyer_cases_col',
            'type'     => 'radio',
            'title'    => esc_attr__( 'Case Studies Columns', 'the-lawyer' ),
            'subtitle' => esc_attr__( 'How many columns do you want to display on Case Studies List page?', 'the-lawyer' ),
            //Must provide key => value pairs for radio options
            'options'  => array(
                '1' => '2 Columns',
                '2' => '3 Columns',
                '3' => '4 Columns'
            ),
            'default'  => '1'
        ),
        array(
            'id'       => 'cases_arch_title',
            'type'     => 'text',
            'title'    => esc_attr__( 'Case Studies Page H1 Heading', 'the-lawyer' ),
            'subtitle' => esc_attr__( 'Set H1 heading for Case Studies Archive page', 'the-lawyer' ),
            'default'  => 'Case Studies List',
        ),
        array(
            'id'       => 'portfolio_arch_desc',
            'type'     => 'editor',
            'title'    => esc_attr__( 'Description Text Under H1 Heading', 'the-lawyer' ),
            'subtitle' => esc_attr__( 'Allowed tags: a, img, br, em, strong, h1, h2, h3, h4, h5, h6, p, b, i, u, ol, ul, li, code, del', 'the-lawyer' ),
            'default'  => '',
        ),

        array(
            'id'       => 'teammate_arch_title',
            'type'     => 'text',
            'title'    => esc_attr__( 'Teammates Page H1 Heading', 'the-lawyer' ),
            'subtitle' => esc_attr__( 'Set H1 heading for Teammates Archive page', 'the-lawyer' ),
            'default'  => 'Teammates',
        ),
        array(
            'id'       => 'team_arch_desc',
            'type'     => 'editor',
            'title'    => esc_attr__( 'Description Text Under H1 Heading', 'the-lawyer' ),
            'subtitle' => esc_attr__( 'Allowed tags: a, img, br, em, strong, h1, h2, h3, h4, h5, h6, p, b, i, u, ol, ul, li, code, del', 'the-lawyer' ),
            'default'  => '',
        ),
        array(
            'id'       => 'testimonials_arch_title',
            'type'     => 'text',
            'title'    => esc_attr__( 'Testimonials Page Heading', 'the-lawyer' ),
            'subtitle' => esc_attr__( 'Set H1 heading for Testimonials Archive page', 'the-lawyer' ),
            'default'  => 'Testimonials',
        ),
        array(
            'id'       => 'testi_arch_desc',
            'type'     => 'editor',
            'title'    => esc_attr__( 'Description Text Under H1 Heading', 'the-lawyer' ),
            'subtitle' => esc_attr__( 'Allowed tags: a, img, br, em, strong, h1, h2, h3, h4, h5, h6, p, b, i, u, ol, ul, li, code, del', 'the-lawyer' ),
            'default'  => '',
        ),
    )
) );
	
	/* Start Custom Section */
	
    Redux::setSection( $opt_name, array(
        'title'  => esc_attr__( 'Custom', 'the-lawyer' ),
        'id'     => 'custom_settings',
        'desc'   => esc_attr__( 'Design settings for customization.', 'the-lawyer' ),
        'icon'   => 'el el-file-edit',
        'fields' => array(
            array(
                'id'       => 'scroll-to-top',
                'type'     => 'switch',
                'title'    => esc_attr__( 'Show Scroll to Top Button?', 'the-lawyer' ),
                'default'  => true,
            ),

            array(
                'id'       => 'header-nested',
                'type'     => 'switch',
                'title'    => esc_attr__( 'Header Section JS, CSS editors', 'the-lawyer' ),
                'subtitle' => esc_attr__( 'Click On to choice of editors to appear.', 'the-lawyer' ),
                'default'  => false
            ),
            array(
                'id'       => 'header-nested-buttonset',
                'type'     => 'button_set',
                'subtitle' => esc_attr__( 'This code will appear in the HEADER secrion of the site', 'the-lawyer' ),
                'options'  => array(
                    'button-js' => 'JS editor',
                    'button-css'   => 'CSS editor',
                ),
                'required' => array( 'header-nested', '=', true ),
                'default'  => 'button-js'
            ),
			
            array(
                'id'       => 'header-nested-ace-js',
                'type'     => 'ace_editor',
				'mode'     => 'javascript',
                'title'    => esc_attr__( 'JS Editor', 'the-lawyer' ),
				'default'  => '// function hello() { alert ("HELLO"); }',
                'required' => array( 'header-nested-buttonset', '=', 'button-js' )
            ),	

            array(
                'id'       => 'header-nested-ace-css',
                'type'     => 'ace_editor',
				'mode'     => 'css',
                'title'    => esc_attr__( 'CSS Editor', 'the-lawyer' ),
				'default'  => 'body { margin : 0; padding : 0; }',
                'required' => array( 'header-nested-buttonset', '=', 'button-css' )
            ),				 
		
            array(
                'id'       => 'footer-nested',
                'type'     => 'switch',
                'title'    => esc_attr__( 'Footer Section JS, CSS editors', 'the-lawyer' ),
                'subtitle' => esc_attr__( 'Click On to choice of editors to appear.', 'the-lawyer' ),
                'default'  => false
            ),
            array(
                'id'       => 'footer-nested-buttonset',
                'type'     => 'button_set',
                'subtitle' => esc_attr__( 'This code will appear in the FOOTER secrion of the site', 'the-lawyer' ),
                'options'  => array(
                    'button-js' => 'JS editor',
                    'button-css'   => 'CSS editor',
                ),
                'required' => array( 'footer-nested', '=', true ),
                'default'  => 'button-js'
            ),
			
            array(
                'id'       => 'footer-nested-ace-js',
                'type'     => 'ace_editor',
				'mode'     => 'javascript',
                'title'    => esc_attr__( 'JS Editor', 'the-lawyer' ),
				'default'  => 'function hello() { alert ("HELLO"); }',
                'required' => array( 'footer-nested-buttonset', '=', 'button-js' )
            ),	

            array(
                'id'       => 'footer-nested-ace-css',
                'type'     => 'ace_editor',
				'mode'     => 'css',
                'title'    => esc_attr__( 'CSS Editor', 'the-lawyer' ),
				'default'  => 'body { margin : 0; padding : 0; }',
                'required' => array( 'footer-nested-buttonset', '=', 'button-css' )
            ),
        )
    ) );

    /*
     * <--- END SECTIONS
     */

// -> START Typography Settings Tab with no subsections
    Redux::setSection( $opt_name, array(
        'title'  => esc_attr__( 'Typography', 'the-lawyer' ),
        'id'     => 'typography',
        'icon'   => 'el el-fontsize',
        'fields' => array(
            array(
                'id'        => 'typography-_info_notice',
                'type'      => 'info',
                'notice'    => true,
                'style'     => 'info',
                'icon'      => 'el-icon-info-sign',
                'title'     => esc_attr__('Note', 'the-lawyer'),
                'desc'      =>esc_attr__( 'We recommend to use font pair: one font for body text and one for headings. You can find good font pair on' , 'the-lawyer' ).' <a href="http://fontpair.co/" target="_blank">http://fontpair.co/</a>',
            ),
            array(
                'id'       => 'typography-body',
                'type'     => 'typography',
                'title'    => esc_attr__( 'Body Font', 'the-lawyer' ),
                'subtitle' => esc_attr__( 'Specify the body font properties.', 'the-lawyer' ),
                'font-backup' => false,
                'google'   => true,
                'default'  => array(
                    'color'       => '#171b21',
                    'font-size'   => '16px',
                    'font-family' => 'Quattrocento Sans',
                    'font-weight'  => '400',
                    'text-align' => 'left',
                    'line-height'   => '24px',
                ),
            ),
            array(
                'id'       => 'h1-typography',
                'type'     => 'typography',
                'title'    => esc_attr__( 'Heading H1 Font', 'the-lawyer' ),
                'subtitle' => esc_attr__( 'Specify the H1 font properties.', 'the-lawyer' ),
                'font-backup' => false,
                'google'   => true,
                'text-transform' => true,
                'default'  => array(
                    'color'       => '#171b21',
                    'font-weight'  => '700',
                    'font-family' => 'Quattrocento',
                    'font-size'   => '40px',
                    'line-height' => '50px',
                    'text-transform' => 'uppercase',
                    'text-align' => 'center',
                ),
            ),
            
            array(
                'id'       => 'h2-typography',
                'type'     => 'typography',
                'title'    => esc_attr__( 'Heading H2 Font', 'the-lawyer' ),
                'subtitle' => esc_attr__( 'Specify the H2 font properties.', 'the-lawyer' ),
                'font-backup' => false,
                'google'   => true,
                'text-transform' => true,
                'default'  => array(
                    'color'       => '#171b21',
                    'font-size'   => '35px',
                    'line-height' => '45px',
                    'font-family' => 'Quattrocento',
                    'font-weight'  => '700',
                    'text-transform' => 'uppercase',
                    'text-align' => 'center',
                ),
            ),
            array(
                'id'       => 'h3-typography',
                'type'     => 'typography',
                'title'    => esc_attr__( 'Heading H3 Font', 'the-lawyer' ),
                'subtitle' => esc_attr__( 'Specify the H3 font properties.', 'the-lawyer' ),
                'font-backup' => false,
                'google'   => true,
                'text-transform' => true,
                'default'  => array(
                    'color'       => '#171b21',
                    'font-size'   => '30px',
                    'line-height' => '38px',
                    'font-family' => 'Quattrocento',
                    'font-weight'  => '700',
                    'text-transform' => 'uppercase',
                    'text-align' => 'center',
                ),
            ),
            array(
                'id'       => 'h4-typography',
                'type'     => 'typography',
                'title'    => esc_attr__( 'Heading H4 Font', 'the-lawyer' ),
                'subtitle' => esc_attr__( 'Specify the H4 font properties.', 'the-lawyer' ),
                'font-backup' => false,
                'google'   => true,
                'text-transform' => true,
                'default'  => array(
                    'color'       => '#171b21',
                    'font-size'   => '27px',
                    'line-height' => '35px',
                    'font-family' => 'Quattrocento',
                    'font-weight'  => '700',
                    'text-transform' => 'uppercase',
                    'text-align' => 'center',
                ),
            ),
            array(
                'id'       => 'h5-typography',
                'type'     => 'typography',
                'title'    => esc_attr__( 'Heading H5 Font', 'the-lawyer' ),
                'subtitle' => esc_attr__( 'Specify the H5 font properties.', 'the-lawyer' ),
                'font-backup' => false,
                'google'   => true,
                'text-transform' => true,
                'default'  => array(
                    'color'       => '#171b21',
                    'font-size'   => '22px',
                    'line-height' => '28px',
                    'font-family' => 'Quattrocento',
                    'font-weight'  => '400',
                    'text-transform' => 'uppercase',
                    'text-align' => 'center',
                ),
            ),
            array(
                'id'       => 'h6-typography',
                'type'     => 'typography',
                'title'    => esc_attr__( 'Heading H6 Font', 'the-lawyer' ),
                'subtitle' => esc_attr__( 'Specify the H6 font properties.', 'the-lawyer' ),
                'font-backup' => false,
                'google'   => true,
                'text-transform' => true,
                'default'  => array(
                    'color'       => '#171b21',
                    'font-size'   => '17px',
                    'line-height' => '23px',
                    'font-family' => 'Quattrocento',
                    'font-weight'  => '400',
                    'text-transform' => 'uppercase',
                    'text-align' => 'center',
                ),
            ),
        )
    ) );

/*
 * <--- END SECTIONS
 */

// -> START Shop Settings Tab with no subsections

Redux::setSection( $opt_name, array(
    'title'  => esc_attr__( 'Shop', 'the-lawyer' ),
    'id'     => 'shop-setting',
    'icon'   => 'el el-shopping-cart',
    'fields' => array(
        array(
            'id'       => 'shop-sidebar-layout',
            'type'     => 'image_select',
            'title'    => esc_attr__( 'Choose sidebar option for shop', 'the-lawyer' ),

            //Must provide key => value(array:title|img) pairs for radio options
            'options'  => array(
                '1' => array(
                    'alt' => 'Without sidebar',
                    'img' => get_template_directory_uri() . '/images/framework/nosidebar.gif'
                ),
                '2' => array(
                    'alt' => '2 sidebars',
                    'img' => get_template_directory_uri() . '/images/framework/2sidebars.gif'
                ),
                '3' => array(
                    'alt' => 'Left sidebar',
                    'img' => get_template_directory_uri() . '/images/framework/leftsidebar.gif'
                ),
                '4' => array(
                    'alt' => 'Right sidebar',
                    'img' => get_template_directory_uri() . '/images/framework/rightsidebar.gif'
                )
            ),
            'default'  => '3'
        ),
        array(
            'id'       => 'shop_cart_menu',
            'type'     => 'switch',
            'title'    => esc_attr__( 'Show Cart in Header Menu?', 'the-lawyer' ),
            'default'  => true
        ),

        array(
            'id'       => 'shop-header14_slider',
            'type'     => 'select',
            'title'    => esc_attr__( 'Choose Slider for Shop', 'the-lawyer' ),
            'subtitle' => esc_attr__( 'Choose slider for header section', 'the-lawyer' ),
            'options'  => thelawyer_get_sliders_array(),
            'default'  => 'rev_header-team'
        ),			
    )
) );

// -> START BLOG SECTION

Redux::setSection( $opt_name, array(
    'title'  => esc_attr__( 'Blog', 'the-lawyer' ),
    'id'     => 'blog-setting',
    'icon'   => 'el el-blogger',
    'fields' => array(
        array(
            'id'       => 'blog-layout',
            'type'     => 'image_select',
            'title'    => esc_attr__( 'Choose page layout', 'the-lawyer' ),
            'subtitle'  => esc_attr__('The option work for slug /blog/ and subpages/subcategories', 'the-lawyer' ),
            //Must provide key => value(array:title|img) pairs for radio options
            'options'  => array(
                '1' => array(
                     'alt' => 'Full width layout',
                     'img' => get_template_directory_uri() . '/images/framework/full.gif'
                 ),
                '2' => array(
                    'alt' => 'Boxed layout, maximum resolution - 1170 px',
                    'img' => get_template_directory_uri() . '/images/framework/boxed.gif'
                )
            ),
            'default'  => '1'
        ),
        array(
            'id'        => 'blog-boxed-background-color',
            'type'      => 'color_rgba',
            'title'     => esc_attr__( 'Choose background for box', 'the-lawyer' ),
            'output'    => array('background-color' => '.mainbgr'),
            'default'   => array(
                'color'     => '#323232',
                'alpha'     => 1
            ),
            'required'  => array('blog-layout', '=', '2')
        ),
        array(
            'id'       => 'blog-boxed-background',
            'type'     => 'media',
            'title'    => esc_attr__( 'Box Background', 'the-lawyer' ),

            'subtitle' => esc_attr__( 'Upload your background for box', 'the-lawyer' ),
            'output'    => array('background-image' => '.mainbgr'),
            'default'  => array(
                'url'=> esc_url(get_template_directory_uri()).'/images/bgr.jpg'
            ),
            'required'  => array('blog-layout', '=', '2')
        ),
        array(
            'id'        => 'blog-content-background-color',
            'type'      => esc_attr__( 'color_rgba', 'the-lawyer' ),
            'title'     => esc_attr__( 'Choose background color for content section', 'the-lawyer' ),
            'subtitle'  => esc_attr__( 'Default - white', 'the-lawyer' ),
            'output'    => array('background-color' => '.lawyer_blog'),
            'default'   => array(
                'color'     => '#FFF',
                'alpha'     => 1
            ),
            'required'  => array('blog-layout', '=', '2')
        ),
        array(
            'id'       => 'blog-sidebar-layout',
            'type'     => 'image_select',
            'title'    => esc_attr__( 'Choose sidebar option', 'the-lawyer' ),
            'subtitle'  => esc_attr__('The option work for slug /blog/ and subpages/subcategories', 'the-lawyer' ),
            //Must provide key => value(array:title|img) pairs for radio options
            'options'  => array(
                '1' => array(
                    'alt' => 'Without sidebar',
                    'img' => get_template_directory_uri() . '/images/framework/nosidebar.gif'
                ),
                '2' => array(
                    'alt' => '2 sidebars',
                    'img' => get_template_directory_uri() . '/images/framework/2sidebars.gif'
                ),
                '3' => array(
                    'alt' => 'Left sidebar',
                    'img' => get_template_directory_uri() . '/images/framework/leftsidebar.gif'
                ),
                '4' => array(
                    'alt' => 'Right sidebar',
                    'img' => get_template_directory_uri() . '/images/framework/rightsidebar.gif'
                )
            ),
            'default'  => '1'
        ),

        array(
            'id'       => 'blog-columns',
            'type'     => 'button_set',
            'title'    => esc_attr__( 'Blog Columns Option', 'the-lawyer' ),
            'subtitle'  => esc_attr__('The option work for slug /blog/ and subpages/subcategories', 'the-lawyer' ),

            //Must provide key => value pairs for radio options
            'options'  => array(
                '1' => '1 Column',
                '2' => '2 Columns',
                '3' => '3 Columns',
            ),
            'default'  => '2',
            'required' => array(
                array('blog-sidebar-layout', '=', array(1)),
            )
        ),

        array(
            'id'       => 'blog-header14_slider',
            'type'     => 'select',
            'title'    => esc_attr__( 'Choose Slider for Blog', 'the-lawyer' ),
            'subtitle'  => esc_attr__('The option work for slug /blog/ and subpages/subcategories', 'the-lawyer' ),
            //Must provide key => value(array:title|img) pairs for radio options
            'options'  => thelawyer_get_sliders_array(),
            'default'  => 'rev_header-team',

        ),

        array(
            'id'   => 'blog-opt-divide1',
            'type' => 'divide'
        ),
        /*======== Slider OR Image END ==========*/

            array(
                'id'       => 'is_related_posts',
                'type'     => 'switch',
                'title'    => esc_attr__( 'Related Posts for Single Post View', 'the-lawyer' ),
                'subtitle' => esc_attr__( 'Press On to template choice appear' , 'the-lawyer' ),
                'default'  => true
            ),
                array(
                    'id'       => 'related_posts_title',
                    'type'     => 'text',
                    'title'    => esc_attr__( 'Related Posts Title', 'the-lawyer' ),
                    'subtitle' => esc_attr__( 'Set Title for Related Posts section', 'the-lawyer' ),
                    'required' => array( 'is_related_posts', '=', true ),
                    'default'  => 'Related Posts',
                ),
            array(
                'id'       => 'show_post_author',
                'type'     => 'switch',
                'title'    => esc_attr__( 'Show Post Author ', 'the-lawyer' ),
                'default'  => true,
            ),	
            array(
                'id'       => 'show_post_category',
                'type'     => 'switch',
                'title'    => esc_attr__( 'Show Post Category ', 'the-lawyer' ),
                'default'  => true,
            ),
            array(
                'id'       => 'show_post_tags',
                'type'     => 'switch',
                'title'    => esc_attr__( 'Show Post Tags ', 'the-lawyer' ),
                'default'  => true,
            ),
            array(
                'id'       => 'show_post_date',
                'type'     => 'switch',
                'title'    => esc_attr__( 'Show Post Date ', 'the-lawyer' ),
                'default'  => true,
            ),	
            array(
                'id'       => 'show_comments_count',
                'type'     => 'switch',
                'title'    => esc_attr__( 'Show Post Comments count ', 'the-lawyer' ),
                'default'  => true,
            ),			
		)
	)
);




Redux::setSection($opt_name, array(
    'title'     => esc_attr__('Color Scheme', 'the-lawyer'),
    'id'     => 'ocs',
    'desc'      => esc_attr__('Color scheme of the current design. You can create your own color scheme.', 'the-lawyer'),
    'icon'      => 'el el-cog',

    'fields'    => array(
        array(
            'id'        => 'colors_info_notice',
            'type'      => 'info',
            'notice'    => true,
            'style'     => 'info',
            'icon'      => 'el-icon-info-sign',
            'title'     => esc_attr__( 'Note', 'the-lawyer'),
            'desc'      => esc_attr__( 'We recommend to export theme options setting before change everything.', 'the-lawyer'),
        ),
        //Section START
        array(
            'id'       => 'general-colors-section-start',
            'type'     => 'section',
            'title'    => esc_attr__( 'General Colors', 'the-lawyer' ),
            'indent'   => true, // Indent all options below until the next 'section' option is set.
        ),

        array(
            'id'       => 'gc1',
            'type'     => 'color_rgba',
            'title'    => esc_attr__( 'Major Color', 'the-lawyer' ),
            'default'  => array(
                'color' => '#e5c07d',
                'alpha' => '1'
            ),
            'compiler'  => true,
            'output'    => false,
        ),
        array(
            'id'       => 'gc1l',
            'type'     => 'color_rgba',
            'title'    => esc_attr__( 'Light Major Color', 'the-lawyer' ),
            'default'  => array(
                'color' => '#f3cf8d',
                'alpha' => '1'
            ),
            'compiler'  => true,
            'output'    => false,
        ),
        array(
            'id'       => 'gc1d',
            'type'     => 'color_rgba',
            'title'    => esc_attr__( 'Dark Major Color', 'the-lawyer' ),
            'default'  => array(
                'color' => '#c79d52',
                'alpha' => '1'
            ),
            'compiler'  => true,
            'output'    => false,
        ),
        array(
            'id'       => 'gc1sd',
            'type'     => 'color_rgba',
            'title'    => esc_attr__( 'Semidark Major Color', 'the-lawyer' ),
            'default'  => array(
                'color' => '#d7aa59',
                'alpha' => '1'
            ),
            'compiler'  => true,
            'output'    => false,
        ),
        array(
            'id'       => 'gct8',
            'type'     => 'color_rgba',
            'title'    => esc_attr__( 'Semitransparent Major Color', 'the-lawyer' ),
            'default'  => array(
                'color' => '#e5c07d',
                'alpha' => '0.8'
            ),
            'compiler'  => true,
            'output'    => false,
        ),
        array(
            'id'       => 'gc2',
            'type'     => 'color_rgba',
            'title'    => esc_attr__( 'Second Color', 'the-lawyer' ),
            'default'  => array(
                'color' => '#434343',
                'alpha' => '1'
            ),
            'compiler'  => true,
            'output'    => false,
            
        ),
        array(
            'id'       => 'link',
            'type'     => 'link_color',
            'title'    => esc_attr__( 'Links Color Option', 'the-lawyer' ),
            //'regular'   => false, // Disable Regular Color
            //'hover'     => false, // Disable Hover Color
            //'active'    => false, // Disable Active Color
            'visited'   => false,  // Disable Visited Color
            'default'  => array(
                'regular' => '#d1a554',
                'hover'   => '#c79d52',
                'active'  => '#6b6d6f'
            ),
            'compiler'  => true,
            'output'    => 'a',
        ),
        array(
            'id'       => 'bgrc',
            'type'     => 'color_rgba',
            'title'    => esc_attr__( 'Background Color', 'the-lawyer' ),
            'default'  => array(
                'color' => '#ffffff',
                'alpha' => '1'
            ),
            'compiler'  => true,
            'output'    => false,
        ),
        array(
            'id'     => 'general-colors-section-end',
            'type'   => 'section',
            'indent' => false, // Indent all options below until the next 'section' option is set.
        ),
        // Section END

        //Section START
        array(
            'id'       => 'form-colors-section-start',
            'type'     => 'section',
            'title'    => esc_attr__( 'Form and Icon Colors', 'the-lawyer' ),
            'indent'   => true, // Indent all options below until the next 'section' option is set.
        ),
        array(
            'id'       => 'metabgr',
            'type'     => 'color_rgba',
            'title'    => esc_attr__( 'Address Block Background Color', 'the-lawyer' ),
            'subtitle' => esc_attr__( 'Background Color for address block on footer', 'the-lawyer' ),
            'default'  => array(
                'color' => '#fbf6ec',
                'alpha' => '1'
            ),
            'compiler'  => true,
            'output'    => false,
        ),
        array(
            'id'       => 'cbgr1',
            'type'     => 'color_rgba',
            'title'    => esc_attr__( 'Background Color for hover blocks', 'the-lawyer' ),
            'subtitle' => esc_attr__( 'Overflow background on blog categories, portfolio and services archive pages', 'the-lawyer' ),
            'default'  => array(
                'color' => '#2c3036',
                'alpha' => '0.75'
            ),
            'compiler'  => true,
            'output'    => false,
        ),
        array(
            'id'       => 'eyec',
            'type'     => 'color_rgba',
            'title'    => esc_attr__( 'Eye Icon Color', 'the-lawyer' ),
            'subtitle' => esc_attr__( 'On portfolio, blog categories and services archive pages', 'the-lawyer' ),
            'default'  => array(
                'color' => '#e5c07d',
                'alpha' => '0.45'
            ),
            'compiler'  => true,
            'output'    => false,
        ),
        array(
            'id'       => 'eyech',
            'type'     => 'color_rgba',
            'title'    => esc_attr__( 'Eye Icon Color (hover)', 'the-lawyer' ),
            'subtitle' => esc_attr__( 'On portfolio, blog categories and services archive pages', 'the-lawyer' ),
            'default'  => array(
                'color' => '#e5c07d',
                'alpha' => '1'
            ),
            'compiler'  => true,
            'output'    => false,
        ),
        array(
            'id'     => 'form-colors-section-end',
            'type'   => 'section',
            'indent' => false, // Indent all options below until the next 'section' option is set.
        ),
        // Section END



        //Section START
        array(
            'id'       => 'additional-colors-section-start',
            'type'     => 'section',
            'title'    => esc_attr__( 'Additional Colors', 'the-lawyer' ),
            'indent'   => true, // Indent all options below until the next 'section' option is set.
        ),
        array(
            'id'       => 'ac1',
            'type'     => 'color_rgba',
            'title'    => esc_attr__( 'Color for Dark Elements', 'the-lawyer' ),
            'subtitle' => esc_attr__( 'Or Light element for dark designs', 'the-lawyer' ),
            'default'  => array(
                'color' => '#171b21',
                'alpha' => '1'
            ),
            'compiler'  => true,
            'output'    => false,
        ),
        array(
            'id'       => 'ac2',
            'type'     => 'color_rgba',
            'title'    => esc_attr__( 'Additional color 2', 'the-lawyer' ),
            'subtitle' => esc_attr__( 'For dots in carousel, gray button, date in blog', 'the-lawyer' ),
            'default'  => array(
                'color' => '#c0c1c3',
                'alpha' => '1'
            ),
            'compiler'  => true,
            'output'    => false,
        ),
        array(
            'id'       => 'ac3',
            'type'     => 'color_rgba',
            'title'    => esc_attr__( 'Additional color 3', 'the-lawyer' ),
            'subtitle' => esc_attr__( 'For checkbox, radiobutton, icons in menu, pagination color, comment meta date, bottom address section', 'the-lawyer' ),
            'default'  => array(
                'color' => '#888888',
                'alpha' => '1'
            ),
            'compiler'  => true,
            'output'    => false,
        ),
        array(
            'id'       => 'ac4',
            'type'     => 'color_rgba',
            'title'    => esc_attr__( 'Additional color 4', 'the-lawyer' ),
            'subtitle' => esc_attr__( 'For name and text in testimonial carousel ', 'the-lawyer' ),
            'default'  => array(
                'color' => '#c0c1c3',
                'alpha' => '1'
            ),
            'compiler'  => true,
            'output'    => false,
        ),
        array(
            'id'       => 'ac5',
            'type'     => 'color_rgba',
            'title'    => esc_attr__( 'Additional color 5', 'the-lawyer' ),
            'subtitle' => esc_attr__( 'For subheadings, border for textfield, tag links, date in recent posts widget ', 'the-lawyer' ),
            'default'  => array(
                'color' => '#9c9fa2',
                'alpha' => '1'
            ),
            'compiler'  => true,
            'output'    => false,
        ),
        array(
            'id'       => 'ac6',
            'type'     => 'color_rgba',
            'title'    => esc_attr__( 'Additional color 6', 'the-lawyer' ),
            'subtitle' => esc_attr__( 'For some backgrounds and text on dark backgrounds', 'the-lawyer' ),
            'default'  => array(
                'color' => '#f3f3f3',
                'alpha' => '1'
            ),
            'compiler'  => true,
            'output'    => false,
        ),
        array(
            'id'       => 'ac7',
            'type'     => 'color_rgba',
            'title'    => esc_attr__( 'Additional color 7', 'the-lawyer' ),
            'subtitle' => esc_attr__( 'For some borders', 'the-lawyer' ),
            'default'  => array(
                'color' => '#ebebeb',
                'alpha' => '1'
            ),
            'compiler'  => true,
            'output'    => false,
        ),
        array(
            'id'       => 'ac8',
            'type'     => 'color_rgba',
            'title'    => esc_attr__( 'Additional color 8', 'the-lawyer' ),
            'subtitle' => esc_attr__( 'For woocommerce product description and text in accordion', 'the-lawyer' ),
            'default'  => array(
                'color' => '#6b6d6f',
                'alpha' => '1'
            ),
            'compiler'  => true,
            'output'    => false,
        ),
        array(
            'id'       => 'ac9',
            'type'     => 'color_rgba',
            'title'    => esc_attr__( 'Additional color 9', 'the-lawyer' ),
            'subtitle' => esc_attr__( 'For discount price in woocommerce', 'the-lawyer' ),
            'default'  => array(
                'color' => '#e97e76',
                'alpha' => '1'
            ),
            'compiler'  => true,
            'output'    => false,
        ),


        array(
            'id'     => 'additional-colors-section-end',
            'type'   => 'section',
            'indent' => false, // Indent all options below until the next 'section' option is set.
        ),
        // Section END

    ),

) );


/*
 * <--- END SECTIONS
 */
 
//add_filter('redux/options/secretlab/compiler', 'compiler_action', 10, 3); 
 
function compiler_action($options, $css, $changed_values) {
    global $wp_filesystem;

	$filename = get_stylesheet_uri() . '/style.css';
 
    if( empty( $wp_filesystem ) ) {
        require_once( ABSPATH .'/wp-admin/includes/file.php' );
        WP_Filesystem();
    }
 
    if( $wp_filesystem ) {
        $wp_filesystem->put_contents(
            $filename,
            $css,
            FS_CHMOD_FILE // predefined mode settings for WP files
        );
    }
}

add_filter('redux/options/secretlab/saved', 'set_index_page');

function set_index_page($var) {
    update_option( 'page_on_front', $var['index-page'] );
    update_option( 'show_on_front', 'page' );
}


