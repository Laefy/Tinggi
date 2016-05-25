<div class="caption">
  <h3><?php echo $post->getTitle()?></h3>
  <?php
  switch ($post->getType()) {
    case 'IFRAME':
      echo 'No preview';//ToDo
      break;
    case 'PHOTO':
      //echo '<img src="',$post['src'],'" alt="',$post['alt'],'">';
      break;
    case 'EMBED':
      echo 'No preview';//ToDo
      break;
    default:
      echo '<p>',$post->getDesc(),'</p>';
      break;
  }
  ?>
</div>
