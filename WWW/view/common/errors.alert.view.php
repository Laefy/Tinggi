<?php if($data['error']) { ?>
  <div class="row">
    <div class="col-md-4 col-md-offset-4">
      <div class="alert alert-warning"><h5 class="text-center">Erreur</h5><ul><?php foreach ($data['errors'] as $string) { ?><li><?= $string ?></li><?php } ?></ul></div>
    </div>
  </div>
<?php } ?>
