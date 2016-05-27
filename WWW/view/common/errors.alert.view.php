<?php if($data['error']) { ?>
  <div class="col-md-6 col-md-offset-3">
    <div class="alert alert-warning"><h5 class="text-center">Erreur</h5><ul><?php foreach ($data['errors'] as $string) { ?><li><?= $string ?></li><?php } ?></ul></div>
  </div>
<?php } ?>
