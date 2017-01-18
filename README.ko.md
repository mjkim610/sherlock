![Sherlock](static/img/sherlock-logo.png)
# Sherlock: Browser Fingerprint-Based Authentication System

## Overview
Sherlock은 비밀번호 없이 로그인 가능합니다.

Sherlock은 27 개의 Browser Fingerprint 조합으로 인증하는 방식입니다.
참조 : [fingerprintjs2](https://github.com/Valve/fingerprintjs2)

Sherlock의 신뢰성은 여러 시험들을 거쳐 인증되었습니다.

## Features
- 비밀번호 없이 보안성 (Security) 와 사용성 (Usability)를 동시에 만족
- 서비스 제공자가 인증에 대한 수위를 조절 가능
- 사용자 별도의 설치가 필요 없는 편리함
- 사용자가 하나의 계정에 여러개의 기기를 등록 할 수 있음

## Demo
- Website - [http://www.try-sherlock.com/](http://www.try-sherlock.com/)
- Video - [YouTube Link](https://youtu.be/Aj9xxVyO2Y8)

## API Usage
1. 'try.sherlock@gmail.com’으로 email을 통해 App Key 발급받는다.
2. [sherlock.js](https://github.com/mjkim610/sherlock/blob/master/static/js/sherlock.js) 를 다운 받는다.
3. Signup elements 들과 JavaScript code를 signup page 에 첨부한다.

    - HTML
        - HTML code may be edited, but the Sherlock API accesses the signup information using the `id`
        ```
        <div class="form-group form-sherlock-email">
            <label for="sherlock_email">Email:</label>
            <input type="email" class="form-control" id="sherlock_email" name="email" placeholder="Email" value="email@email.email">
        </div>
        <div class="form-group form-sherlock-password">
            <label for="sherlock_password">Password:</label>
            <input type="password" class="form-control" id="sherlock_password" name="password" placeholder="Password">
        </div>
        <div class="form-group form-sherlock-pin">
            <label for="sherlock_pin">Pin:</label>
            <input type="password" class="form-control" id="sherlock_pin" name="pin" placeholder="PIN">
        </div>
        <button type="button" class="btn btn-default pull-right" id="wow" onclick="sherlock_signup()">Click</button>
        ```
    - JavaScript
        - replace `'QWERTY'` with the app key
        - on successful sign up, `sherlock.SignUp()` will return `true`
        ```
        <script type="text/javascript">
        function sherlock_signup() {
            sherlock.SignUp('QWERTY');
        };
        </script>
        ```

4. login element 들과 JavaScript code 를 login page 에 첨부한다
    - HTML
        - HTML code may be edited, but the Sherlock API accesses the signup information using the `id`
        ```
        <div class="form-group form-sherlock-email">
            <label for="sherlock_email">Email:</label>
            <input type="email" class="form-control" id="sherlock_email" name="email" placeholder="Email" value="email@email.email">
        </div>
        <div class="form-group form-sherlock-password" style="display:none;" >
            <label for="sherlock_password">Password:</label>
            <input type="password" class="form-control" id="sherlock_password" name="password" placeholder="Password">
        </div>
        <div class="form-group form-sherlock-pin" style="display:none;" >
            <label for="sherlock_pin">Pin:</label>
            <input type="password" class="form-control" id="sherlock_pin" name="pin" placeholder="PIN">
        </div>
        <button type="button" class="btn btn-default pull-right" id="wow" onclick="sherlock_login()">Click</button>
         ```
    - JavaScript
        - replace `'QWERTY'` with the app key
        - `sherlock.LogIn()` will check the threshold value and authenticate user or ask for additional credentials
        ```
        <script type="text/javascript">
        function sherlock_login() {
            sherlock.LogIn('QWERTY');
        };
        </script>
        ```

5. Test를 위해서는 [http://try-sherlock.com:8080/](http://try-sherlock.com:8080/)

## External Code
- fingerprintjs2 -  [https://github.com/Valve/fingerprintjs2](https://github.com/Valve/fingerprintjs2)
- sha256.js -  [https://code.google.com/archive/p/crypto-js/](https://code.google.com/archive/p/crypto-js/)
- Font Awesome -  [http://fontawesome.io/](http://fontawesome.io/)

## Authors
- ![sullamij](static/img/team/1-small.jpg) sullamij
- ![jhoney](static/img/team/2-small.jpg) jhoney
- ![mjkim](static/img/team/3-small.jpg) mjkim

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
