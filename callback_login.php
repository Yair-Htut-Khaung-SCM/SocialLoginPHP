<?php

include 'ProviderEnum.php';
// Get the current URL including query parameters
$currentUrl = $_SERVER['REQUEST_URI'];

// Parse the URL to extract its components
$urlParts = parse_url($currentUrl);

// Extract the path component
$path = $urlParts['path'];

// Split the path into segments
$pathSegments = explode('/', $path);

// Find the index of "oauth"
$oauthIndex = array_search('oauth', $pathSegments);

// Extract the relevant segment
$selectedProvider = $pathSegments[$oauthIndex + 1];
$selectedProvider = strtoupper($selectedProvider);

if(empty($_GET['code'])) {
    echo "Something wrong in Access Profile process";
}

// Check if the uppercase value exists in ProviderEnum
if (defined("ProviderEnum::$selectedProvider")) {

    $providerEnumClass = 'ProviderEnum';
    $clientConstant = $selectedProvider . '_CLIENT_ID';
    $clientSecretConstant = $selectedProvider . '_CLIENT_SECRET';
    $clientCallBackConstant = $selectedProvider . '_CALLBACK_URL';
    $clientTokenUrlConstant = $selectedProvider . '_TOKEN_URL';
    $clientProfileUrlConstant = $selectedProvider . '_PROFILE_URL';


    $client_id =  constant("$providerEnumClass::$clientConstant");
    $client_secret = constant("$providerEnumClass::$clientSecretConstant");
    $redirectUri = constant("$providerEnumClass::$clientCallBackConstant");
    $access_token_url = constant("$providerEnumClass::$clientTokenUrlConstant");
    $access_profile_url = constant("$providerEnumClass::$clientProfileUrlConstant");
    $authorizationCode = $_GET['code']; 

    // Set up cURL to make the API request
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $access_token_url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array( 'Accept: application/json'));
    if(($selectedProvider === ProviderEnum::TWITTER)) {
        curl_setopt($ch, CURLOPT_HTTPHEADER, array( 'Authorization: Basic ' . base64_encode((ProviderEnum::TWITTER_CLIENT_ID . ':' . ProviderEnum::TWITTER_CLIENT_SECRET))));
    }
    
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
        'grant_type' => 'authorization_code',
        'code' => $authorizationCode,
        'redirect_uri' => $redirectUri,
        'client_id' => $client_id,
        'client_secret' => $client_secret,
        'code_verifier' => ($selectedProvider === ProviderEnum::TWITTER) ? 'challenge' : '',
    ]));

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    // Execute the cURL request
    $response = curl_exec($ch);

    // Check for errors and process the response
    if ($response === false) {
        echo 'cURL Error: ' . curl_error($ch);
    } else {

        $responseData = json_decode($response, true);
        $accessToken = $responseData['access_token']; // Extract the access token
    }
    // Close cURL
    curl_close($ch);

    // Set up cURL to make the API request
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $access_profile_url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Authorization: Bearer ' . $accessToken,
        (($selectedProvider === ProviderEnum::GITHUB) ?  'User-Agent:' . ProviderEnum::GITHUB_APP_NAME : ''),
    ]);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    // Execute the cURL request
    $response = curl_exec($ch);

    // Check for errors and process the response
    if ($response === false) {
        echo 'cURL Error: ' . curl_error($ch);
    } else {
        $userData = json_decode($response, true);

        //formatted userData because keys are different form social web
        switch ($selectedProvider) {
            case ProviderEnum::LINE :
                $provider_user_id = $userData['userId'];
                $provider_user_name = $userData['displayName'];
                $provider_user_picture = $userData['pictureUrl'];
                $provider_user_email = $userData['email'];
                break;
            case ProviderEnum::FACEBOOK:
                $provider_user_id = $userData['id'];
                $provider_user_name = $userData['name'];
                $provider_user_picture = $userData['picture']['data']['url'];
                $provider_user_email = $userData['email'];                            
                break;
            case ProviderEnum::GOOGLE:
                $provider_user_id = $userData['sub'];
                $provider_user_name = $userData['name'];
                $provider_user_picture = $userData['picture'];
                $provider_user_email = $userData['email'];
                break;
            case ProviderEnum::TWITTER:
                $provider_user_id = $userData['data']['id'];
                $provider_user_name = $userData['data']['name'];
                $provider_user_picture = $userData['data']['profile_image_url'];
                $provider_user_email = $userData['email'];
                break;
            case ProviderEnum::GITHUB:
                $provider_user_id = $userData['id'];
                $provider_user_name = $userData['login'];
                $provider_user_picture = $userData['avatar_url'];
                $provider_user_email = $userData['email'];
                break;
            default:
                // Handle unsupported provider
                break;
        }

        $userDataFormatted['provider_user_id'] = $provider_user_id;
        $userDataFormatted['provider_user_name'] = $provider_user_name;
        $userDataFormatted['provider_user_picture'] = $provider_user_picture;
        $userDataFormatted['provider_user_email'] = $provider_user_email;

        $userDataFormatted['providerName'] = strtolower($selectedProvider);
        $userDataFormatted['access_token'] = $accessToken;
        curl_close($ch);

        $encodedUserData = urlencode(json_encode($userDataFormatted));

        $host = $_SERVER['HTTP_HOST'];
        $userProfileUrl = "https://$_SERVER[HTTP_HOST]";
        $userProfileUrl.= "/" .$pathSegments[1]. "/";
        $userProfileUrl.= 'user_profile.php?data=' . $encodedUserData;
        
        header('Location: ' . $userProfileUrl);
        exit;
    }

} else {
    // The value does not exist in ProviderEnum
    echo "Callback Segment: $callbackSegment is not valid";
}



