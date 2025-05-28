<html>
<head>
  <link rel="shortcut icon" href="favicon.png"/>
  <title>Time Complexity login</title>
  <link rel='stylesheet' href='styles.css' />
  <script src='jquery.js'></script>
  <script src='scripts.js'></script>
  <style type="text/css">
    body {
      background:black;
      color:white;
      font-size:x-large;
      font-weight:bold;
    }
  </style>
</head>
<body>
  <div id='loginDiv'>
    <?php
      require_once('Login.php');
      session_unset();
      $kicked = false;
      if (isset($_GET['kicked']) && $_GET['kicked']) {
        $kicked = true;
      }
      
      echo "<form method='post' action='challenge.php'>";
      Login::displayLogin($kicked);
    ?>
    </form>
  </div>
</body>
</html>
