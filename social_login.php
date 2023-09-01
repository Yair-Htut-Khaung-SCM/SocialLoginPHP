<?php

include 'ProviderEnum.php';

$selectedProvider = $_GET['provider']; // Get the selected provider from the query string

// Define the namespace and class name of your ProviderEnum class
$providerEnumClass = 'ProviderEnum';

// Construct the constant name for the selected provider's authorization URL
$authUrlConstant = $selectedProvider . '_AUTH_URL';
$authUrlClientConstant = $selectedProvider . '_CLIENT_ID';
$authUrlClientURLConstant = $selectedProvider . '_CALLBACK_URL';
$authUrlClientSCOPEConstant = $selectedProvider . '_SCOPE';


$authUrl = constant("$providerEnumClass::$authUrlConstant");
$authUrl .= "?response_type=code";
$authUrl .= "&client_id=" . constant("$providerEnumClass::$authUrlClientConstant");
$authUrl .= "&redirect_uri=" . constant("$providerEnumClass::$authUrlClientURLConstant");
$authUrl .= "&state=state";
$authUrl .= "&scope=" . constant("$providerEnumClass::$authUrlClientSCOPEConstant");
if($selectedProvider === ProviderEnum::TWITTER) {
    $authUrl .= "&code_challenge=challenge";
    $authUrl .= "&code_challenge_method=plain";
}

echo "<script>window.location.href = '$authUrl';</script>";

?>