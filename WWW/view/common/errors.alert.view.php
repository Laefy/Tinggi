<?php if($data['error']) { ?>
  <div class="alert alert-warning"><strong>Erreur ! :'(</strong><ul><?php foreach ($datas['errors'] as $string) { '<li>'.$string.'</li>' } ?></ul></div>
<?php } ?>
