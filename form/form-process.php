<?php
include __DIR__.'/../bootstrap.php';
use GuzzleHttp\Client;
function sanitizeForm($inputs){
    $inputs['name'] = (isset($inputs['name'])) ? filter_var($inputs['name'], FILTER_SANITIZE_STRING) : null;
    $inputs['company'] = (isset($inputs['company'])) ? filter_var($inputs['company'], FILTER_SANITIZE_STRING) : null;
    $inputs['email'] = (isset($inputs['email'])) ? filter_var($inputs['email'], FILTER_VALIDATE_EMAIL) : null;
    $inputs['message']  = (isset($inputs['message'])) ? filter_var($inputs['message'], FILTER_SANITIZE_STRING) : null;
    $inputs['phone'] = (isset($inputs['phone'])) ? filter_var($inputs['phone'], FILTER_SANITIZE_NUMBER_INT) : null;
    $inputs['accept'] = (isset($inputs['accept'])) ? (bool) filter_var($inputs['accept'], FILTER_SANITIZE_NUMBER_INT) : false;

    return $inputs;
}

function isFormValid($inputs, &$errorFields = []){
    $requiredFields = [
        'name' => 'Name field is required!',
        'message' => "Message is required!",
        'email' => "Email is required!",
        'accept' => "Please accept the terms!",
        'g-recaptcha-response' => "Captcha key not found. Reload the page and try to submit the form again."
    ];

    $errorFields = [];
    foreach ($requiredFields as $fieldName => $fieldMessage) {
        if (!isset($inputs[$fieldName]) || !$inputs[$fieldName]) {
            $errorFields[$fieldName] = $fieldMessage;
        }
        if($fieldName=="email" && isset($inputs['email'])){
            if (!filter_var($inputs['email'], FILTER_VALIDATE_EMAIL)) {
                $errorFields[$fieldName] = "Adresse e-mail invalide";
            }
        }
    }

    return (!count($errorFields));
}

function isCaptchaValid($captcha, $secretKey){
    //$secretKey = "6LeVpD8aAAAAAD8Q8-MwoXm808c9njsDDWSSNt41";
    $data = [
        'secret' => $secretKey,
        'response' => $captcha
    ];

    $data = http_build_query($data);
    $client = new Client([
        'headers' => ['Content-Type' => 'application/x-www-form-urlencoded\r\n'],
        'verify' => false,
    ]);

    $feedback = $client->post(
        'https://www.google.com/recaptcha/api/siteverify',
        [ 'body' => $data ]
    );
    $feedback = json_decode($feedback->getBody(),true);
    return $feedback["success"];
}
function sendEmail($message, $to){
    $headers = ["MIME-Version: 1.0"];
    $headers[] = "Content-type:text/html;charset=UTF-8";
    $headers[] = "From: <noreply@yoursite.com>";

    $subject = "Contact Form";

    $headers = join("\r\n", $headers);
    return mail($to, $subject, $message, $headers);
}

if(!isset($_POST)){
    die();
}

$inputs = $_POST;
$inputs = sanitizeForm($inputs);
$errorFields = [];
if(isFormValid($inputs, $errorFields)
    && isCaptchaValid($_POST['g-recaptcha-response'], $config['captcha_secret'])
){
    $message = [];
    if( $inputs['company']) $message[] = "company : {$inputs['company']}";
    if( $inputs['name']) $message[] = "name : {$inputs['name']}";
    if( $inputs['email']) $message[] = "Email : {$inputs['email']}";
    if( $inputs['message']) $message[] = "Message : {$inputs['message']}";
    if( $inputs['phone']) $message[] = "phone : {$inputs['phone']}";
    $result = sendEmail(join("<br \>", $message), $config['default_email_receiver']);
    header('Content-Type: application/json');
    echo json_encode([
        'success' => (bool) $result
    ]);
}else{
    header('Content-Type: application/json');
    //if $errorFields is empty, we can assume captch is invalid
    echo json_encode([
        'error' => $errorFields,
        'message' => "The captcha is not valid, please try again."
    ]);
}
die();