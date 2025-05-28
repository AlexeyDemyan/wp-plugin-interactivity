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

<?php
$answers = array();
for ($i = 0; $i < count($attributes['answers']); $i++) {
	$answers[$i]['index'] = $i;
	$answers[$i]['text'] = $attributes['answers'][$i];
	$answers[$i]['correct'] = $attributes['correctAnswer'] == $i;
}
$customContext = array(
	'answers' => $answers,
	'solved' => false,
	'showCongrats' => false,
	'showSorry' => false,
	'correctAnswer' => $attributes['correctAnswer']
);
?>

<div
	class="paying-attention-frontend"
	style="background-color: <?php echo $attributes['bgColor'] ?>;"
	data-wp-interactive="create-block"
	<?php echo wp_interactivity_data_wp_context($customContext) ?>>
	<p><?php echo $attributes['question'] ?></p>
	<ul>
		<?php
		foreach ($attributes['answers'] as $answer) {
		?>
			<!-- Child items get access to their context, but also to that of their parents -->
			<!-- And below we are merging the 2 contexts -->
			<li data-wp-context='{"skyColor":"blue-ish"}' data-wp-on--click="actions.guessAttempt"><?php echo $answer ?></li>
		<?php
		}
		?>
	</ul>
</div>