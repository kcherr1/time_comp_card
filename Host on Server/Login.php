<?php
session_start();

class Login {
  // getters
  public static function getTeamName() {
    return $_SESSION['teamname'];
  }
  
  // other functions
  public static function isPostBack() {
    return isset($_POST['teamname']) && strcmp(trim($_POST['teamname']), '');
  }
  public static function isLoggedIn() {
    return isset($_SESSION['loggedin']);
  }
  public static function displayLogin($kicked) {
    echo "<div class='loginContainer'>";
    echo "  <div class='loginTeamNameContainer'>";
    echo "    <label for='teamname'>Team name: </label>";
    echo "    <input class='loginTeamNameInput' size='57' type='text' id='teamname' name='teamname'></input>";
    echo "  </div>";
        
    echo "  <input class='loginSubmitBtn' type='submit' value='Log in'></input>";
    echo "</div>";
  }
  public static function createSession() {
    $_SESSION['teamname'] = trim($_POST['teamname']);
    $_SESSION['loggedin'] = true;
  }
}

?>
