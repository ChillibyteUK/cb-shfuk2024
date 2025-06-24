<?php
/**
 * Template Name: All Deals
 * Description: A template to display all deals with filtering options.
 *
 * @package cb-shfuk204
 */

defined( 'ABSPATH' ) || exit;
?>
<section class="all_deals">
    <div class="container-xl">
	<?php

	$terms = get_terms(
		array(
			'taxonomy'   => 'deal_type',
			'hide_empty' => true,
		)
	);

	$deals = new WP_Query(
		array(
			'post_type'      => 'deals',
			'posts_per_page' => -1,
		)
	);

	if ( ! empty( $terms ) ) {
		echo '<div class="mb-5 d-flex flex-wrap gap-2 filter-buttons" role="group">';
		echo '<button class="btn btn-outline-primary active" data-filter="all">All</button>';
		foreach ( $terms as $deal_term ) {
			echo '<button class="btn btn-outline-primary" data-filter="' . esc_attr( $deal_term->slug ) . '">' . esc_html( $deal_term->name ) . '</button>';
		}
		echo '</div>';
	}

	echo '<div class="all_deals__list row g-5">';

	if ( $deals->have_posts() ) {
		while ( $deals->have_posts() ) {
			$deals->the_post();

			$deal_id      = get_the_ID();
			$deal_title   = get_the_title();
			$content      = get_the_content();
			$terms        = get_the_terms( $deal_id, 'deal_type' );
			$term_classes = '';

			if ( $terms && ! is_wp_error( $terms ) ) {
				foreach ( $terms as $deal_term ) {
					$term_classes .= ' ' . esc_attr( $deal_term->slug );
				}
			}

	        $slug = sanitize_title( $deal_title );

	        ?>
        <a class="anchor" id ="<?= esc_attr( $slug ); ?>"></a>
        <div class="col-12 all_deals__item <?= esc_attr( $term_classes ); ?>">
            <div class="row g-0 align-items-start overflow-hidden">
                <div class="col-md-3">
                    <?php
                    if ( has_post_thumbnail() ) {
                        the_post_thumbnail( 'large', array( 'class' => 'img-fluid all_deals__image' ) );
                    }
                    ?>
                </div>
                <div class="col-md-9 p-3">
                    <h3><?= esc_html( $deal_title ); ?></h3>
                    <?= wp_kses_post( apply_filters( 'the_content', $content ) ); ?>
                </div>
            </div>
        </div>
        	<?php
    	}

	    wp_reset_postdata();
	}

	echo '</div>'; // .deal-list

	add_action(
		'wp_footer',
		function () {
    		?>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const buttons = document.querySelectorAll('.filter-buttons button');
        const items = document.querySelectorAll('.all_deals__item');

        buttons.forEach(function (button) {
            button.addEventListener('click', function () {
                const filter = this.getAttribute('data-filter');

                buttons.forEach(btn => btn.classList.remove('active'));
                this.classList.add('active');

                items.forEach(function (item) {
                    if (filter === 'all' || item.classList.contains(filter)) {
                        item.style.display = '';
                    } else {
                        item.style.display = 'none';
                    }
                });
            });
        });
    });
</script>
    		<?php
		}
	);
