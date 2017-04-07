<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package dart-theme
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

		 <div id="ajax-posts" class="row">
        <?php
			$cat_id=2;
            $postsPerPage = 1;
            $args = array(
                    'post_type' => 'post',
                    'posts_per_page' => $postsPerPage,
                    'cat' => 2
            );
			
			

            $loop = new WP_Query($args);

            while ($loop->have_posts()) : $loop->the_post();
        ?>

         <div class="small-12 large-4 columns">
                <h1><?php the_title(); ?></h1>
                <p><?php the_content(); ?></p>
         </div>

         <?php
                endwhile;
        wp_reset_postdata();
         ?>
    </div>
	<div id="more_posts" data-category="<?php echo $cat_id; ?>">Load More</div>
    

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_sidebar();
get_footer();
