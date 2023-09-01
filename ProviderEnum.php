<?php

class ProviderEnum {

    const TWITTER = 'TWITTER';
    const FACEBOOK = 'FACEBOOK';
    const LINE = 'LINE';
    const GOOGLE = 'GOOGLE';
    const GITHUB = 'GITHUB';

    const TWITTER_CLIENT_ID = 'ajNDTmxlZGZ2akhaZ0tOQXB3WWI6MTpjaQ';
    const TWITTER_CLIENT_SECRET = 'rd93twNZM38QiCBB_BgbiCTwLUTwIUrqk2akAQw0kgDUDyrnaS';
    const TWITTER_CALLBACK_URL = 'https://7c1d-150-249-249-184.ngrok-free.app/socialphp/callback_login.php/oauth/twitter/callback';
    const TWITTER_AUTH_URL = 'https://twitter.com/i/oauth2/authorize';
    const TWITTER_TOKEN_URL = 'https://api.twitter.com/2/oauth2/token';
    const TWITTER_PROFILE_URL = 'https://api.twitter.com/2/users/me?user.fields=profile_image_url';
    const TWITTER_SCOPE = 'tweet.read users.read offline.access';

    const FACEBOOK_CLIENT_ID = '955623542197717';
    const FACEBOOK_CLIENT_SECRET = 'd2568d16cdb6cc8546df144670c12f55';
    const FACEBOOK_CALLBACK_URL = 'https://7c1d-150-249-249-184.ngrok-free.app/socialphp/callback_login.php/oauth/facebook/callback';
    const FACEBOOK_AUTH_URL = 'https://www.facebook.com/v3.3/dialog/oauth';
    const FACEBOOK_TOKEN_URL = 'https://graph.facebook.com/v12.0/oauth/access_token';
    const FACEBOOK_PROFILE_URL = 'https://graph.facebook.com/me?fields=name,picture,email';
    const FACEBOOK_SCOPE = 'email';

    const LINE_CLIENT_ID = '2000573852';
    const LINE_CLIENT_SECRET = 'ffe11db03cd6db927d0a7c8b5e4b8c3c';
    const LINE_CALLBACK_URL = 'https://7c1d-150-249-249-184.ngrok-free.app/socialphp/callback_login.php/oauth/line/callback';
    const LINE_AUTH_URL = 'https://access.line.me/oauth2/v2.1/authorize';
    const LINE_TOKEN_URL = 'https://api.line.me/oauth2/v2.1/token';
    const LINE_PROFILE_URL = 'https://api.line.me/v2/profile';
    const LINE_SCOPE = 'profile openid email';

    const GOOGLE_CLIENT_ID = '154610384433-a4u21376lmoc6a8s2b0ftqakcde4ube8.apps.googleusercontent.com';
    const GOOGLE_CLIENT_SECRET = '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';
    const GOOGLE_CALLBACK_URL = 'https://7c1d-150-249-249-184.ngrok-free.app/socialphp/callback_login.php/oauth/google/callback';
    const GOOGLE_AUTH_URL = 'https://accounts.google.com/o/oauth2/v2/auth';
    const GOOGLE_TOKEN_URL = 'https://oauth2.googleapis.com/token';
    const GOOGLE_PROFILE_URL = 'https://www.googleapis.com/oauth2/v3/userinfo';
    const GOOGLE_SCOPE = 'openid profile email';

    const GITHUB_CLIENT_ID = '40e193f007c4cfc9497e';
    const GITHUB_CLIENT_SECRET = '553b948f72dd26e0b0aa46a03c190dc3d479e905';
    const GITHUB_CALLBACK_URL = 'https://7c1d-150-249-249-184.ngrok-free.app/socialphp/callback_login.php/oauth/github/callback';
    const GITHUB_AUTH_URL = 'https://github.com/login/oauth/authorize';
    const GITHUB_TOKEN_URL = 'https://github.com/login/oauth/access_token';
    const GITHUB_PROFILE_URL = 'https://api.github.com/user';
    const GITHUB_SCOPE = 'email';
    const GITHUB_APP_NAME = 'SocialLoginPHP'; //set the Application name


    const GRANT_TYPE = 'authorization_code';
    const CODE_VERIFIER = 'challenge';
    
}
?>
