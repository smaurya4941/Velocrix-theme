<?php
// Comments list + "Leave a Reply" form (WordPress core handles saving/spam rules; no plugin)
if ( post_password_required() ) return;
?>
<div class="comments-area" id="comments">
	<?php if ( have_comments() ) : ?>
		<h3 class="comments-title"><?php echo esc_html( get_comments_number() ); ?> Comment<?php echo get_comments_number() == 1 ? '' : 's'; ?></h3>
		<ol class="comment-list">
			<?php wp_list_comments( array( 'style' => 'ol', 'short_ping' => true, 'avatar_size' => 56 ) ); ?>
		</ol>
		<?php the_comments_pagination(); ?>
	<?php endif; ?>

	<?php
	comment_form( array(
		'title_reply'         => 'Leave a Reply',
		'comment_notes_before'=> '<p class="comment-notes">Your email address will not be published. Required fields are marked <span class="required">*</span></p>',
		'class_form'          => 'comment-form vx-comment-form',
		'class_submit'        => 'btn',
		'label_submit'        => 'Post Comment',
		'submit_button'       => '<button name="%1$s" type="submit" id="%2$s" class="%3$s">%4$s</button>',
		'submit_field'        => '<p class="form-submit">%1$s %2$s</p>',
	) );
	?>
</div>
