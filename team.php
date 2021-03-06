<?php 
  include 'header.php';

  class User
  {
    var $username;
    var $avatar;
  }
  
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_USERAGENT,'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');
  curl_setopt($ch, CURLOPT_URL, 'https://api.github.com/orgs/masenohub/public_members');
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
  
  $response = curl_exec($ch);
  curl_close($ch);
  $data = json_decode($response, true);

  $users = array();
  foreach ($data as $i => $value) {
    $user = new User();
    $user->username = $value["login"];
    $user->avatar = $value["avatar_url"];
    array_push($users, $user);
  }
?>
  <div id="wrap">
    <div id="showcase">
    <?php foreach ($users as $u): ?>
    <a href="https://github.com/<?= $u->username; ?>">
      <img  src="<?= $u->avatar; ?>" alt="<?= $u->username; ?>" class="cloud9-item img-circle" style="width:250px;">
      </a>
    <?php endforeach; ?>
    </div>

    <p id="item-title">&nbsp;</p>

    <div class="nav noselect">
      <button class="left"><i class="fa fa-arrow-left"></i></button>
      <button class="right"><i class="fa fa-arrow-right"></i></button>
    </div>

  </div>

  <script type="text/javascript">

  $(function() {
    var showcase = $("#showcase")

    showcase.Cloud9Carousel( {
      yPos: 42,
      yRadius: 48,
      mirrorOptions: {
        gap: 12,
        height: 0.2
      },
      buttonLeft: $(".nav > .left"),
      buttonRight: $(".nav > .right"),
      autoPlay: true,
      bringToFront: true,

      onRendered: showcaseUpdated,
      onLoaded: function() {
        showcase.css( 'visibility', 'visible' )
        showcase.css( 'display', 'none')
        showcase.fadeIn( 1500 )
      }
    })

    function showcaseUpdated( showcase ) {
      var title = $("#item-title").html(
        $(showcase.nearestItem()).attr( 'alt' )
      )

      var c = Math.cos((showcase.floatIndex() % 1) * 2 * Math.PI)
      title.css('opacity', 0.5 + (0.5 * c))
    }

    $('.nav > button').click( function( e ) {
      var b = $(e.target).addClass( 'down' )
      setTimeout( function() { b.removeClass( 'down' ) }, 80)
    } )

    $(document).keydown( function( e ) {
      switch( e.keyCode ) {
        case 37:
        $('.nav > .left').click()
        break

        case 39:
        $('.nav > .right').click()
      }
    })
  })

  </script>
</body>
</html>
