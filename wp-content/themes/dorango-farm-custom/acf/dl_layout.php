<?php
	$list = get_sub_field('dl_field');
?>
<?php if(!empty($list)): ?>
	<div class="article-block">
		<div class="article-dl">
			<?php foreach($list as $item): ?>
				<dl class="article-dl__list">
					<dt class="article-dl__term">
						<?php echo $item['dt_field'];	?>
					</dt>
					<dd class="article-dl__desc">
						<?php echo $item['dd_field']; ?>
					</dd>
				</dl>
			<?php endforeach; ?>
		</div>
	</div>
<?php endif; ?>

