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

 ?>
