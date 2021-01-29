<?php
/*
Template Name: Resources
*/
?>

<?php

get_header();


/* Start the Loop */
while ( have_posts() ) :
	the_post();

?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<header class="entry-header alignwide">
		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
		<?php twenty_twenty_one_post_thumbnail(); ?>

<h3 class="class-date">Posted: <?php echo the_date(); ?></h3>
		<h3 class="class-taxonomies" >Topics:</h3>
		<ul>
		<?php 
	$custom_taxonomy = get_the_terms(0, 'topic');
if ($custom_taxonomy) {
    foreach ($custom_taxonomy as $custom_tax) {
        echo "<li>$custom_tax->name</li>";
    }
} ?>
</ul>

		<h3 class="class-audiences" >Audiences:</h3>
		<ul>
		<?php 
	$custom_taxonomy = get_the_terms(0, 'audience');
if ($custom_taxonomy) {
    foreach ($custom_taxonomy as $custom_tax) {
        echo "<li>$custom_tax->name</li>";
    }
} ?>
</ul>

<a href="<?php get_post_meta(get_the_ID(), 'download', TRUE) ?>" download>download link from custom field</a><br>

<?php 

$docURL = 

$url = $_SERVER['REQUEST_URI'];
echo "<a href=$url download>Download link from _SERVER['REQUEST_URI']</a><br>";

$explode_url = explode('/', $url);
array_pop($explode_url);
array_pop($explode_url);
$backLink = implode('/', $explode_url);
echo "<a href=$backLink>Back</a>"


?>

	</header>

	<div class="entry-content">
		<?php
		the_content();

		wp_link_pages(
			array(
				'before'   => '<nav class="page-links" aria-label="' . esc_attr__( 'Page', 'twentytwentyone' ) . '">',
				'after'    => '</nav>',
				/* translators: %: page number. */
				'pagelink' => esc_html__( 'Page %', 'twentytwentyone' ),
			)
		);
		?>
	</div><!-- .entry-content -->

	<footer class="entry-footer default-max-width">
		<?php twenty_twenty_one_entry_meta_footer(); ?>
	</footer><!-- .entry-footer -->

	<?php if ( ! is_singular( 'attachment' ) ) : ?>
		<?php get_template_part( 'template-parts/post/author-bio' ); ?>
	<?php endif; ?>

</article><!-- #post-${ID} -->


<?php

	if ( is_attachment() ) {
		// Parent post navigation.
		the_post_navigation(
			array(
				/* translators: %s: parent post link. */
				'prev_text' => sprintf( __( '<span class="meta-nav">Published in</span><span class="post-title">%s</span>', 'twentytwentyone' ), '%title' ),
			)
		);
	}

	// Previous/next post navigation.
	$twentytwentyone_next = is_rtl() ? twenty_twenty_one_get_icon_svg( 'ui', 'arrow_left' ) : twenty_twenty_one_get_icon_svg( 'ui', 'arrow_right' );
	$twentytwentyone_prev = is_rtl() ? twenty_twenty_one_get_icon_svg( 'ui', 'arrow_right' ) : twenty_twenty_one_get_icon_svg( 'ui', 'arrow_left' );

	$twentytwentyone_post_type      = get_post_type_object( get_post_type() );
	$twentytwentyone_post_type_name = '';
	if (
		is_object( $twentytwentyone_post_type ) &&
		property_exists( $twentytwentyone_post_type, 'labels' ) &&
		is_object( $twentytwentyone_post_type->labels ) &&
		property_exists( $twentytwentyone_post_type->labels, 'singular_name' )
	) {
		$twentytwentyone_post_type_name = $twentytwentyone_post_type->labels->singular_name;
	}

	/* translators: %s: The post-type singlular name (example: Post, Page etc) */
	$twentytwentyone_next_label = sprintf( esc_html__( 'Next %s', 'twentytwentyone' ), $twentytwentyone_post_type_name );
	/* translators: %s: The post-type singlular name (example: Post, Page etc) */
	$twentytwentyone_previous_label = sprintf( esc_html__( 'Previous %s', 'twentytwentyone' ), $twentytwentyone_post_type_name );

	the_post_navigation(
		array(
			'next_text' => '<p class="meta-nav">' . $twentytwentyone_next_label . $twentytwentyone_next . '</p><p class="post-title">%title</p>',
			'prev_text' => '<p class="meta-nav">' . $twentytwentyone_prev . $twentytwentyone_previous_label . '</p><p class="post-title">%title</p>',
		)
	);
	
endwhile; // End of the loop.

get_footer();
