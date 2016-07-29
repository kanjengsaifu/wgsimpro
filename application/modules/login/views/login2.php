<!DOCTYPE html>
<html >
<head>
  <meta charset="UTF-8">
  <title>SimproWeb | Wika Gedung</title>
  <script src="<?=base_url()?>assets/login/js/modernizr.js" type="text/javascript"></script>

  <link href='http://fonts.googleapis.com/css?family=Raleway:300,200' rel='stylesheet' type='text/css'>

  <link rel="stylesheet" href="<?=base_url()?>assets/login/css/reset.css">
  <link rel="stylesheet" href="<?=base_url()?>assets/login/css/style.css">

</head>

<body>


  <!--button id="findpass">What's the password?</button-->
  <form class="form-horizontal" method="post" action="<?=base_url()?>index.php/login/do">
  <div class="form">
    <div class="forceColor"></div>
    <div class="topbar">
      <div class="spanColor"></div>
      <input type="text" class="input" id="username" name="username" placeholder="Username"/>
      <input type="password" class="input" id="password" name="password" placeholder="Password"/>
    </div>
    <button class="submit" id="submit" >Login</button>
  </div>
  </form>
  <article class="article">
    <h1>This is an article</h1>

  </article>
  <script src='<?=base_url()?>assets/login/js/jquery.min.js'></script>

  <script src="<?=base_url()?>assets/login/js/index.js"></script>




</body>
</html>
