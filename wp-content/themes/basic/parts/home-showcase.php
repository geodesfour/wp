	<?php if( get_field('opt_general_container_fluid', 'options') || get_field('opt_general_boxed_mode', 'options')): ?>
	<div class="container-fluid">
	<?php else: ?>
	<div class="container">
	<?php endif; ?>
		<div class="row">

			<div class="col-lg-8 col-md-12 col-xs-12 mb-md-3x mb-xs-2x">
				<?php get_template_part( 'parts/home', 'carousel' ); ?>
			</div>

			<div class="col-lg-4 col-md-12 col-xs-12">
				<?php get_template_part( 'parts/home', 'accessdirect' ); ?>
			</div>

		</div>
	</div>