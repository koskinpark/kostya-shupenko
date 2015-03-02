<?php if (!empty($messages)): ?>
    <div >
      <ul>
        <?php foreach($messages as $message): ?>
             <li style="color: <?php print $message['status'] == 'error' ? 'red' : 'green' ?>"><?php print $message['data']; ?></li>
        <?php endforeach; ?>
      </ul>
    </div>
<?php endif; ?>