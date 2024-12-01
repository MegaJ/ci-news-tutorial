<h2><?php echo esc($title) ?></h2>

<?php if ($news_list !== []) : ?>

    <?php foreach ($news_list as $news_item): ?>

        <h3><?php echo esc($news_item['title']) ?></h3>

        <div class="main">
            <?php echo esc($news_item['body']) ?>
        </div>
        <p><a href="/news/<?php echo esc($news_item['slug'], 'url') ?>">View article</a></p>

    <?php endforeach ?>

<?php else: ?>

    <h3>No News</h3>

    <p>Unable to find any news for you.</p>

<?php endif ?>
