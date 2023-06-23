<?php get_header();?>
<main role="main">
	<!-- コンテンツ取得 -->
	<?php 
	if(have_posts()): while(have_posts()): the_post();
		the_content();
	endwhile; endif; wp_reset_postdata();
	?>
	<!-- ページャーを取得 -->
	<?php if (get_previous_post()):?>
		<p><?php previous_post_link('%link', '前の記事'); ?></p>
	<?php endif; ?>

	<?php if (get_next_post()):?>
		<p><?php next_post_link('%link', '次の記事'); ?></p>
	<?php endif; ?>
</main>
<?php get_footer();?>