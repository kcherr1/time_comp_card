<?php
require_once('Login.php');

if (!Login::isLoggedIn()) {
  if (Login::isPostBack()) {
    Login::createSession();
  }
}
?>

<html>
<head>
  <title>Time Complexity challenge</title>
  <link rel='stylesheet' href='styles.css' />
  <script src='jquery.js'></script>
  <script src='scripts.js'></script>
  <style type="text/css">
    body {
      background:black;
      color:white;
    }
    .confetti{
        display: block;
        margin: 0 auto;
        border: 1px solid #ddd;
        user-select: none;
        position:absolute !important;
        width:99% !important;
        height:99% !important;
        top: 0;
        left: 0;
    }    
  </style>
</head>
<body>
<?php
  define('MAX_SECTIONS', 1);
  
  function getColorStyle() {
    return "style='color:#fff'};";
  }
  function getNumCorrect() {
    $parts = array('a', 'b', 'c', 'd', 'e');
    
    $actual = array();
    for($i = 1; $i <= MAX_SECTIONS; $i++) {
      foreach($parts as $part) {
        $name = "{$i}_$part";
        if (isset($_POST[$name])) {
          $actual["$i:$part"] = $_POST[$name];
        }
      }
    }
    
    $expected = array(
      '1:a'=>'n',
      '1:b'=>'n^2',
      '1:c'=>'log2 n',
      '1:d'=>'n',
      '1:e'=>'n log3 n', 
    );
    
    $numCorrect = 0;
    foreach($expected as $key => $value) {
      if ($actual[$key] == $expected[$key]) {
        $numCorrect++;
      }
    }
    
    return $numCorrect;
  }
  function drawChoices($setNum, $partNum) {
    $colorStyle = getColorStyle();
    $name = "{$setNum}_$partNum";
    echo "<select id='$name' class='select' $colorStyle name='$name'>\n";
    $choices = getChoices();
    $alreadySelected = null;
    if (isset($_POST[$name]))
      $alreadySelected = $_POST[$name];
    echo "<option value='empty'> </option>\n";
    foreach($choices as $choice) {
      if ($alreadySelected != null && !strcmp($alreadySelected, $choice))
        echo "<option value='$choice' selected='selected'>O($choice)</option>\n";
      else
        echo "<option value='$choice'>O($choice)</option>\n";
    }
    echo "</select>";
  }
  function getChoices() {
    return array(
      '1',
      'log5 n', 'log4 n', 'log3 n', 'log2 n',
      'n',   'n log5 n',   'n log4 n',   'n log3 n',   'n log2 n',
      'n^2', 'n^2 log5 n', 'n^2 log4 n', 'n^2 log3 n', 'n^2 log2 n',
      'n^3', 'n^3 log5 n', 'n^3 log4 n', 'n^3 log3 n', 'n^3 log2 n',
      'n^4', 'n^4 log5 n', 'n^4 log4 n', 'n^4 log3 n', 'n^4 log2 n',
      'n^5', 'n^5 log5 n', 'n^5 log4 n', 'n^5 log3 n', 'n^5 log2 n',
      '2^n', '3^n', '4^n', '5^n'
    );
  }
  function drawSections() {
    $colorStyle = getColorStyle();
    $parts = array('a', 'b', 'c', 'd', 'e');
    $secNames = array('', 'Loops');
    
    for($i = 1; $i <= MAX_SECTIONS; $i++) {
      echo "<div class='section shadow' $colorStyle>";
      echo "  <div class='header'>GROUP $i</div>\n";
      echo "  <div class='secName'>{$secNames[$i]}</div>\n";
      foreach($parts as $part) {
        echo "<span class='part'>$part)</span> \n";
        drawChoices($i, $part);
        echo "<br />\n";
      }
      echo "</div>\n";
    }
    echo "<div style='clear:both'></div>\n";
  }
  function isPostback() {
    return !strcmp(basename($_SERVER['HTTP_REFERER']), basename($_SERVER['SCRIPT_NAME']));
  }
  
  function start() {
    echo "<form action='challenge.php' method='POST'>\n";
    drawSections();
    echo "<div style='float:left'>";
    echo "<input id='submit' type='submit' class='submit' onclick='submitLoading()' value='Submit' />\n";
    echo "<input id='submitting' type='button' class='submit submitting' value='' />\n";
    echo "</form>";
    
    if (isPostback()) {      
      $delay = 0;
      $nextDelay = 2;
      $MAX_DELAY = 99;
      $filename = 'delay/' . Login::getTeamName() . '.txt';
      if (file_exists($filename)) {
        $file = fopen($filename, "r");
        $filenum = (int)fread($file,2);
        
        $delay = $filenum;
        if ($filenum < 7) {
          $filenum += 2;
        }
        else if ($filenum < 20) {
          $filenum += 4;
        }
        else if ($filenum < $MAX_DELAY - 10) {
          $filenum += 8;
        }
        else {
          $filenum = $MAX_DELAY;
        }
        $nextDelay = $filenum;
        fclose($file);
        
        $file = fopen($filename, "w");
        fwrite($file, "$filenum");
        fclose($file);
      }
      else {
        $file = fopen($filename, "w");
        fwrite($file, $nextDelay);
        fclose($file);
      }
      
      if ($delay > $MAX_DELAY) {
        $delay = $MAX_DELAY;
        $nextDelay = $MAX_DELAY;
      }
      
      sleep($delay);
      $numCorrect = getNumCorrect();
      echo "<h1>You got <span class='numCorrect'>$numCorrect correct</span> and ";
      echo "<span class='numIncorrect'>" . (5 - $numCorrect) . " incorrect</span></h1>";
      if ($numCorrect < 5) {
        $secondOrSeconds = ($nextDelay == 1 ? 'second' : 'seconds');
        echo "<h3>* Next delay will be <span class='nextDelay'><span id='nextDelay'>$nextDelay</span> $secondOrSeconds</span></h3>\n";
        echo "<h5>** Do NOT refresh page. Refreshing the page will increase the server delay!</h5>\n";
      }
    }
    echo "</div>";
    echo "<div style='clear:both'></div>";
  }
  
  start();
?>
</body>
</html>
