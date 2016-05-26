<header>
 <img src="data/img/crosse.png" alt="croix" id="crosse"></img>
 <div class="container">
   <div class="row">
     <div class="col-lg-12">
       <div class="intro-text">
         <span class="name">MATCH UP</span>
         <span class="desc">VS</span>
       </div>
     </div>
   </div>
 </div>
</header>
<section id="view" class="container-fluid">
  <div class="row">
  <div class="col-xs-10 col-xs-offset-1">
    <div class="col-md-6">
    <a href="#" class="thumbnail">
      <!--<img src="..." alt="...">-->
      <div class="class_match">
        <?php
          $post = $data['post1'];
          include 'view/match.post.view.php';
        ?>
        <div class="like_match">
          <img src="data/img/jaime_blanc.png" class="img_sup"></img>
        </div>
      <p>description</p>
      </div>
    </a>
    </div>
    <div class="col-md-6">
    <a href="#" class="thumbnail">
      <!--<img src="..." alt="...">-->
      <div class="class_match">
        <?php
          $post = $data['post2'];
          include 'view/match.post.view.php';
        ?>
        <div class="like_match">
          <img src="data/img/jaime_blanc.png" class="img_sup"></img>
        </div>
      </div>
      <p>description</p>
    </a>
    </div>
  </div>
  </div>
</section>


<!-- jQuery -->
<script src="js/jquery.js"></script>

<!-- Bootstrap Core JavaScript -->
<script src="js/bootstrap.min.js"></script>

<!-- Plugin JavaScript -->
<script src="http://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js"></script>
<script src="js/classie.js"></script>
<script src="js/cbpAnimatedHeader.js"></script>

<!-- Contact Form JavaScript -->
<script src="js/jqBootstrapValidation.js"></script>
<script src="js/contact_me.js"></script>

<!-- Custom Theme JavaScript -->
<script src="js/freelancer.js"></script>
