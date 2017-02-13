![Sherlock](static/img/sherlock-logo.png)
# Sherlock: Browser Fingerprint-Based Authentication System

## Overview
Sherlock allows users to log in to websites without typing their passwords.

Sherlock utilizes the browser fingerprinting technique implemented by [fingerprintjs2](https://github.com/Valve/fingerprintjs2) to identify users' devices.

Sherlock's benefits have been tested and backed up by our [research](https://github.com/mjkim610/sherlock/blob/master/sherlock-paper.pdf).

## Features
- Secure and usable password-free authentication
- Provide the service provider control over levels of confidence for user authentication
- No setup requirements from users
- Allow user to register multiple device fingerprints for each account

## Demo
- Website - [https://www.try-sherlock.com/](https://www.try-sherlock.com/)
- Video - [YouTube Link](https://youtu.be/Aj9xxVyO2Y8)

## API Usage (PHP)
### Service Providers
1. Sign up as a service provider at [try-sherlock.com](https://try-sherlock.com/)
2. Log in at [try-sherlock.com](https://try-sherlock.com/) and register your website / web service at [https://try-sherlock.com/my/site](https://try-sherlock.com/my/site)
    - **URL**: Address of homepage
    - **Redirect URL**: Address of page to load upon successful login attempt
    - **Threshold 1**: Threshold value for allowing login without additional credentials
    - **Threshold 2**: Threshold value for allowing login with PIN
    - **Threshold values guide**: 0 < Threshold 2 < Threshold 1 <= 100
3. Save the generated `App ID` in a safe location
4. Save [sherlock_for_provider](https://github.com/mjkim610/sherlock/blob/master/static/js/sherlock_for_provider.js) in your website / web service
5. Download [sherlock.js](https://github.com/mjkim610/sherlock/blob/master/static/js/sherlock.js) into the web service directory and include the script in the header of the relevant pages (*PATH_TO_JS_FILE* must be specified)
    ```
    <script src="PATH_TO_JS_FILE"></script>
    ```
6. Add a "Login with Sherlock" button and create an onclick event (*APP_ID* must be specified)
    ```
    onclick="Sherlock_init(APP_ID)
    ```
7. On your webpage specified at **Redirect URL**, add the following code (*APP_ID* must be specified)
    ```
    $id_token = $_GET["id_token"];
    $state = $_GET["state"];

    $postdata = http_build_query(
        array(
            'id_token' => $id_token,
            'app_id' => APP_ID
        )
    );

    $opts = array(
        'http' => array(
            'method' => 'POST',
            'header' => 'Content-type: application/x-www-form-urlencoded',
            'content' => $postdata
        )
    );

    $context = stream_context_create($opts);
    $result = file_get_contents(site_url('get_user_profile'), false, $context);

    echo $result;

    ```
7. Setup is complete! A successful login will return user information as JSON in the form `{"email":"jhoney7374@gmail.com","code":"dkHHr1AsOYcUTTUvO2xe75rxWhsqSk"}`

### Users
1. Sign up as a user at [try-sherlock.com](https://try-sherlock.com/)
2. Register your fingerprints at [try-sherlock.com/my/fingerprint](https://try-sherlock.com/my/fingerprint)
3. Setup is complete! Log in without hassle in any of the Sherlock-supported websites / web services

## External Code
- fingerprintjs2 -  [https://github.com/Valve/fingerprintjs2](https://github.com/Valve/fingerprintjs2)
- password_compat - [https://github.com/ircmaxell/password_compat](https://github.com/ircmaxell/password_compat)
- sha256.js -  [https://code.google.com/archive/p/crypto-js/](https://code.google.com/archive/p/crypto-js/)
- Font Awesome -  [http://fontawesome.io/](http://fontawesome.io/)

## License
Sherlock is licensed under the 3-Clause BSD License.

```
Copyright (c) 2017 restforest, mjkim610, sullamij
All rights reserved.

Redistribution and use in source and binary forms, with or without
modification, are permitted provided that the following conditions are met:

* Redistributions of source code must retain the above copyright notice, this
  list of conditions and the following disclaimer.
* Redistributions in binary form must reproduce the above copyright notice,
  this list of conditions and the following disclaimer in the documentation
  and/or other materials provided with the distribution.
* Neither the name of the copyright holder nor the names of its contributors
  may be used to endorse or promote products derived from this software without
  specific prior written permission.

THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND
ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED
WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE
DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT HOLDER OR CONTRIBUTORS BE LIABLE FOR
ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES
(INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON
ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
(INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS
SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.

restforest
ChungHun, Kim
jhoney7374@gmail.com

mjkim610
Myung-jong, Kim
mjkim610@gmail.com

sullamij
Sullam, Jeoung
sullamij@naver.com

```
