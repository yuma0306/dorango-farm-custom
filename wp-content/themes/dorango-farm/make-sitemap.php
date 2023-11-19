<?php
    header('Content-Type: text/xml; charset=' . get_option('blog_charset'), true );
    echo '<?xml version="1.0" encoding="' . get_option('blog_charset') . '"?>' . "\n";
    $args = array(
        'posts_per_page' => -1,
        'orderby' => 'modified',
        'post_type' => array(
            'post',
            'page',
            // 'custom',
        ),
        // 'order' => 'DESC'
    );
    $the_query = new WP_Query($args);
?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <url>
        <loc><?php echo home_url(); ?></loc>
        <lastmod><?php echo date('Y-m-d', strtotime(get_lastpostdate('blog'))); ?></lastmod>
    </url>
    <?php while($the_query->have_posts()): ?>
        <?php $the_query->the_post(); ?>
        <url>
            <loc><?php echo urldecode(get_the_permalink()); ?></loc>
            <lastmod><?php echo get_the_modified_date('Y-m-d'); ?></lastmod>
        </url>
    <?php endwhile; ?>
</urlset>
