<div class="caption">
  <h2><?=$post->getTitle()?></h2>
  <?php
    \controller\PostController::makeBaliseFromDesc($post->getDesc());
  ?>
</div>
