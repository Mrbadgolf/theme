<?php
// Allowed HTML tags for escaping of texts
$allowed_html = array(
	'a' => array(
		'href' => array(),
		'title' => array(),
		'target' => array(),
	),
	'div' => array(
		'class' => array(),
		'id' => array(),
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

	wp_register_script('thelawyer_import_attach_js', esc_url(get_template_directory_uri()) . '/js/import_attach.js', array('jquery', 'jquery-ui-tooltip', 'jquery-ui-progressbar'), 20140421, true );
	wp_enqueue_script( 'thelawyer_import_attach_js');

    wp_register_style( 'thelawyer_welcome', esc_url(get_template_directory_uri()) . '/inc/welcome.css', array(), '3.03' );
    wp_enqueue_style( 'thelawyer_welcome');
	
	wp_register_style( 'thelawyer_jquery_ui', esc_url(get_template_directory_uri()) . '/inc/jquery-ui.css', array(), '3.03' );
    wp_enqueue_style( 'thelawyer_jquery_ui');
	
	wp_register_script('thelawyer_welcome_js', esc_url(get_template_directory_uri()) . '/js/welcome.js', array('jquery'), '1.0', true );
	wp_enqueue_script( 'thelawyer_welcome_js');	
	
    wp_register_script('thelawyer_boot_js', esc_url(get_template_directory_uri()) . '/js/bootstrap.min.js', array('jquery'), '1.0', true );
    wp_enqueue_script( 'thelawyer_boot_js');		
	
	wp_localize_script( 'thelawyer_import_attach_js', 'aiL10n', array(
	    'import_start' => __( 'Start of attachments import - reading appropriate XML file', 'the-lawyer' ),
		'import_start_failed' => __( 'XML file reading error occured - check its existence', 'the-lawyer' ),
	    'emptyInput' => __( 'Please select a file.', 'the-lawyer' ),
	    'noAttachments' => __( 'There were no attachment files found in the import file.', 'the-lawyer' ),
		'parsing' => __( 'Parsing the file.', 'the-lawyer' ),
		'importing' => __( 'Importing file ', 'the-lawyer' ),
		'progress' => __( 'Overall progress: ', 'the-lawyer' ),
		'retrying' => __( 'An error occurred. In 5 seconds, retrying file ', 'the-lawyer' ),
		'done' => __( 'All done! Go to Theme Options and  click "Save Changes" button', 'the-lawyer' ),
		'ajaxFail' => __( 'There was an error connecting to the server.', 'the-lawyer' ),
		'pbAjaxFail' => __( 'The program could not run. Check the error log below or your JavaScript console for more information', 'the-lawyer' ),
		'fatalUpload' => __( 'There was a fatal error. Check the last entry in the error log below.', 'the-lawyer' )
	) );	
						   
$current = get_option( 'active_plugins' );
	
$opts = get_transient('lawyer_on_click_setup');
if (!is_array($opts)) $opts = array( 'theme_type' => 'light', 'install_plugins' => 1, 'activate_plugins' => 1, 'import_widgets' => 1, 
                                     'set_theme_options' => 1, 'set_suppamenu_skins' => 1, 'import_color_shemes' => 1, 
									 'set_sliders' => 1, 'technical_refresh' => 1,
									 'set_types' => 1, 'set_icons' => 1, 'set_post_and_menu_screens' => 1, 'import_sample_data' => 1, 'i_id' => 1,
                                     'install_theme' => 1, 'import_data' => 1, 'import_attachments' => 1);
if (isset($_COOKIE['lawyer_theme_type'])) $opts['theme_type'] = $_COOKIE['lawyer_theme_type'];
$theme_type = $opts['theme_type'];
$theme_names = array('modernb' => '#2 Modern Design Brown-Blue', 'modernbb' => '#2 Modern Design Brown-Brown', 'modern' => '#2 Modern Design Pink-Blue', 'white' => '#1 Conservative White', 'blue' => '#1 Conservative Blue', 'dark' => '#1 Conservative Dark');

$checked = array();

foreach ($opts as $name => $val) {
    if ($val == 1) $checked[$name] = ' checked="checked"'; else $checked[$name] = '';
}

echo '<div class="increase">';

echo '<div class="container">';

if (function_exists('welcome_notice')) {
    welcome_notice();
	global $wn;
	echo wp_kses($wn['real_capabilities'], $allowed_html );
	$install_log_class = "install_log_active";
}
else {
    $install_log_class = "install_log_passive";
}

function sell_inst_error_mess() {
	if (!function_exists('welcome_notice')) {
		echo '<div class="noinstaller">'.esc_html__('Install SecretLab Installer plugin to install the theme', 'the-lawyer').'</div>';
	}
}
function sell_hide() {
	if (!function_exists('welcome_notice')) {
		$add_class = ' style="display:none !important"';
	}
	else $add_class = '';
    return $add_class;
}



 echo ' <ul class="nav-tabs" role="tablist">
                        <li role="presentation" class="active"><a href="#firsttab" aria-controls="home" role="tab" data-toggle="tab">'.esc_html__('Auto Install', 'the-lawyer').'</a></li>
                        <li role="presentation"><a href="#secondtab" aria-controls="profile" role="tab" data-toggle="tab">'.esc_html__('Manual Install', 'the-lawyer').'</a></li>
                    </ul>

<div class="tab-content" >';
sell_inst_error_mess();
      echo '<div role="tabpanel" class="tab-pane fade in active" id="firsttab"'.sell_hide().'>

            <h1>'.esc_html__('Welcome to The Lawyer Theme', 'the-lawyer').'</h1>
            <div class="row">
                <div class="col-md-6 col-sm-12" id="theme_setup_box">
                    <h3>'.esc_html__('Automatic installation can take 2-8 min', 'the-lawyer').'</h3>
                    <div id="progressBar1" class="progressBar"><div class="progress_bar"></div><div class="progress_count"></div></div>
					
					<div id="theme_setup_summary" style="position:relative">
					
						<div class="welcome_install">
						    <p><input id="install_theme_info" class="bulk_install_item" type="checkbox" name="install_theme"' . $checked['install_theme'] . ' /> <b>'.esc_html__('Install Theme', 'the-lawyer').'</b></p>
						</div>					
					
		                <div id="theme_setup_control" style="position:relative">
						 <div id="theme_type">
							 <span>'.esc_html__('Select Theme version', 'the-lawyer').'</span>
							 <select id="theme_type_select" name="theme_type">';
									foreach ($theme_names as $tn=>$title) {
										if ($tn == $opts['theme_type'])
											echo '<option selected="selected" value="' . $tn . '">' . $title . '</option>';
										else
											echo '<option value="' . $tn . '">' . $title . '</option>';
									}
									echo '
							 </select>
						 </div>						
						
							<div id="theme_setup_control" class="install_steps" style="position:relative">
								<div class="welcome_install">
									<p><input id="install_plugins_checkbox" type="checkbox" name="install_plugins"' . $checked['install_plugins'] . ' /> <b>'.esc_html__('Install plugins', 'the-lawyer').'</b></p>
								</div>
								<div class="welcome_install">
									<p><input id="activate_plugins_checkbox" type="checkbox" name="activate_plugins"' . $checked['activate_plugins'] . ' /> <b>'.esc_html__('Activate plugins', 'the-lawyer').'</b></p>
								</div>								
								<div class="welcome_install">
									<input id="import_widgets_checkbox" name="import_widgets" type=checkbox ' . $checked['import_widgets'] . ' /> <b>'.esc_html__('Import Widgets', 'the-lawyer').'</b></p>
								</div>							
								<div class="welcome_install">
									<input id="set_theme_options_checkbox" name="set_theme_options" type=checkbox ' . $checked['set_theme_options'] . ' /> <b>'.esc_html__('Import Theme Options', 'the-lawyer').'</b></p>
								</div>														
								<div class="welcome_install">
									<input id="set_sliders_checkbox" name="set_sliders" type=checkbox ' . $checked['set_sliders'] . ' /> <b>'.esc_html__('Import Demo Revolution Sliders', 'the-lawyer').'</b></p>
								</div>
								<div class="welcome_install">
									<input id="technical_refresh_checkbox" name="technical_refresh" type=checkbox ' . $checked['technical_refresh'] . ' /> <b>'.esc_html__('Do Page Technical Refresh', 'the-lawyer').'</b></p>
								</div>	
								<div class="welcome_install">
									<input id="set_types_checkbox" name="set_types" type=checkbox ' . $checked['set_types'] . ' /> <b>'.esc_html__('Import Types Plugin Settings', 'the-lawyer').'</b></p>
								</div>
								<div class="welcome_install">
									<input id="set_icons_checkbox" name="set_icons" type=checkbox ' . $checked['set_icons'] . ' /> <b>'.esc_html__('Import Icon Fonts', 'the-lawyer').'</b></p>
								</div>								
								<div class="welcome_install">
									<input id="set_post_and_menu_screens_checkbox" name="set_post_and_menu_screens" type=checkbox ' . $checked['set_post_and_menu_screens'] . ' /> <b>'.esc_html__('Set Admin Pages Settings', 'the-lawyer').'</b></p>
								</div>
								
							</div>						 
								
							</div>
							
						</div>	
							
						<div id="theme_import_summary" style="position:relative">
						
						    <div class="welcome_install">
								<p><input id="import_data_info" class="bulk_install_item" type="checkbox" name="import_data"' . $checked['import_data'] . ' /> <b>'.esc_html__('Import Data', 'the-lawyer').'</b></p>
							</div>							
						
						    <div id="theme_import_control" class="install_steps">
                                <div class="welcome_install">
							        <input id="import_sample_data_checkbox" name="import_sample_data" type=checkbox ' . $checked['import_sample_data'] . ' /> <b>'.esc_html__('Import Demo Data', 'the-lawyer').'</b></p>
							    </div>
                                <div class="welcome_install">
							        <input id="import_attachments_checkbox" name="import_attachments" type=checkbox ' . $checked['import_attachments'] . ' /> <b>'.esc_html__('Import attachments', 'the-lawyer').'</b></p>
							    </div>
                                <div id="import_attachment_data">
								    <!--<p><input type="file" name="file" id="attachments_file"/></p>-->
	                                <p>' . __( 'Attribute uploaded images to:', 'the-lawyer' ) . '<br/>
		                            <input type="radio" name="author" value=1 checked />&nbsp;' . __( 'Current User', 'the-lawyer' ) . '<br/>
		                            <input type="radio" name="author" value=2 />&nbsp;' . __( 'User in the import file', 'the-lawyer') . '<br/>
		                            <input type="radio" name="author" value=3 />&nbsp;' . __( 'Select User:', 'the-lawyer' ) . wp_dropdown_users(array('echo' => false)) .

	                                '<p><input type="checkbox" checked="checked" name="delay" />&nbsp;' . __( 'Delay file requests by at least five seconds.', 'the-lawyer' ) . '&nbsp;<a href="#" title="' . __( 'This delay can be useful to mitigate hosts that throttle traffic when too many requests are detected from an IP address and mistaken for a DDOS attack.', 'the-lawyer' ) . '" style="text-decoration:none;"><span class="dashicons dashicons-editor-help"></span></a></p> 									
                                </div>								
							</div>

                        </div>							

						<div><a id="theme_setup_submit" class="meta_btn" href="#">'.esc_html__('Start installation', 'the-lawyer').'</a></div>
						 
                </div>
                <div class="col-md-6 col-sm-12 ' . esc_attr($install_log_class, 'the-lawyer') . '">
                       <h3>'.esc_html__('Log of installation', 'the-lawyer').'</h3>
                       <div id="theme_setup_result"></div>
                </div>
            </div>

            <div class="row pt60">';

				if (function_exists('welcome_notice')) {
				    global $wn;

					echo wp_kses($wn['recommended_capabilities'], $allowed_html );
					echo wp_kses($wn['fail_install'], $allowed_html );
				}
				
				echo '
                <div class="col-md-4 col-sm-12">
                    <div class="inform">
                    <h3>'.esc_html__('Support', 'the-lawyer').'</h3>
                    <a href="http://secretlab.pw/doc/lawyerwp/" target="_blank">'.esc_html__('Online documentation', 'the-lawyer').'</a><br>
                    <a href="http://secretlab.pw/helpdesk/ticketsnewguest.php" target="_blank">'.esc_html__('Send a Ticket', 'the-lawyer').'</a>
                    </div>
                </div>
            </div>
</div>

<div role="tabpanel" class="tab-pane fade" id="secondtab"'.sell_hide().'>
                            <div class="col-md-6 col-sm-12">
                                <h2>'.esc_html__('Manual Install', 'the-lawyer').'</h2>
                                <p>'.esc_html__('You can use it if you got any error and dont want to wait a solution from server administrator or hosting company.', 'the-lawyer').'</p>
                                <p>'.esc_html__('Details about manual installations process: ', 'the-lawyer').'<a href="http://secretlab.pw/doc/lawyerwp/#line15" target="_blank">www.secretlab.pw/doc/lawyerwp/#line15</a></p>
								<div id="progressBar2" class="progressBar"><div  class="progress_bar"></div><div class="progress_count"></div></div>';
								echo '
								 <div id="theme_type">
									 <span>'.esc_html__('Select Theme version', 'the-lawyer').'</span>
									 <select id="manual_theme_type_select" name="theme_type">';
											foreach ($theme_names as $tn=>$title) {
												if ($tn == $opts['theme_type'])
													echo '<option selected="selected" value="' . $tn . '">' . $title . '</option>';
												else
													echo '<option value="' . $tn . '">' . $title . '</option>';
											}
											echo '
									 </select>
								 </div>';
echo '<ol class="step">';
echo '<li><span>1</span> <a target="_blank" href="themes.php?page=install-required-plugins&plugin_status=install">'.esc_html__('Begin installing plugins', 'the-lawyer').'</a> <a id="manual_install_plugins" class="manual_install manual_btn" href="#">'.esc_html__('Do It', 'the-lawyer').'</a></li>';

echo '<li><span>2</span> <a target="_blank" href="themes.php?page=install-required-plugins&plugin_status=activate">'.esc_html__('Begin activating plugins', 'the-lawyer').'</a> <a id="manual_activate_plugins" class="manual_install manual_btn" href="#">'.esc_html__('Do It', 'the-lawyer').'</a></li>';

echo '<li><span>3</span> <a href="themes.php?page=secretlab-welcome">'.esc_html__('Refresh the page', 'the-lawyer').'</a></li>';

echo '<li><span>4</span> <a target="_blank" href="admin.php?page=toolset-export-import">'.esc_html__('Import Custom Post Types', 'the-lawyer').'</a> <a id="manual_set_types" class="manual_install manual_btn" href="#">'.esc_html__('Do It', 'the-lawyer').'</a></li>';

echo '<li><span>5</span> <a target="_blank" href="admin.php?page=revslider">'.esc_html__('Import Sliders', 'the-lawyer').'</a> <a id="manual_set_sliders" class="manual_install manual_btn" href="#">'.esc_html__('Do It', 'the-lawyer').'</a></li>';

echo '<li><span>6</span> <a target="_blank" href="admin.php?page=_options&tab=16">'.esc_html__('Import Theme Option Set', 'the-lawyer').'</a> <a id="manual_set_theme_options" class="manual_install manual_btn" href="#">'.esc_html__('Do It', 'the-lawyer').'</a></li>';

echo '<li><span>7</span> <a target="_blank" href="admin.php?page=bsf-font-icon-manager">'.esc_html__('Import Icon Fonts', 'the-lawyer').'</a> <a id="manual_set_icons" class="manual_install manual_btn" href="#">'.esc_html__('Do It', 'the-lawyer').'</a></li>';

echo '<li><span>8</span> <a target="_blank" href="nav-menus.php">'.esc_html__('Set Menu and Discussions Checkboxes', 'the-lawyer').'</a> <a id="manual_set_post_and_menu_screens" class="manual_install manual_btn" href="#">'.esc_html__('Do It', 'the-lawyer').'</a></li>';

echo '<hr>'.esc_html__('Theme Setup completed. You can import demo-data, if it necessary', 'the-lawyer').'<hr>';

echo '<li><span>9</span> <a target="_blank" href="admin.php?import=wordpress">'.esc_html__('Import Dummy Data (Skip it, if you dont need demo-data)', 'the-lawyer').'</a> <a id="manual_import_sample_data" class="manual_install manual_btn" href="#">'.esc_html__('Do It', 'the-lawyer').'</a>'.esc_html__(' If it got error, you can run it again 2-6 times (at slow webhosting) until you get a success message', 'the-lawyer').'</li>';

echo '<li><span>10</span> <a target="_blank" href="admin.php?import=attachment-importer">'.esc_html__('Import Dummy Data Attachments, It can take 5-15 min (Skip it, if you dont need demo-data)', 'the-lawyer').'</a> <a id="manual_import_attachments" class="manual_install manual_btn" href="#">'.esc_html__('Do It', 'the-lawyer').'</a></li>';

echo '<li><span>11</span> <a target="_blank" href="tools.php?page=widget-importer-exporter">'.esc_html__('Import Widgets', 'the-lawyer').'</a> <a id="manual_import_widgets" class="manual_install manual_btn" href="#">'.esc_html__('Do It', 'the-lawyer').'</a></li>';

echo '</ol>';
echo '</div>';

echo '<div class="col-md-6 col-sm-12 ' . esc_attr($install_log_class, 'the-lawyer') . '">
                       <h3>'.esc_html__('Log of installation', 'the-lawyer').'</h3>
                       <div id="manual_theme_install_result"></div>
                </div>';

echo '</div></div></div></div>';

echo '<div id="theme_type_dialog">
          <div id="theme_type_dialog_content">'.esc_html__('It seems you have started Lawyer Theme Install already, now you are trying to change Theme Type to another one. Are you sure?', 'the-lawyer').'</div>
		  <a id="theme_type_dialog_continue" class="theme_type_dialog_button manual_btn" href="#">'.esc_html__('Continue', 'the-lawyer').'</a>
		  <a id="theme_type_dialog_stop" class="theme_type_dialog_button manual_btn" href="#">'.esc_html__('Stop', 'the-lawyer').'</a>
	  </div>';

?>
