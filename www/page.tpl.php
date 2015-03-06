<!DOCTYPE html PUBLIC "">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <script type='text/javascript' src='/jquery-1.10.2.min.js'></script>
    <script type="text/javascript" src="jquery.snippet.js"></script>
  <script type='text/javascript' src='/common.js'></script>
    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
  <link type="text/css" rel="stylesheet" href="/common.css"> </link>
  <link rel="stylesheet" type="text/css" href="/style.css" /> </link>
    <link rel="stylesheet" type="text/css" href="/jquery.snippet.css" />
    <link href="/media-queries.css" rel="stylesheet" type="text/css">
</head>
<?php
?>
<body class="<?php print $body_classes; ?>">
<div id="page-wrapper">
  <div id="header-wrapper">
        <div class="titles_of_head">
        </div>
      <div class="nav">
      <ul>
        <li><a href="http://kostya.shupenko.ru/main">Home</a></li>
        <li><a id="scroll-to-contacts">Contacts</a></li>
        <li><a href="http://kostya.shupenko.ru/main">Gallery</a></li>
        <li><a href="http://kostya.shupenko.ru/adci">Tasks</a></li>
      </ul>

    </div>
      <? /*
    <img src="<?php !empty($header_img) ? print "$header_img" : print '';?>" class="header-img"/>
 */ ?>
  </div>


  <?php if (!empty($sidebar)) {
      !empty($sidebar['id']) ? print '<div id=' . $sidebar['id'] . '>' : print '<div>';

      if (!empty($sidebar['theme'])) {
          print theme($sidebar['theme']);
      }
      print '</div>';
  }


  ?>

  <div id="content-wrapper"<?php !empty($class_content) ? print ' class=' . $class_content . '>' : print '>' ?>
    <div <?php !empty($content_bg) ? print "class=$content_bg" : '';?>>
  <?php print $content; ?>
    </div>
    </div>



  <div id="footer-wrapper">
    <div class="main-footer">
      <div class="sub-block-footer">
        <h2 class="footer_h2">About me</h2>
        <div>
          <p class="footer_h2 footer_p">Here is some informaton about me</p>
          <p class="footer_h2 footer_p">Too here</p>
        </div>
      </div>
      <div class="sub-block-footer">
        <h2 class="footer_h2">Contacts</h2>
        <div>
          <p class="footer_h2 footer_p">email: koskinparkin@gmail.com</p>
          <p class="footer_h2 footer_p">Home phone: 8-3812-72-19-37</p>
          <p class="footer_h2 footer_p">Mobile phone: 8-906-992-65-12</p>
        </div>
      </div>
    </div>
  </div>

<div id="feedback-wrap">
    <div class="feedback-block">
    <div class="feedback-arrow">
   <a href="#top"></a>
        </div>
        <div>
        <span>TO TOP</span>
            </div>
        </div>
</div>
</div>
</body>
</html>