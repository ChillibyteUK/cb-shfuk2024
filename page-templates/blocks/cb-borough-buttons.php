<?php
/**
 * Block template for CB Borough Buttons.
 *
 * @package cb-shfuk2024
 */

defined( 'ABSPATH' ) || exit;

$boroughs = array(
	'barking'        => 'Barking',
	'barnet'         => 'Barnet',
	'bexley'         => 'Bexley',
	'brent'          => 'Brent',
	'bromley'        => 'Bromley',
	'camden'         => 'Camden',
	'chelsea'        => 'Chelsea',
	'croydon'        => 'Croydon',
	'dagenham'       => 'Dagenham',
	'ealing'         => 'Ealing',
	'enfield'        => 'Enfield',
	'fulham'         => 'Fulham',
	'greenwich'      => 'Greenwich',
	'hackney'        => 'Hackney',
	'hammersmith'    => 'Hammersmith',
	'haringey'       => 'Haringey',
	'harrow'         => 'Harrow',
	'havering'       => 'Havering',
	'hillingdon'     => 'Hillingdon',
	'hounslow'       => 'Hounslow',
	'islington'      => 'Islington',
	'kensington'     => 'Kensington',
	'kingston'       => 'Kingston',
	'lambeth'        => 'Lambeth',
	'lewisham'       => 'Lewisham',
	'merton'         => 'Merton',
	'newham'         => 'Newham',
	'redbridge'      => 'Redbridge',
	'richmond'       => 'Richmond',
	'southwark'      => 'Southwark',
	'sutton'         => 'Sutton',
	'tower-hamlets'  => 'Tower Hamlets',
	'waltham-forest' => 'Waltham Forest',
	'wandsworth'     => 'Wandsworth',
	'westminster'    => 'Westminster',
);

// if page exists for borough, show button	
?>
<section class="borough-buttons py-5">
	<div class="container-xl">
		<div class="borough-buttons__grid">
			<?php
			foreach ( $boroughs as $slug => $name ) {
				$borough_page = get_page_by_path( '/locations/london/sell-house-fast-' . $slug );
				if ( $borough_page ) {
					$borough_link = get_permalink( $borough_page->ID );
					// make sure page is published.
					if ( 'publish' !== get_post_status( $borough_page->ID ) ) {
						continue;
					}
					?>
					<a class="button" href="<?php echo esc_url( $borough_link ); ?>">
						<?php echo esc_html( $name ); ?>
					</a>
					<?php
				}
			}
			?>
		</div>
	</div>
</section>