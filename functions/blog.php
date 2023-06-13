<?php
/*
The file contain blog functions.
*/
function thelawyer_show_postmore() {
    global $secretlab;
    if (isset($secretlab['is_related_posts'])) {
        $sl_related_post = $secretlab['is_related_posts'];
        if ($sl_related_post == 1) {
            thelawyer_postmore_query();
        }
    }
}

function thelawyer_postmore_query() {
    global $post, $secretlab;
    $backup = $post;
    $tags = wp_get_post_tags($post->ID);
    if ($tags) {
        $tag_ids = array();
        foreach($tags as $individual_tag) $tag_ids[] = $individual_tag->term_id;

        $args=array(
            'tag__in' => $tag_ids,
            'post__not_in' => array($post->ID),
            'showposts'=>3, // Number of related posts that will be shown.
        );
        $my_query = new wp_query($args);
        if( $my_query->have_posts() ) {
            if (isset($secretlab['related_posts_title'])) {
                $sl_related_title = $secretlab['related_posts_title'];
                if ($sl_related_title == 1) {
                    echo '<h3>' . $sl_related_title . '</h3>';
                }
            }
            echo '<div class="related">';
            while ($my_query->have_posts()) {
                $my_query->the_post();
                ?>
                <div class="rblock">

                    <figure class="thumb">
                        <?php
                        if ( has_post_thumbnail() ) { // check if the post has a Post Thumbnail assigned to it.
                            the_post_thumbnail( 'thelawyer_related' );
                        } else {
                            echo '<img src="'.esc_url(get_template_directory_uri()).'/images/not.jpg" alt="' . $post->post_title . '" />';
                        }
                        ?>
                        <div class="vanish">
                            <a href="<?php the_permalink(); ?>"><span class="icon-link6"></span></a>
                        </div>
                    </figure>

                    <h6><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h6>

                </div>
                <?php
            }
            echo '</div>';
        }
    }
    $post = $backup;
    wp_reset_postdata();
}

// Date and continue link for post feed
if ( ! function_exists( 'thelawyer_entry_date' ) ) :
    /**
     * Print HTML with date information for current post.
     *
     * Create your own thelawyer_entry_date() to override in a child theme.
     *
     *
     * @param boolean $echo (optional) Whether to echo the date. Default true.
     * @return string The HTML-formatted post date.
     */
    function thelawyer_entry_date( $echo = true, $item = null ) {
        global $post, $secretlab;
        if (!$item) {
            $p = $post;
        }
        else {
            $p = $item;
        }
        if ( has_post_format( array( 'chat', 'status' ), $p->ID ) )
            $format_prefix = _x( '%1$s on %2$s', '1: post format name. 2: date', 'the-lawyer' );
        else
            $format_prefix = '%2$s';

        $date = sprintf( '<span class="date"> <a href="%1$s" title="%2$s" rel="bookmark"><time class="entry-date" datetime="%3$s">%4$s</time></a>',
            esc_url( get_permalink($p->ID) ),
            esc_attr( sprintf( esc_html__( 'Permalink to %s', 'the-lawyer' ), the_title_attribute( 'echo=0' ) ) ),
            esc_attr( get_the_date( 'c', $p ) ),
            esc_html( sprintf( $format_prefix, get_post_format_string( get_post_format($p->ID) ), get_the_date('F j, Y', $p) ) )
        );

        if ( $echo ) {
            $sl_show_post_date = isset($secretlab['show_post_date']) ? $secretlab['show_post_date'] : 1;
            if ($sl_show_post_date == 1) {
                echo ''.$date;
            }
        }

        if ( ! is_single() ) {
            echo '<a href="' . esc_url(get_permalink($p->ID)) . '" class="more-link">' . esc_html__('Continue reading', 'the-lawyer') . ' <span class="meta-nav">&rarr;</span></a>';
        }
        echo '</span>';

        return $date;


    }
endif;

/**
 * Print HTML with meta information for current post: categories, comments counter, author, and date.
 *
 * Create your own thelawyer_entry_meta() to override in a child theme.
 *
 */
if ( ! function_exists( 'thelawyer_entry_meta' ) ) :

    function thelawyer_entry_meta()
    {
        global $secretlab;
        //if (is_sticky() && is_home() && !is_paged())
        //echo '';

        // Post author
        $sl_show_author = isset($secretlab['show_post_author']) ? $secretlab['show_post_author'] : 1;
        if ($sl_show_author == 1) {
            if ('post' == get_post_type()) {
                printf('<span class="author vcard">'.esc_html__('by', 'the-lawyer').' <a class="url fn n" href="%1$s" title="%2$s" rel="author">%3$s</a></span>',
                    esc_url(get_author_posts_url(get_the_author_meta('ID'))),
                    esc_attr(sprintf(esc_html__('View all posts by %s', 'the-lawyer'), get_the_author())),
                    get_the_author()
                );
            }
        }

        // Categories: used between list items, there is a space after the comma.
        $categories_list = get_the_category_list(esc_html__(', ', 'the-lawyer'));
        $sl_show_post_category = isset($secretlab['show_post_category']) ? $secretlab['show_post_category'] : 1;
        if ($sl_show_post_category == 1) {
            if ($categories_list) {
                echo esc_html__('in', 'the-lawyer').' <span class="categories-links">' . $categories_list . '</span>';
            }
        }
        //Post data
        /*$sl_show_post_date = isset($secretlab['show_post_date']) ? $secretlab['show_post_date'] : 1;
        if ($sl_show_post_date == 1) {
            if (is_single()) {
                echo '<span class="date">'.the_time('F j, Y').'</span>';
            }
        }*/

        // Comments counter
        $sl_show_comments_count = isset($secretlab['show_comments_count']) ? $secretlab['show_comments_count'] : 1;
        if ($sl_show_comments_count == 1) {
            if (comments_open(get_the_ID())) {
                echo '<span class="comments-link"> ';
                comments_popup_link(esc_html__('Leave a comment', 'the-lawyer'), esc_html__('1 Comment', 'the-lawyer'), esc_html__('% Comments', 'the-lawyer'));
            }
        }
    }
endif;

/**
 * Display navigation to next/previous post when applicable.
 *
 */
if ( ! function_exists( 'thelawyer_post_nav' ) ) :

    function thelawyer_post_nav() {
        global $post;

        // Don't print empty markup if there's nowhere to navigate.
        $previous = ( is_attachment() ) ? get_post( $post->post_parent ) : get_adjacent_post( false, '', true );
        $next     = get_adjacent_post( false, '', false );

        if ( ! $next && ! $previous )
            return;
        ?>
        <nav class="navigation post-navigation" role="navigation">
            <div class="nav-links clearfix">

                <?php previous_post_link( '%link', _x( '<span class="meta-nav">&larr;</span> %title', 'Previous post link', 'the-lawyer' ) ); ?>
                <?php next_post_link( '%link', _x( '%title <span class="meta-nav">&rarr;</span>', 'Next post link', 'the-lawyer' ) ); ?>

            </div><!-- .nav-links -->
        </nav><!-- .navigation -->
        <?php
    }
endif;

/* Prev & Next Post Narrow Icons */
if ( ! function_exists( 'thelawyer_post_navicon' ) ) :
    /**
     * Display navigation to next/previous post when applicable.
     *
     */
    function thelawyer_post_navicon() {
        global $post;

        // Don't print empty markup if there's nowhere to navigate.
        $iprevious = ( is_attachment() ) ? get_post( $post->post_parent ) : get_adjacent_post( false, '', true );
        $inext     = get_adjacent_post( false, '', false );

        if ( ! $inext && ! $iprevious )
            return;
        ?>
        <div class="post-navigation-icon" role="navigation">
            <?php next_post_link( '%link', '<span class="icon-arrow-left22"></span>', TRUE ); ?>
            <?php previous_post_link( '%link', '<span class="icon-arrow-right22"></span>', TRUE ); ?>
        </div>
        <?php
    }
endif;

// Added CSS class for next and prevous links
function thelawyer_add_class_next_post_link($html){
    $html = str_replace('<a','<a class="btn btn-default alignright"',$html);
    return $html;
}
add_filter('next_post_link','thelawyer_add_class_next_post_link',10,1);

function thelawyer_add_class_previous_post_link($html){
    $html = str_replace('<a','<a class="btn btn-default alignleft"',$html);
    return $html;
}
add_filter('previous_post_link','thelawyer_add_class_previous_post_link',10,1);

// Display of CSS class, for column option of tag, category, archive and index page
function thelawyer_number_of_columns() {
    global $secretlab;
    if (isset($secretlab['blog-columns'])) {
        $sl_blog_sidebars = $secretlab['blog-sidebar-layout'];
        $sl_sidebars = $secretlab['sidebar-layout'];
        $sl_blog_columns = $secretlab['blog-columns'];

        if ( ! is_single()) {
         if ( $sl_blog_columns == 2 and $sl_blog_sidebars == 1 ) {
                echo ' blog2columnpage';
            } else {
             if ( $sl_blog_columns == 3 and $sl_blog_sidebars == 1 ) {
                 echo ' blog3columnpage';
             } else {
                 if ( $sl_blog_sidebars == 3 or $sl_blog_sidebars == 4 or $sl_sidebars == 3 or $sl_sidebars ==4 ) {
                     echo ' onecolumnnsb';
                 } else {
                     echo ' onecolumn';
                 }

             }
         }
        }
    }
}

// Tags for blog post
function thelawyer_tags() {
    global $secretlab;
    if (isset($secretlab['show_post_tags'])) {
        $sl_show_post_tags = $secretlab['show_post_tags'];
        if ($sl_show_post_tags == 1) {
            $tag_list = get_the_tag_list('', ' ');
            if ($tag_list) {
                echo '<span class="tags-links"><b>' . esc_html__('Tags', 'the-lawyer') . ':</b> ' . $tag_list . '</span>';
            }
        }
    }
}


?>
