<?php
/**
 * Help admin page html.
 *
 * @link  https://iqonic.design
 *
 * @package    Graphina_Charts_For_Elementor
 */

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	die( 'Something went wrong' );
}
?>
<div id="general" class="graphina-tab-detail">
	<div class="row">
		<div class="col">
			<div class="graphina_card">
				<div class="graphina_card_body">
					<h3 class="graphina_card_title"><?php echo esc_html__( 'Documentation', 'graphina-charts-for-elementor' ); ?></h3>
					<p class="graphina_card_text"><?php echo esc_html__( 'Get started by spending some time with the documentation to get familiar with Graphina Charts.', 'graphina-charts-for-elementor' ); ?></p>
					<a href="https://apps.iqonic.design/docs/product/graphina-elementor-charts-and-graphs/" class="graphina_document_button" target="_blank" ><?php echo esc_html__( 'Documentation', 'graphina-charts-for-elementor' ); ?></a>
				</div>
			</div>
		</div>
		<div class="col">
			<div class="graphina_card">
				<div class="graphina_card_body">
					<h3 class="graphina_card_title"><?php echo esc_html__( 'Need Help?', 'graphina-charts-for-elementor' ); ?></h3>
					<p class="graphina_card_text">
						<?php echo esc_html__( 'We are constantly working to make your experience better. Still faced a problem? Need assistance ?', 'graphina-charts-for-elementor' ); ?></p>
					<a href="mailto:hello@iqonic.com" class="graphina_document_button"><?php echo esc_html__( 'Contact Us', 'graphina-charts-for-elementor' ); ?></a>
				</div>
			</div>
		</div>
	</div>
</div>