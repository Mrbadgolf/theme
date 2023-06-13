jQuery(document).ready(function() {

    function category_query_click_handler(e) {
	    var href, str, args = '', page, parent,
		    waiter = jQuery('#seo_ajax_waiter'),
			cls,
			prefix;
			
		parent = jQuery(e.target).parents("[class*='category_query_block']"); 
		prefix = 'action=handle_category_query';
		cls = 'category_query';
		if (parent.length == 0) {
		    parent = jQuery(e.target).parents("[class*='post_format_query_block']"); 
			prefix = 'action=handle_post_format_query';
			cls = 'post_format_query';
		}
		
		function innerHandler(result, args) {
		    var parent;
				parent = jQuery(e.target).parents("[class*='" + cls + "_block']");
				result = result.substring(0, result.length - 1);
			    jQuery(parent).html(result);
			    jQuery("[class*='" + cls + "_pagination']").on('click', args.f);
                jQuery('#seo_ajax_waiter').css({ 'display' : 'none' });		
                jQuery('html, body').animate({scrollTop: jQuery(parent).offset().top}, 500);			
		}
		
	    if (e.target.nodeName == 'A') {
		    e.preventDefault();
			href = e.target.href;
			str = href.match(/\/_id.+$/)[0];
			str = str.match(/_[^\/]+/);
			str = str[0].replace(/_/g, '&');
			page = href.match(/\/page\/([0-9]+)/); page = page[1];
			jQuery(waiter).css({ 'top' : (jQuery(parent).height() - jQuery(waiter).height())/2 + 'px', 
			                     'left' : (jQuery(parent).width() - jQuery(waiter).width())/2 + 'px',
								 'display' : 'block' });
            jQuery.ajax({
		        url : localajax['url'], 
			    method : 'POST',
			    data : prefix + str + '&page=' + page + '&base=' + jQuery('#' + cls + '_service_info').html(),
                success : function(result, args) {
				    args = { e : e, f : category_query_click_handler }
				    innerHandler(result, args);
                }				
		    });
			return false;
		}	
	}

    jQuery("[class*='category_query_pagination']").on('click', category_query_click_handler);
	jQuery("[class*='post_format_query_pagination']").on('click', category_query_click_handler);
});