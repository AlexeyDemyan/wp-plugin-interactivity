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
<!-- Echoing wp_interactivity_data_wp_context populates data-wp-context with whatever we're passing as parameter-->
<!-- It also conveniently transpiles PHP array into a JS array -->
<div
	class="paying-attention-frontend"
	style="background-color: <?php echo $attributes['bgColor'] ?>;" 
	data-wp-interactive="create-block"
	<?php echo wp_interactivity_data_wp_context($attributes) ?>
	>
	<p><?php echo $attributes['question'] ?></p>
	<ul>
		<!-- data-wp-each sort of starts the loop, and context.item is the reserved way to access one item -->
		<template data-wp-each="context.answers">
			<li data-wp-on--click="actions.guessAttempt" data-wp-text="context.item"></li>
		</template>
	</ul>
</div>