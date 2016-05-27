<div class="caption">
  <h3><?=$post->getTitle()?></h3>
  <?php
    \controller\PostController::makeBaliseFromDesc($post->getDesc());
  ?>
</div>
