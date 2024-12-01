<h2><?php echo esc($title) ?></h2>
<?php echo session()->getFlashdata('error') ?>
<?php echo validation_list_errors() ?>

<form action="/news" method="post">
     <?php echo csrf_field() ?>
     <label for="title">Title</label>
     <input type="input" name="title" value="<?php echo set_value('title')?>"Title</label>
     <br>

    <label for="body">Text</label>
    <textarea name="body" cols="45" rows="4"><?php echo set_value('body') ?></textarea>
    <br>

    <input type="submit" name="submit" value="Create news item">
</form>
