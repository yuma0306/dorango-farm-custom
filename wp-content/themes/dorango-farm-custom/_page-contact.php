<?php
/**
 * Template Name: お問い合わせ
 */

?>
<!DOCTYPE html>
<html lang="ja">
<?php get_template_part('include/head'); ?>
<body>
	<?php get_template_part('include/gtm-body'); ?>
	<div class="wrapper">
		<?php get_template_part('include/header'); ?>
		<main class="main">
			<h1 class="heading-lv1-01">
				<span class="heading-lv1-01__text">お問い合わせ</span>
			</h1>
			<div class="inner inner--small">
				<?php displayBreadcrumnbs(); ?>
				<section class="article-content">
					<?php getAcfArticle(); ?>
				</section>
				<form class="contact-form grid-block" action="">
					<div class="contact-group">
						<label class="contact-label" for="">
							<span class="contact-label__tag">必須</span>
							<span class="contact-label__text">お名前</span>
						</label>
						<div class="contact-block">
							<input class="contact-block__input" id="" name="email" type="text" placeholder="ヘビ牧場&emsp;太郎">
						</div>
					</div>
					<div class="contact-group">
						<label class="contact-label" for="">
							<span class="contact-label__tag">必須</span>
							<span class="contact-label__text">メールアドレス</span>
						</label>
						<div class="contact-block">
							<input class="contact-block__input" id="" name="" type="email" placeholder="xxx@gmail.com">
						</div>
					</div>
					<div class="contact-group">
						<label class="contact-label" for="">
							<span class="contact-label__tag">必須</span>
							<span class="contact-label__text">お問い合わせ内容</span>
						</label>
						<div class="contact-block">
							<textarea class="contact-block__textarea" id="" name="" placeholder="お問い合わせ内容を入力してください。"></textarea>
						</div>
					</div>
					<button type="button" class="btn-link01">送信</button>
				</form>
			</div>
		</main>
		<?php get_template_part('include/footer'); ?>
	</div>
	<script src="<?php echo get_template_directory_uri() ?>/assets/js/common.js" defer></script>
    <?php wp_footer(); ?>
</body>
</html>
