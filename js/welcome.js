jQuery(document).on('ready', function() {
    var busy = false, lawyer_install_by_hand, lawyer_settings = { 'emitter' : null, 'receiver' : null, 'start_theme_type' : null };
	
	jQuery( document ).tooltip();
	if (jQuery('#import_attachments_checkbox').is(":checked")) jQuery('#import_attachment_data').css({'display' : 'block' });
	else jQuery('#import_attachment_data').css({'display' : 'none' });
	
    jQuery('#activate_alico_icons').on('click', function(e) {
	    e.preventDefault();
        jQuery.ajax({
		    url : localajax['url'], 
			method : 'POST',
			data : 'action=activate_icons',
            success : function(result) {
                var str = result.substr(0, result.length - 1);
				if (str.match(/smile_font_added/)) alert("ALICO font installed successfully");
				else alert(str);
            }			
		});	
        return false;		
	});
	
	function lawyer_preg_match(str) {
	    var out = '', result, regexp = /___([^_]+)___/gm;
		while (result = regexp.exec(str)) {
		    out += result[1];
		}
		return out;
	}
	
	function setCookie(name, value, options) {
	  options = options || {};

	  var expires = options.expires;

	  if (typeof expires == "number" && expires) {
		var d = new Date();
		d.setTime(d.getTime() + expires * 1000);
		expires = options.expires = d;
	  }
	  if (expires && expires.toUTCString) {
		options.expires = expires.toUTCString();
	  }

	  value = encodeURIComponent(value);

	  var updatedCookie = name + "=" + value;

	  for (var propName in options) {
		updatedCookie += "; " + propName;
		var propValue = options[propName];
		if (propValue !== true) {
		  updatedCookie += "=" + propValue;
		}
	  }

	  document.cookie = updatedCookie;
	}	

	function getCookie(name) {
	  var matches = document.cookie.match(new RegExp(
		"(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
	  ));
	  return matches ? decodeURIComponent(matches[1]) : undefined;
	}

	function deleteCookie(name) {
	  setCookie(name, "", {
		expires: -1
	  })
	}

	function implode( glue, pieces ) {	// Join array elements with a string
		return ( ( pieces instanceof Array ) ? pieces.join ( glue ) : pieces );
	}

	function explode( delimiter, string ) {	// Split a string by string

		var emptyArray = { 0: '' };

		if ( arguments.length != 2
			|| typeof arguments[0] == 'undefined'
			|| typeof arguments[1] == 'undefined' )
		{
			return null;
		}

		if ( delimiter === ''
			|| delimiter === false
			|| delimiter === null )
		{
			return false;
		}

		if ( typeof delimiter == 'function'
			|| typeof delimiter == 'object'
			|| typeof string == 'function'
			|| typeof string == 'object' )
		{
			return emptyArray;
		}

		if ( delimiter === true ) {
			delimiter = '1';
		}

		return string.toString().split ( delimiter.toString() );
	}

    function lawyer_kill_cookies() {
		deleteCookie('lawyer_install_tasks');
		deleteCookie('lawyer_install_by_hand');
		deleteCookie('lawyer_theme_type');
	}
	
	jQuery('#theme_setup_submit').on('click', function(e) {
	    var theme_type,
			sets = { 
			        'install_plugins' : { 'start' : 'Install necessary plugins processing, it can take several minutes', 'progress' : { 'start' : 0, 'end' : 20, 'duration' : 360 } },
					'activate_plugins' : { 'start' : 'Activating necessary plugins processing', 'progress' : { 'start' : 20, 'end' : 25, 'duration' : 360 } },
                    'import_widgets' : { 'start' : 'Widgets importing', 'progress' : { 'start' : 26, 'end' : 40, 'duration' : 40 } },
					'set_theme_options' : { 'start' : 'Importing Lawyer Theme Options' , 'progress' : { 'start' : 42, 'end' : 45, 'duration' : 10 } },
				    'set_sliders' : { 'start' : 'Started Revolution Sliders Import, it can take several minutes', 'progress' : { 'start' : 56, 'end' : 65, 'duration' : 100 } },
					'technical_refresh' : { 'start' : 'Necessary page refresh ... ', 'progress' : { 'start' : 66, 'end' : 70, 'duration' : 1 } },
					'set_types' : { 'start' : 'Started Types Plugin Data Import', 'progress' : { 'start' : 71, 'end' : 75, 'duration' : 20 } },
					'set_icons' : { 'start' : 'Importing Icon Fonts', 'progress' : { 'start' : 76, 'end' : 80, 'duration' : 20 } },
					'set_post_and_menu_screens' : { 'start' : 'Importing Page, Post and Post Types screen settings', 'progress' : { 'start' : 81, 'end' : 100, 'duration' : 20 } },
					'import_sample_data' : { 'start' : 'Importing sample data', 'progress' : { 'start' : 0, 'end' : 100, 'duration' : 470 } },
					'import_attachments' : { 'start' : 'Importing attachments', 'progress' : { 'start' : 0, 'end' : 100, 'duration' : 470 } }
					},
			i = 0, tm, j = 0, op, done = false,
			box = jQuery('#theme_setup_result'),
			el, k, tasks = [], task, current_install_by_hand, attacment_import = '', settings = '', current_progress;
			
		e.preventDefault();
		
		if (busy) return;

		current_install_by_hand = getCookie('lawyer_install_by_hand');
		
		if (current_install_by_hand != 0) {
			jQuery("input[id*='_checkbox']").each(function(i, el) {
				if (jQuery(el).is(":checked")) { 
					tasks.push(el.name);				
				}
			}); 
        }
		else {
		    tasks = explode(',', getCookie('lawyer_install_tasks'));
		}
        setCookie('lawyer_install_tasks', implode(',', tasks), { 'expires' : 60*15 });

        theme_type = getCookie('lawyer_theme_type');
        if (!theme_type || theme_type == 'undefined') theme_type = jQuery('#theme_type_select').val();
        setCookie('lawyer_theme_type', theme_type, { 'expires' : 60*15 });			
		
        jQuery('.welcome_install input').each(function(i, el) {
		    if (jQuery(el).attr('checked') == 'checked') {
			    settings += '&' + jQuery(el).attr('name') + '=1';
			}
			else 
			    settings += '&' + jQuery(el).attr('name') + '=0';
			//console.log(settings);
        });			
		
		if ( tasks.length == 0 ) return;
		
		jQuery('#progressBar1').css({ 'display' : 'block' });
		
		tm = setInterval( function() {
		    if (!busy) {
		        busy = true;
				if ( current_install_by_hand == 0 ) {
				    if (tasks[0] && tasks[0] == 'technical_refresh') tasks.shift();
					setCookie('lawyer_install_by_hand', 1);
				}				
                if (!done && tasks[0] && tasks[0] != 'technical_refresh' && tasks[0] != 'import_attachments') {
				    k = 0; progress(sets[tasks[0]].progress.start, jQuery('#progressBar1'));
                    jQuery(box).html( jQuery(box).html() + '<div class="setup_item_start">' + sets[tasks[0]].start + '</div>' );					
                    jQuery.ajax({
		                url : localajax['url'], 
			            method : 'POST',
			            data : 'action=setup_theme&theme_type=' + theme_type + '&op=' + tasks[0] + settings,
						timeout : 1000*60*60*2,
                        success : function(result) {
						    var n, text, messages, msg = '';
							messages = result.substr(0, result.length - 1);
							text = lawyer_preg_match(messages);
							if (text) {							    
							    jQuery(box).html( jQuery(box).html() + '<br>' + text );
							}
						    busy = false;
							if (tasks[0]) { progress(sets[tasks[0]].progress.end, jQuery('#progressBar1')); }
							if ( result.match(/There are problems with WP_Import classes/) || result.match(/Fatal\serror/) ||
                                 tasks.length == 0 )							
							{
								busy = true; done = true;
								jQuery.ajax({
							        url : localajax['url'],
								    method : 'POST',
								    data : 'action=setup_theme&op=abort'
							    });
								lawyer_kill_cookies();
								clearInterval(tm);
							}
                            tasks.shift();
                            setCookie('lawyer_install_tasks', implode(',', tasks, { 'expires' : 60*15 } ) );							
                        },
                        error: function(jqXHR, textStatus, errorThrown){
						    jQuery.ajax({
							    url : localajax['url'],
								method : 'POST',
								data : 'action=setup_theme&op=abort'
							});
							busy = done = true;
							lawyer_kill_cookies();
							clearInterval(tm);
						    alert("Something went wrong: your hosting to check server logs and fix a reson of the error.");
                        }						
		            });
                    settings = '';					
				}
				else if (tasks[0] && tasks[0] == 'import_attachments') {
				    attachments_import(theme_type, 'auto_install');
				}
				else if (tasks[0] && tasks[0] == 'technical_refresh') {
                    tasks.shift();
                    setCookie('lawyer_install_tasks', implode(',', tasks, { 'expires' : 60*15 } ) );
                    setCookie('lawyer_install_by_hand', 0);					
				    location.reload();
				}
		    }
			if (tasks.length == 0) done = true;
			if (!done) current_progress = parseInt((sets[tasks[0]].progress.end - sets[tasks[0]].progress.start)*k/sets[tasks[0]].progress.duration + sets[tasks[0]].progress.start); else current_progress = 100;
			if (tasks[0] == 'import_sample_data' && current_progress > 101) { done = true; lawyer_kill_cookies(); busy = false; clearInterval(tm); alert("Import Sample Data has not finished, please try again"); location.reload(); }
			if (!done && sets[tasks[0]]) progress(current_progress, jQuery('#progressBar1'));
            j++; k++;
		    if (j > 1800 || done) { progress(100, jQuery('#progressBar1')); lawyer_kill_cookies(); busy = false; clearInterval(tm); }			
		}, 1000);

        return false;		
		
	});

    function progress(percent, $element) {
        var progressBarWidth = percent * $element.width() / 100;
        $element.find('div.progress_bar').animate({ width: progressBarWidth }, 100);
		$element.find('div.progress_count').html(percent + "% ");
    }
	
	jQuery('.bulk_install_item').on('change', function(e) {
	    var option = true;
	    if (jQuery(e.target).is(":checked")) option = true;
		else option = false;  
		jQuery(e.target).parents("div[id$='_summary']").find('.install_steps input').attr("checked", option);
	});
	
	jQuery('.welcome_install input').on('change', function(e) {
	    var parent = jQuery(e.target).parents("div[id$='_control']");
		if (parent && parent.length == 0) return;
	    if (!jQuery(e.target).is(":checked")) {
		    jQuery(e.target).parents("div[id$='_summary']").find('.bulk_install_item').attr("checked", false);
			jQuery(e.target).parents("div[id$='_summary']").find('.welcome_install input').each(
			    function(i, el) {
				    if (el === e.target) jQuery(el).attr("checked", true);
					else jQuery(el).attr("checked", false);
				});
			if (e.target.id == 'import_attachments_checkbox') {
			    jQuery('#import_attachment_data').css({ 'display' : 'none' });
			}
		}
		else {
			if (e.target.id == 'import_attachments_checkbox') {
			    jQuery('#import_attachment_data').css({ 'display' : 'block' });
			}		    
		}
	});
	
	jQuery('.manual_install').on('click', function(e) {
	    var theme_type,
		    op = e.target.id.match(/manual_(.+)/),
		    tm, done = false, current_progress,
            sets = { 
			        'install_plugins' : { 'start' : 'Install necessary plugins processing, it can take several minutes', 'progress' : { 'start' : 0, 'end' : 45, 'duration' : 360 } },
					'activate_plugins' : { 'start' : 'Activating necessary plugins processing', 'progress' : { 'start' : 20, 'end' : 25, 'duration' : 360 } },
                    'import_widgets' : { 'start' : 'Widgets importing', 'progress' : { 'start' : 45, 'end' : 60, 'duration' : 40 } },
					'set_theme_options' : { 'start' : 'Importing Lawyer Theme Options' , 'progress' : { 'start' : 60, 'end' : 65, 'duration' : 10 } },
				    'set_sliders' : { 'start' : 'Started Revolution Sliders Import, it can take several minutes', 'progress' : { 'start' : 65, 'end' : 85, 'duration' : 100 } },
					'technical_refresh' : { 'start' : 'Necessary page refresh ... ', 'progress' : { 'start' : 85, 'end' : 85, 'duration' : 1 } },
					'set_types' : { 'start' : 'Started Types Plugin Data Import', 'progress' : { 'start' : 85, 'end' : 95, 'duration' : 20 } },
					'set_icons' : { 'start' : 'Importing Icon Fonts', 'progress' : { 'start' : 85, 'end' : 95, 'duration' : 20 } },
					'set_post_and_menu_screens' : { 'start' : 'Importing Page, Post and Post Types screen settings', 'progress' : { 'start' : 95, 'end' : 100, 'duration' : 20 } },
					'import_sample_data' : { 'start' : 'Importing sample data', 'progress' : { 'start' : 0, 'end' : 100, 'duration' : 470 } },
					'import_attachments' : { 'start' : 'Importing attachments', 'progress' : { 'start' : 0, 'end' : 100, 'duration' : 470 } }
					}, k = 1, box = jQuery('#manual_theme_install_result');
		
		e.preventDefault();
		op = op[1];
		
		theme_type = getCookie('lawyer_theme_type');
        if (!theme_type || theme_type == 'undefined') theme_type = jQuery('#manual_theme_type_select').val();
        setCookie('lawyer_theme_type', theme_type, { 'expires' : 60*15 });	
		
		jQuery(box).html( jQuery(box).html() + '<div class="setup_item_start">' + sets[op].start + '</div>' );
		
		tm = setInterval(function() {
		    current_progress = parseInt((sets[op].progress.end - sets[op].progress.start)*k/sets[op].progress.duration + sets[op].progress.start);
			if (op && op == 'import_sample_data' && current_progress > 101) { done = true; clearInterval(tm); lawyer_kill_cookies(); alert("Import Sample Data has not finished, please try again"); location.reload(); }
		    if (done) { clearInterval(tm); progress(100, jQuery('#progressBar2')); }
			else {
			    progress(current_progress, jQuery('#progressBar2'));
				k++;
			}
		}, 1000);
		
		jQuery('#progressBar2').css({ 'display' : 'block' });
		
		if (op && op != 'import_attachments') {
			jQuery.ajax({
				url : localajax['url'], 
				method : 'POST',
				data : 'action=setup_theme&theme_type=' + theme_type + '&op=' + op,
				timeout : 1000*60*60*2,
				success : function(result) {
					var text, messages;
					messages = result.substr(0, result.length - 1);
					jQuery.ajax({
						url : localajax['url'],
						method : 'POST',
						data : 'action=setup_theme&op=abort'
					});						
					text = lawyer_preg_match(messages);
					if (text.length > 0) {
						jQuery(box).html( jQuery(box).html() + '<br>' + text );
					}
					deleteCookie('lawyer_theme_type');				
					done = true;				
					},
				error: function(jqXHR, textStatus, errorThrown){
					jQuery.ajax({
						url : localajax['url'],
						method : 'POST',
						data : 'action=setup_theme&op=abort'
						});
					deleteCookie('lawyer_theme_type');	
					alert("Something went wrong: ask you server administrator to check server logs to get a reason.");
					}				
				});
		}
		else if (op && op == 'import_attachments') {
		    attachments_import(theme_type, 'manual_install');
		}
	});
	
	jQuery('#theme_type_dialog').on('click', function(e) {
	    e.preventDefault();
	    if (e.target.id == 'theme_type_dialog_continue') { jQuery(lawyer_settings.receiver).attr('value', jQuery(lawyer_settings.emitter).val()); setCookie('lawyer_theme_type', jQuery(lawyer_settings.emitter).val(), { 'expires' : 60*15 });}
		else if (e.target.id == 'theme_type_dialog_stop') { jQuery(lawyer_settings.emitter).attr('value', lawyer_settings.start_theme_type); }
		jQuery('#theme_type_dialog').css({ 'display' : 'none' });
	});
	
	jQuery("select[id*='theme_type_select']").on('focus', function(e) {
	    lawyer_settings.start_theme_type = jQuery(e.target).val();
	});
	
    jQuery("select[id*='theme_type_select']").on('change', function(e) {
	    var theme_type, target_theme_type, parent;
		
		lawyer_settings.emitter = jQuery(e.target);
		
		if (e.target.id == 'theme_type_select') lawyer_settings.receiver = jQuery('#manual_theme_type_select');
		else lawyer_settings.receiver = jQuery('#theme_type_select');		
		
		theme_type = getCookie('lawyer_theme_type');
		if (!theme_type || theme_type == 'undefined')  { theme_type = jQuery(e.target).val(); setCookie('lawyer_theme_type', jQuery(e.target).val(), { 'expires' : 60*15 }); }
		else {
		    target_theme_type = jQuery(e.target).val();
			if (target_theme_type != theme_type) {
			    parent = jQuery(e.target).parents('.tab-pane');
			    jQuery('#theme_type_dialog').css({ 'display' : 'block',
  				                                                    'left' : (jQuery(document).width() - jQuery('#theme_type_dialog').width())/2 + 'px',
																	'top' : (jQuery(window).height() - jQuery('#theme_type_dialog').outerHeight())/2 + jQuery(document).scrollTop() + 'px' });
				return;
			}
		}
		
		jQuery(lawyer_settings.receiver).attr('value', jQuery(lawyer_settings.emitter).val());
		
	});

	lawyer_install_by_hand = getCookie('lawyer_install_by_hand');
	if ( lawyer_install_by_hand && lawyer_install_by_hand == 0) {
        jQuery('#theme_setup_submit').trigger('click'); 
	}
	
	if (window.location.href.match(/superadmin=1/)) jQuery('.install_steps').css({'display' : 'block'});
	
});
