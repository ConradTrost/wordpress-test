<?php
/*
Template Name: Resource Archive
*/
?>

<?php
get_header();

$description = get_the_archive_description();
?>


<?php get_search_form(); ?>

<style>
	.boxed-content {
		max-width: 1200px;
		margin: auto;
		margin-top: 40px;
	}
	.topics {
		width: 600px;
		margin: auto;
		float: left;
	}
	.audiences {
		width: 600px;
		margin: auto;
		float: right;
	}
	.subtitle {
		font-size: 40px;
		
	}
	.filters {
		width: 100%;
		margin-bottom: 140px;
	}
	.content {
		margin-top: 100px;
	}
</style>


<div class="boxed-content">


<?php if ( have_posts() ) : ?>

	<header class="page-header alignwide">
		<?php the_archive_title( '<h1 class="page-title">', '</h1>' ); ?>
		<?php if ( $description ) : ?>
			<div class="archive-description"><?php echo wp_kses_post( wpautop( $description ) ); ?></div>
		<?php endif; ?>
	</header><!-- .page-header -->

	<div class="filters">
<div class="topics">
<p class="subtitle">Topics:</p>
<?php
// Display each topic taxonomy

// Get the taxonomy's terms
$terms = get_terms(
    array(
        'taxonomy'   => 'topic',
        'hide_empty' => false,
    )
);

// Check if any term exists
if ( ! empty( $terms ) && is_array( $terms ) ) {
    // Run a loop and print them all
    foreach ( $terms as $term ) { ?>
        <a href="<?php echo esc_url( get_term_link( $term ) ) ?>">
            <?php echo $term->name; ?>
        </a><br><?php
    }
} 
?>
</div>

<p class="subtitle">Audiences:</p>
<div class="audiences">
<?php
// Display each audience taxonomy

// Get the taxonomy's terms
$terms = get_terms(
    array(
        'taxonomy'   => 'audience',
        'hide_empty' => false,
    )
);

// Check if any term exists
if ( ! empty( $terms ) && is_array( $terms ) ) {
    // Run a loop and print them all
    foreach ( $terms as $term ) { ?>
        <a href="<?php echo esc_url( get_term_link( $term ) ) ?>">
            <?php echo $term->name; ?>
        </a><br><?php
    }
} 
?>
</div>
</div>


<p class="subtitle">Topic 1:</p>
<!-- Filtered by Topic -->
<?php 

	$args = array(
		'post_type' => 'resource',
		'tax_query' => array(
			array(
				'taxonomy' => 'topic',
				'field' => 'slug',
				'terms' => 'topic1'
			)
		)
	);

	$resource_query = new WP_Query($args);

	if($resource_query->have_posts()) :
		while($resource_query->have_posts()) :
			$resource_query->the_post();
			?> <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>

		
	<?php	endwhile;
	endif;

?>

               <?php
                $args = array(
                    'numberposts'    => 5,
                    'post_type'      => 'resource',
                    'taxonomy_name'  => 'topic');
                query_posts( $args );
                get_template_part( 'loop', 'resource' );
                wp_reset_query();
              ?>

<!-- End filter topic 1 -->
	<?php while ( have_posts() ) : ?>

    <!-- content.php -->
		<?php the_post(); ?>
		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php if ( is_singular() ) : ?>
			<?php the_title( '<h1 class="entry-title default-max-width">', '</h1>' ); ?>
		<?php else : ?>
			<?php the_title( sprintf( '<h2 class="entry-title default-max-width"><a href="%s">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>
		<?php endif; ?>

		<?php twenty_twenty_one_post_thumbnail(); ?>
	</header><!-- .entry-header -->


	<div class="entry-content">
		<?php
		the_content(
			twenty_twenty_one_continue_reading_text()
		);

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
</article><!-- #post-${ID} -->
<!-- content.php -->

	<?php endwhile; ?>

	<?php twenty_twenty_one_the_posts_navigation(); ?>

<?php else : ?>
	<?php get_template_part( 'template-parts/content/content-none' ); ?>
<?php endif; ?>

<?php get_footer(); ?>
