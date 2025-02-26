<?php
/**
 * PHP file to use when rendering the block type on the server to show on the front end.
 *
 * The following variables are exposed to the file:
 *     $attributes (array): The block attributes.
 *     $content (string): The block default content.
 *     $block (WP_Block): The block instance.
 *
 * @package WordPress
 * @subpackage FTMCore
 * @see https://github.com/WordPress/gutenberg/blob/trunk/docs/reference-guides/block-api/block-metadata.md#render
 */

// Get the current year.
$current_year = gmdate( 'Y' );

$display_before_text = '';
$display_after_text  = '';
if ( ! empty( $attributes['beforeText'] ) ) {
	$display_before_text = $attributes['beforeText'] . ' ';
}

if ( ! empty( $attributes['afterText'] ) ) {
	$display_after_text = ' ' . $attributes['afterText'];
}
// Determine which content to display.
if ( isset( $attributes['fallbackCurrentYear'] ) && $attributes['fallbackCurrentYear'] === $current_year ) {

	// The current year is the same as the fallback, so use the block content saved in the database (by the save.js function).
	$block_content = $content;
} else {

	// The current year is different from the fallback, so render the updated block content.
	if ( ! empty( $attributes['startingYear'] ) && ! empty( $attributes['showStartingYear'] ) ) {
		$display_date = $attributes['startingYear'] . '–' . $current_year;
	} else {
		$display_date = $current_year;
	}

	$block_content = '<p ' . get_block_wrapper_attributes() . '>' . esc_html( $display_before_text ) . '© ' . esc_html( $display_date ) . esc_html( $display_after_text ) . '</p>';
}

echo wp_kses_post( $block_content );
