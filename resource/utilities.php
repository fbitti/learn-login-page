<?php
/**
 * @param $required_fields_array, an array containing the list of all required fields
 * @return array, containing all errors
 */

function check_empty_fields($required_fields_array) {
  // initialize an arrary to store error messages
  $form_errors = array();

  // loop through the required fields array and populate the form error array
  foreach ($required_fields_array as $name_of_field) {
    if (!isset($_POST[$name_of_field]) || $_POST[$name_of_field] == NULL) {
      $form_errors[] = $name_of_field . " is a required field.";
    }
  }
  return $form_errors;
}

/**
 * @param $fields_to_check_length, an array containing the name of fields
 * for which we want to check min required length e.g array('username' => 4, 'email' => 12)
 * @return array, containing all errors
 */
function check_min_length($fields_to_check_length) {
  // initialize an array to store error messages
  $form_errors = array();
  foreach ($fields_to_check_length as $name_of_field => $minimum_length_required) {
    if (strlen(trim($_POST[$name_of_field])) < $minimum_length_required) {
      $form_errors[] = $name_of_field . " is too short, must be {$minimum_length_required} characters long.";
    }
  }
  return $form_errors;
}

/**
 * @param $data, store a key/value pair array where key is the name of the form control
 * in this case 'email' and the value is the input entered by the user
 * @return array, containing email error
 */
function check_email($data) {
  // initialize an array to store error messages
  $form_errors = array();
  $key = 'email';

  // check if the key email exist in the data array
  if (array_key_exists($key, $data)) {
    if ($_POST[$key] != NULL) {
      $key = filter_var($key, FILTER_SANITIZE_EMAIL);

      // check if the input is a valid email address
      if (filter_var($_POST[$key], FILTER_VALIDATE_EMAIL) === false) {
        $form_errors[] = $key . " is not a valid email address";
      }
    }
  }
  return $form_errors;
}

/**
 * @param $form_errors_array, the array holding all
 * errors which we want to loop through
 * @return string, list containing all error messages
 */
function show_errors($form_errors_array) {
  $errors = "<p><ul style='color: red;'>";

  // loop through error array and display all items in a list
  foreach($form_errors_array as $the_error) {
    $errors .= "<li> {$the_error} </li>";
  }
  $errors .= "</ul></p>";
  return $errors;
}

function statusMessage($message, $fail = true) {
  if (!$fail) {
    $msg = "<div class='alert alert-success'>{$message}</div>";
  } else { // $fail
    $msg = "<div class='alert alert-danger'>{$message}";
    // the </div> will only be closed after all the errors are listed
  } // end if ($fail)

  return $msg;
}

function redirectTo($page) {
  header("location: {$page}.php");
}

function checkDuplicateEntries($db, $table, $column_name, $value) {
  try {
    $sqlQuery = "SELECT * FROM " . $table . " WHERE " . $column_name . " = :value";
    $sqlStatement = $db->prepare($sqlQuery);
    $sqlStatement->execute(array(':value' => $value));

    if ($row = $sqlStatement->fetch()) {
      return true;
    }
    return false;

  } catch (PDOException $exception) {
    // handle exception
  }
}

/**
 * @param $user_id
 */
function rememberMe($user_id) {
  if (isset($_SERVER['COOKIE_SECRET_KEY'])) {
      $cookieSecretKey = $_SERVER['COOKIE_SECRET_KEY'];
  } else {
      $cookieSecretKey = "change me";
  }
  var_dump($cookieSecretKey); //debug
  $encryptedCookieData = base64_encode($cookieSecretKey . $user_id);
  // Set Cookie to expire in approximately 30 days
  setcookie("rememberMeCookie", $encryptedCookieData, time() + 3600*24*30, "/");
}


/**
 * check if the cookie used is valid
 * @param $db, database connection link
 * @return bool, true if the user's cookie is valid
 */
function isCookieValid($db) {
  $isValid = false;

  if (isset($_COOKIE['rememberMeCookie'])) {
    // Decode the cookies and extract the user ID
    $decryptedCookieData = base64_decode($_COOKIE['rememberMeCookie']);
    if (isset($_SERVER['COOKIE_SECRET_KEY'])) {
        $cookieSecretKey = $_SERVER['COOKIE_SECRET_KEY'];
    } else {
        $cookieSecretKey = "change me";
    }
    $user_id = explode($cookieSecretKey, $decryptedCookieData);
    $user_id = $user_id[1];

    // check whether the retrieved user's id exists in the database
    $sqlQuery = "SELECT * FROM users WHERE id = :id";
    $sqlStatement = $db->prepare($sqlQuery);
    $sqlStatement->execute(array(':id' => $user_id));

    $row = $sqlStatement->fetch();
    if ($row) {
      $id = $row['id'];
      $username = $row['username'];

      // create the user session variable
      $_SESSION['id'] = $id;
      $_SESSION['username'] = $username;
      $isValid = true;
    } else { // ! $row
      // cookie ID is invalid, destroy the session and log the user out
      $isValid = false;
      $this->signout();
    } // end if ($row)
  } // end if isset($_COOKIE['rememberMeCookie'])
  return $isValid;
}

function signout() {
  unset($_SESSION['username']);
  unset($_SESSION['id']);

  if (isset($_COOKIE['rememberMeCookie'])) {
    unset($_COOKIE['rememberMeCookie']);
    setcookie('rememberMeCookie', null, -1, '/');
  }
  session_destroy();
  session_regenerate_id(true); // prevent session cookie hijacking
  redirectTo('index');
}

function guard() {
  $isValid = true;
  $inactivity_seconds = 60 * 2;
  $user_fingerprint = md5($_SERVER['REMOTE_ADDR'] . $_SERVER['HTTP_USER_AGENT']);

  if (isset($_SESSION['fingerprint']) && $_SESSION['fingerprint'] != $fingerprint) {
    $isValid = false;
    signout();
  } else if (isset($_SESSION['last_active']) && (time() - $_SESSION['last_active']) > $inactivity_seconds) {
    $isValid = false;
    signout();
  } else {
    $_SESSION['last_active'] = time();
  }

  return $isValid;

}

?>
