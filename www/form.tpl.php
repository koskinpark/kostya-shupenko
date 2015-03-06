<form<?php if (isset($enctype)): ?> enctype="<?php print $enctype ?>" <?php endif; ?> method="POST" action="<?php print $action ?>" <?php if (isset($id_form)) {?> id="<?php print $id_form;}?>" <?php if (isset($form_class)) {?> class="<?php print $form_class;}?>">
  <?php foreach ($form_elements as $element): ?>
    <div>
      <?php if (isset($element['title']) && ($element['input_type'] != 'radio' && $element['input_type'] != 'checkbox')): ?>
        <div>
          <label for="<?php print $element['id'] ?>"><?php print $element['title'] ?></label>
        </div>
      <?php endif; ?>
      <?php if ($element['type'] != 'label'): ?>
        <?php if ($element['type'] == 'ul'): ?>
          <ul>
                <?php
                for ($i=0; $i<count($element['li']); $i++) {
                  print '<li>' . $element['li'][$i] . '</li>';
                }
              ?>
          </ul>

        <?php elseif ($element['type'] == 'textarea'): ?>
          <textarea id="<?php print $element['id'] ?>"
                    name="<?php print $element['name']; ?>"><?php print isset($element['value']) ? $element['value'] : '' ?></textarea>

        <?php elseif ($element['type'] == 'select'): ?>
          <select id="<?php print $element['id'] ?>" name="<?php print $element['name'] ?>" class="<?php print $element['class'] ?>">
            <?php foreach ($element['options'] as $key => $value): ?>
              <option value="<?php print $key; ?>"><?php print $value ?></option>
            <?php endforeach; ?>
          </select>
        <?php
        elseif ($element['type'] == 'span'): ?>
          <div>
            <span <?php print isset($element['class']) ? 'class="' . $element['class'] . '" ' : ''?>><?php print $element['value']; ?></span>
          </div>
            <?php elseif ($element['type'] == 'div'): ?>
            <div <?php print isset($element['id']) ? 'id="' . $element['id'] . '" ' : ''?>>
            </div>

        <?php
        else: ?>
            <div>
          <input
            <?php print isset($element['class']) ? 'class="' . $element['class'] . '" ' : '' ?>id="<?php print $element['id'] ?>"
            type="<?php print $element['input_type'] ?>" name="<?php print $element['name']; ?>"
            <?php isset($element['onFocus']) ? print "onFocus=".$element['onFocus'] : '' ?>
              <?php isset($element['onBlur']) ? print "onBlur=".$element['onBlur'] : '' ?>
            value="<?php print isset($element['value']) ? $element['value'] : '' ?>"/></div>
          <?php if (isset($element['title']) && ($element['input_type'] == 'radio' || $element['input_type'] == 'checkbox')): ?>
            <label for="<?php print $element['id'] ?>"><?php print $element['title'] ?></label>
          <?php endif; ?>
        <?php endif; ?>
      <?php endif; ?>
    </div>
  <?php endforeach; ?>
</form>