<?php

function cleanArrayData($array=[]) {
    $result = array();
    foreach ($array as $key => $value) {
        $cleaned = trim($value);
        $cleaned = stripslashes($cleaned);
        $result[$key] = $cleaned;
    }
    return $result;
}

function getValue($values, $key) {
    if (array_key_exists($key, $values)) { // array_key_exists() expects parameter 2 to be array, string given
        return htmlspecialchars($values[$key]);
    } else {
        return null;
    }
}

?>