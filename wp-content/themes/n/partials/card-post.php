<article class="post post--vertical col--33">
	<a class="post-img" href="<?php the_permalink(); ?>">
		<?php the_title(); ?>
	</a>
	<div class="post-content">
		<span class="post-meta"></span>
		<h3 class="post-title"><a href="<?php the_permalink(); ?>"><?php echo wp_trim_words( get_the_title(), 5, '...' ); ?></a></h3>
	</div>
</article>