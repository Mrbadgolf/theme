<?php

/**
 * The Header template for our theme
 */
 
set_globals();

?>
<!doctype html>
<html <?php language_attributes(); ?> class="no-js">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php 
	    thelawyer_headicons();
        do_action('get_header_scripts');
		wp_head();
		thelawyer_set_boxed_background();
	?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<?php
	thelawyer_pageloader();
    thelawyer_set_boxed_layout();
	thelawyer_head_num();
?>

<main>
	<div class="container">
		<div class="row">
			<?php
			thelawyer_set_header_sidebar_layout();
			?>


