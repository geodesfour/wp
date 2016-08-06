<?php if(get_field('opt_general_display_publish_date', 'option') && get_field('opt_general_display_authors', 'option')): ?>
	<p class="article-meta">Publié le <?php the_date(); ?> par <?php the_author(); ?></p>
<?php endif; ?>
<?php if(get_field('opt_general_display_authors', 'option') && !get_field('opt_general_display_publish_date', 'option')): ?>
	<p class="article-meta">Publié par <?php the_author(); ?></p>
<?php endif; ?>
<?php if(get_field('opt_general_display_publish_date', 'option') && !get_field('opt_general_display_authors', 'option')): ?>
	<p class="article-meta">Publié le <?php the_date(); ?></p>
<?php endif; ?>
