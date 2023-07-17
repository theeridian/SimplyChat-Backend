<?
function respond_error($code = 400, $error) {
    header_remove();
    http_response_code($code);
    header('Content-Type: application/json');
    return json_encode(array(
        'success' => $code < 300, // success or not?
        'data' => $error
    ));
}

function respond_ok_no_data($code = 200) {
    header_remove();
    http_response_code($code);
    header('Content-Type: application/json');
    return json_encode(array(
        'success' => $code < 300, // success or not?
        'data' => array()
    ));
}

function respond_ok_data($code = 200, $data) {
    header_remove();
    http_response_code($code);
    header('Content-Type: application/json');
    return json_encode(array(
        'success' => $code < 300, // success or not?
        'data' => $data
    ));
}

function respond_ok($code = 200, $data) {
    if (isset($data)) {
        respond_ok_data($code, $data);
    } else {
        respond_ok_no_data($code);
    }
}
?>