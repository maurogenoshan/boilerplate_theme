<?php
/**
 * T
 *
 * @package genosha
 */

namespace App\Callbacks;


/**
 * GutenbergCallbacks class
 */
class GutenbergCallbacks
{
	/**
	 * register default hooks and actions for WordPress
	 * @return
	 */
	public function block_default_callback($fields, $attributes, $inner_blocks) 
	{
		?>

		<div class="block">
			<div class="block__heading">
				<h1><?php echo esc_html( $fields['heading'] ); ?></h1>
			</div><!-- /.block__heading -->

			<div class="block__image">
				<?php echo wp_get_attachment_image( $fields['image'], 'full' ); ?>
			</div><!-- /.block__image -->

			<div class="block__content">
				<?php echo apply_filters( 'the_content', $fields['content'] ); ?>
			</div><!-- /.block__content -->
		</div><!-- /.block -->

		<?php
	}

	
}
