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
		foreach ($customContext['answers'] as $answer) {
		?>
			<!-- Child items get access to their context, but also to that of their parents -->
			<!-- And below we are merging the 2 contexts -->
			<li data-wp-class--fade-incorrect="callbacks.fadedClass" data-wp-class--no-click="callbacks.noClickClass" <?php echo wp_interactivity_data_wp_context($answer) ?> data-wp-on--click="actions.guessAttempt">
				<span data-wp-bind--hidden="!context.solved">
					<span data-wp-bind--hidden="!context.correct"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 16 16">
							<path d="M10.97 4.97a.75.75 0 0 1 1.07 1.05l-3.99 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.267.267 0 0 1 .02-.022z" />
						</svg></span>
					<span data-wp-bind--hidden="context.correct"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 16 16">
							<path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z" />
						</svg></span>
				</span>
				<?php echo $answer['text'] ?>
			</li>
		<?php
		}
		?>
	</ul>
	<div class="correct-message" data-wp-class--correct-message--visible="context.showCongrats">
		<p>That is correct</p>
	</div>
	<div class="incorrect-message" data-wp-class--incorrect-message--visible="context.showSorry">
		<p>That is incorrect </p>
	</div>
</div>
</div>