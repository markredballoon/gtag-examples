<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>GTAG Examples</title>
  <link rel="stylesheet" href="./default.css">
  <style>
    .wrap{
      width: 100%;
      max-width: 31rem;
      padding: 0 0.5rem;
      margin: auto;
    }
    h1{
      margin: 1rem 0 2rem;
      font-size: 1.8rem;
      text-align: center;
    }
    li{
      margin-bottom: 0.4rem;
    }
    li:first-letter{
      text-transform: uppercase;
    }
    @media screen and (max-width: 31rem){
      h1{
        font-size: 1.2rem;
      }
    }
  </style>
</head>

<body>
  <div class="wrap">
    <h1>GTAG Examples</h1>
    <nav>
      <ul>
        <?php 
          $current_dir = getcwd();
          $files = scandir($current_dir);
          foreach($files as $file){
            if (strpos($file, '.php') !== false && strpos($file,'index.php') === false){
              ?>
              <li><a target="_blank" href="./<?=$file;?>"><?= rtrim($file, '.php');?></a></li>
              <?php
            }
          }
        ?>
      </ul>
    </nav>
    <p>All these examples of how to use google analytics to track metrics on a page.</p>
    <p>The javascript used in these examples have no dependancies and use ES6 syntax. They are only tested to work on the latest browsers and use features such as passive event listeners and the fetch api.</p>
  </div>

</body>

</html>