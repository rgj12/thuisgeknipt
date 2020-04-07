<?php
function redirect($page = false, $message = null, $message_type = null)
{
    if (is_string($page)) {
        $location = $page;
    } else {
        $location = $_SERVER['SCRIPT_NAME'];
    }

    if ($message != null) {
        $_SESSION['message'] = $message;
    }

    if ($message_type != null) {
        $_SESSION['message_type'] = $message_type;
    }
    header("location:" . $location);
}

function displayMessage()
{
    if (!empty($_SESSION['message'])) {
        $message = $_SESSION['message'];

        if (!empty($_SESSION['message_type'])) {
            $message_type = $_SESSION['message_type'];

            if ($message_type == 'error') {
                echo '<div class="alert alert-danger alert-dismissible fade show text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button> ' . $message . '</div>';
            } else {
                echo '<div class="alert alert-success  alert-dismissible fade show text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>' . $message . '</div>';
            }
        }
        unset($_SESSION['message']);
        unset($_SESSION['message_type']);
    } else {
        echo '';
    }
}

function checkId($id)
{
    if (!is_numeric($id)) {
        return false;
    } else {
        return true;
    }
}

function encryptId($id)
{
    $encryptedID = (($id * 123456789 * 5678) / 956783);
    return urlencode(base64_encode($encryptedID));
}

function decryptId()
{
    foreach ($_GET as $key => $data) {
        $data = $_GET[$key] = base64_decode(urldecode($data));
        $decryptedId = ((($data * 956783) / 5678) / 123456789);
        return round($decryptedId);

    }
}

function getToken($length)
{
    $token = "";
    $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    $codeAlphabet .= "abcdefghijklmnopqrstuvwxyz";
    $codeAlphabet .= "0123456789";
    $max = strlen($codeAlphabet);

    for ($i = 0; $i < $length; $i++) {
        $token .= $codeAlphabet[random_int(0, $max - 1)];
    }

    return $token;
}