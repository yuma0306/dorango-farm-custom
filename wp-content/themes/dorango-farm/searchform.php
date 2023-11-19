<!-- p-serach -->
<form action="<?php echo esc_url(home_url('/')); ?>" method="get" class="p-serach js-serach-form">
    <input type="text" name="s" value="<?php the_search_query(); ?>" placeholder="例）ボールパイソン" class="p-serach__input js-serach-input">
    <button type="button" class="p-serach__btn js-serach-btn">
		<span class="p-serach__glass dashicons dashicons-search"></span>
	</button>
</form>
<!-- /p-serach -->
