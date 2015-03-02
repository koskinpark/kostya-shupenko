<?php foreach ($form_elements as $element) { ?>
      <?php if (isset($element['type'])) {
          if ($element['type'] == 'div') {
            if (!empty($element['class'])) {
              ?> <div class="<?php print $element['class'] ?>"><?php
            }
    else {?> <div> <?php }

          }
        if (isset($element['sub'])) {
            foreach ($element['sub'] as $sub_element) {
        if ($sub_element['type'] == 'span') {
            ?>
            <span><?php if (isset($sub_element['text'])) { print $sub_element['text']; }?></span>
        <?php
        }

        if ($sub_element['type'] == 'ul') {
            ?>
            <ul>
                <?php foreach($sub_element['li'] as $li) {
                    ?>
                <li><?php print $li; ?></li>
                <?php
                }
                ?>
            </ul>
        <?php
        }
        ?>
    <?php }
        }
        }?>

<?php }?>
    </div>