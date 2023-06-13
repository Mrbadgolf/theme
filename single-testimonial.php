<?php
/*
Single Testimonial Template for Testimonial Custom Post Type
*/

get_header(); ?>


                <?php /* The loop */ ?>
                <?php while ( have_posts() ) : the_post(); ?>
                    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                        <h1 class="entry-title"><?php the_title(); ?></h1>
                        <div class="entry-content">
                            <div class="testimonialsingle">
                                <span class="icon-quote-right"></span>
                                <div class="face">
                                    <?php
                                    $client_name = types_render_field("name-of-client", array("output"=>"normal"));
                                    $client_post = types_render_field("post-of-client", array("output"=>"normal"));
                                    $client_photo = types_render_field( "photo-of-client", array("url" => "true"));
                                    if (isset ($client_photo)) {
                                        echo '<img src="' . esc_url($client_photo) . '" alt="'.$client_name.'">';
                                    }
                                    echo '<strong>'.esc_attr($client_name).'</strong><p>'.esc_attr($client_post).'</p>';
                                    ?>
                                </div>

                                <div class="mention">
                                    <?php the_content(); ?>
                                    <div class="entry-meta">
                                        <?php
                                        the_time('j M Y');
                                        edit_post_link( esc_html__( 'Edit', 'the-lawyer' ), ' <span class="edit-link">', '</span>');
                                        ?>
                                    </div>
                                </div>
                            </div>

                        </div><!-- .entry-content -->
                    </article><!-- #post -->

                    <?php thelawyer_post_nav(); ?>


                <?php endwhile; ?>

<?php get_footer(); ?>
