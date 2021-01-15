<?php require_once 'functions/main.php' ?>
<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Gallery</title>
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="css/sing.css">
  <link rel="stylesheet" href="css/createSliders.css">
  <link rel="stylesheet" href="css/gallery.css">
  <link rel="stylesheet" 
        href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
        integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" 
        crossorigin="anonymous">
</head>

<body>
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="#">Menu</a>
    <button class="navbar-toggler" 
            type="button" 
            data-toggle="collapse" 
            data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" 
            aria-expanded="false" 
            aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" 
         id="navbarSupportedContent">

      <ul class="navbar-nav mr-auto">
        <?php
            $menu = require_once 'config/menu.php';
            foreach($menu as $p => $t):
        ?>
        <li class="nav-item <?= ($page==$p) ? 'active' : '' ?>">
          <a class="nav-link" href="index.php?page=<?= $p ?>"><?= $t ?></a>
        </li>
        <?php endforeach ?>
      </ul>

      <ul class="navbar-nav ml-auto">
        <?php if( isset($_SESSION['user']) ): ?>
        <li>
          <form method="POST" 
                action="index.php" 
                class="exit">
            <p>Hello, <?= $_SESSION['user'] ?>!</p>
            <button>Exit</button>
            <input type="hidden" 
                   name="action" 
                   value="exitUser">
          </form>
        </li>
        <?php else: ?>
        <li><a href="index.php?page=singin">Sing in</a></li>
        <li><a href="index.php?page=singup">Sing up</a></li>
        <?php endif ?>
      </ul>

    </div>
  </nav>

  <div class="container">
    <?php
          if( file_exists("pages/{$page}.php") ){
              require_once "pages/{$page}.php";
              unsetMessage();              
          }
          else{
              require_once "pages/404.php";
          }
        ?>
  </div>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"
          integrity="sha512-bLT0Qm9VnAYZDflyKcBaQ2gg0hSYNQrJ8RilYldYQ1FxQYoCLtUjuuRuZo+fjqhx/qtq/1itJ0C2ejDxltZVFg=="
          crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"
          integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" 
          crossorigin="anonymous">
  </script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"
          integrity="sha384-LtrjvnR4Twt/qOuYxE721u19sVFLVSA4hf/rRt6PrZTmiPltdZcI7q7PXQBYTKyf" 
          crossorigin="anonymous">
  </script>  
  <script src="js/script.js"></script>
  
</body>
</html>