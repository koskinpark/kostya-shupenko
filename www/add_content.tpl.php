<form ENCTYPE="multipart/form-data" action="main/content/add" method="POST" autocomplete="off">
  <label>��������� </label>
  <?php print $content_type == 'new' ? '�������' : '������' ?></br>
  <input type="text" name="title"></br>
  <label>�����</label>
  <?php print $content_type == 'new' ? '�������' : '������' ?></br>
  <textarea name="body" wrap="virtual" cols="50" rows="5"></textarea><br>
  <input type="submit" value="���������">
  <input type="hidden" name="type" value="<?php print $content_type ?>" />
  <input type="hidden" name="token" value="<?php print $token ?>" />
</form>