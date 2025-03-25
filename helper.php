
<?php
function validateField($request, $key)
{
    return isset($request[$key]) && trim($request[$key]) != "" ? "" : "$key is required";
}

function validate($request, $keys)
{
    $result = [];
    foreach ($keys as $key) {
        $error = validateField($request, $key);
        if ($error != "") {
            $result[$key] = $error;
        }
    }
    return $result;
}
