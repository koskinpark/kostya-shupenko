<form ENCTYPE="multipart/form-data" action="main/content/add" method="POST" autocomplete="off">
  <label>Заголовок </label>
  <?php print $content_type == 'new' ? 'новости' : 'статьи' ?></br>
  <input type="text" name="title"></br>
  <label>Текст</label>
  <?php print $content_type == 'new' ? 'новости' : 'статьи' ?></br>
  <textarea name="body" wrap="virtual" cols="50" rows="5"></textarea><br>
  <input type="submit" value="Сохранить">
  <input type="hidden" name="type" value="<?php print $content_type ?>" />
  <input type="hidden" name="token" value="<?php print $token ?>" />
</form>