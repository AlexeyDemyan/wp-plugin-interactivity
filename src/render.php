<?php

/**
 * PHP file to use when rendering the block type on the server to show on the front end.
 *
 * The following variables are exposed to the file:
 *     $attributes (array): The block attributes.
 *     $content (string): The block default content.
 *     $block (WP_Block): The block instance.
 *
 * @see https://github.com/WordPress/gutenberg/blob/trunk/docs/reference-guides/block-api/block-metadata.md#render
 */

?>

<!-- wp data attribute is to gain access to Interactivity API -->
<!-- In this particualr case we're hooking up to the store named "create-block" that we created in view.js -->
<!-- Below is example of creating a value in context and pulling it into the text of the Span -->
<div data-wp-interactive="create-block" data-wp-context='{"clickCount": 0}'>
	<p>The button below has been clicked <span data-wp-text="context.clickCount"></span> times</p>
	<button data-wp-on--click="actions.buttonHandler">Click me!</button>
</div>