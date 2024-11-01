<?php
/*
 *	This is the archive page for global search results.
 */


$bpkb_sidebar_position = basepress_sidebar_position( true );
$bpkb_show_sidebar = is_active_sidebar( 'basepress-sidebar' ) && $bpkb_sidebar_position != 'none';
$bpkb_content_classes = $bpkb_show_sidebar ? ' show-sidebar' : '';

//Get Post meta icons
$bpkb_post_meta_icons = basepress_get_post_meta_icons();
$bpkb_post_views_icon = isset( $bpkb_post_meta_icons[0] ) ? $bpkb_post_meta_icons[0] : '';
$bpkb_post_like_icon = isset( $bpkb_post_meta_icons[1] ) ? $bpkb_post_meta_icons[1] : '';
$bpkb_post_dislike_icon = isset( $bpkb_post_meta_icons[2] ) ? $bpkb_post_meta_icons[2] : '';
$bpkb_post_date_icon = isset( $bpkb_post_meta_icons[3] ) ? $bpkb_post_meta_icons[3] : '';

//Get active theme header
basepress_get_header( 'basepress' );
?>

	<div class="bpress-wrap">

		<div class="bpress-page-header">
			<div class="bpress-content-wrap">
				<!-- Knowledge Base title -->
				<header>
					<h2><?php echo esc_html( apply_filters( 'basepress_modern_theme_header_title', 'Knowledge Base' ) ); ?></h2>
				</header>

				<!-- Add searchbar -->
				<div class="bpress-searchbar-wrap">
					<?php basepress_searchbar(); ?>
				</div>
			</div>
		</div>

		<!-- Add breadcrumbs -->
		<div class="bpress-crumbs-wrap">
			<div class="bpress-content-wrap">
				<?php basepress_breadcrumbs(); ?>
			</div>
		</div>

		<div class="bpress-content-wrap">
			<div class="bpress-content-area bpress-float-<?php echo esc_attr( $bpkb_sidebar_position ) . esc_attr( $bpkb_content_classes ); ?>">

				<!-- Add main content -->
				<main class="bpress-main" role="main">

					<?php if ( have_posts() ) { ?>

						<h1><?php echo esc_html( basepress_search_page_title() ) . ' ' . esc_html( basepress_search_term() ); ?></h1>
						<ul class="bpress-post-list">

							<?php
							while ( have_posts() ) {
								the_post();
								$bpkb_show_post_icon = basepress_show_post_icon();
								$bpkb_post_class = $bpkb_show_post_icon ? ' show-icon' : '';
								?>

								<li class="bpress-post-link search bpress-clear">
									<div class="bpress-heading<?php echo esc_attr( $bpkb_post_class ) ; ?>">
										<!-- Post icon -->
										<?php if ( basepress_show_post_icon() ) { ?>
											<span aria-hidden="true" class="bpress-heading-icon <?php echo esc_attr( basepress_post_icon( get_the_ID() ) ) ; ?> colored"></span>
										<?php } ?>
										<h3>
											<!-- Post permalink -->
											<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
										</h3>
									</div>

									<p><?php basepress_search_post_snippet(); ?></p>

									<?php if( 'knowledgebase' == get_post_type() ) { ?>
										<?php	$bpkb_post_section = get_the_terms( get_the_ID(), 'knowledgebase_cat' )[0];
										if( ! empty( $bpkb_post_section ) && ! is_wp_error( $bpkb_post_section ) ){	?>
											<a href="<?php echo esc_url( get_term_link( $bpkb_post_section ) ); ?>" class="bpress-search-section"><?php echo esc_html( $bpkb_post_section->name ); ?></a>
										<?php } ?>
										<div class="bpress-post-meta">
											<?php $bpkb_post_metas = basepress_get_post_meta( get_the_ID() ); ?>

											<span class="bpress-post-views"><span class="<?php echo esc_attr( $bpkb_post_views_icon ) ; ?>"></span><?php echo esc_html( $bpkb_post_metas['views'] ) ; ?></span>
											<?php if ( basepress_show_post_votes() ) { ?>
											<span class="bpress-post-likes"><span class="<?php echo esc_attr( $bpkb_post_like_icon ); ?>"></span><?php echo esc_html( $bpkb_post_metas['votes']['like'] ) ; ?></span>
											<span class="bpress-post-dislikes"><span class="<?php echo esc_attr( $bpkb_post_dislike_icon ); ?>"></span><?php echo esc_html( $bpkb_post_metas['votes']['dislike'] ) ; ?></span>
											<?php } ?>
											<span class="bpress-post-date"><span class="<?php echo esc_attr( $bpkb_post_date_icon ); ?>"></span><?php echo esc_html( get_the_modified_date() ) ; ?></span>
										</div>
									<?php } ?>
								</li>

							<?php	} //End while ?>

						</ul>
					<?php
					} else {
						echo '<h3>' . esc_html( basepress_search_page_no_results_title() )  . '</h3>';
					}
					?>

				</main>

				<!-- Pagination -->
				<nav class="bpress-pagination">
					<?php	basepress_pagination(); ?>
				</nav>

			</div><!-- content area -->

			<!-- BasePress Sidebar -->
			<?php if ( $bpkb_show_sidebar ) : ?>
			<aside class="bpress-sidebar bpress-float-<?php echo esc_attr( $bpkb_sidebar_position ); ?>" role="complementary">
				<div class="hide-scrollbars">
					<?php dynamic_sidebar( 'basepress-sidebar' ); ?>
				</div>
			</aside>
			<?php endif; ?>

		</div>
	</div><!-- wrap -->
<?php basepress_get_footer( 'basepress' ); ?>
