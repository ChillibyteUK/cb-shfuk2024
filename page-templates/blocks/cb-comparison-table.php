<?php
/**
 * Block template for CB Comparison Table.
 *
 * @package cb-shfuk2024
 */

defined( 'ABSPATH' ) || exit;

$block_title        = get_field( 'title' );
$competitor_heading = get_field( 'col_1_title' ) ? get_field( 'col_1_title' ) : 'Competitor';
$brand_heading      = get_field( 'col_2_title' ) ? get_field( 'col_2_title' ) : 'This Brand';

?>
<section class="comparison-table py-5">
	<div class="container-xl">
		<?php
		if ( $block_title ) {
			?>
			<h2 class="comparison-table__title text-center mb-4"><?= esc_html( $block_title ); ?></h2>
			<?php
		}
		?>
		<div class="comparison-table__shell">
			<table class="comparison-table__table">
				<thead>
					<tr class="comparison-table__head-row">
						<th scope="col" class="comparison-table__th comparison-table__th--term" aria-label="Comparison term"></th>
						<th scope="col" class="comparison-table__th comparison-table__th--competitor"><?= esc_html( $competitor_heading ); ?></th>
						<th scope="col" class="comparison-table__th comparison-table__th--brand"><?= esc_html( $brand_heading ); ?></th>
					</tr>
				</thead>
				<tbody>
					<?php
					if ( have_rows( 'table_rows' ) ) {
						while ( have_rows( 'table_rows' ) ) {
							the_row();
							?>
							<tr class="comparison-table__row">
								<th scope="row" class="comparison-table__cell comparison-table__cell--term"><?= esc_html( get_sub_field( 'term' ) ); ?></th>
								<td class="comparison-table__cell comparison-table__cell--competitor"><?= esc_html( get_sub_field( 'col_1_value' ) ); ?></td>
								<td class="comparison-table__cell comparison-table__cell--brand"><?= esc_html( get_sub_field( 'col_2_value' ) ); ?></td>
							</tr>
							<?php
						}
					}
					?>
				</tbody>
			</table>
		</div>
	</div>
</section>