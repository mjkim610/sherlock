![Sherlock](img/sherlock-logo.png)
# Sherlock: Browser Fingerprint-Based Authentication System

## Overview
Sherlock allows users to log in to websites without typing their passwords.

Sherlock utilizes the browser fingerprinting technique implemented by [fingerprintjs2](https://github.com/Valve/fingerprintjs2) to identify users' devices.

Sherlock's benefits have been tested and backed up by our research.

## Features
- Secure and usable password-free authentication
- Provide the service provider control over levels of confidence for user authentication
- No setup requirements from users
- Allow user to register multiple device fingerprints for each account

## Demo
- Website - [https://www.try-sherlock.com/](https://www.try-sherlock.com/)
- Video - [YouTube Link](https://youtu.be/Aj9xxVyO2Y8)

## API Usage
1. Contact Sherlock administrators at `try.sherlock@gmail.com` to obtain an app key.
2. Download [sherlock.js](https://github.com/mjkim610/sherlock/blob/master/sherlock.js) into the web service directory.
3. Add the signup elements and JavaScript code into the service signup page

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

4. Add the login elements and JavaScript code into the service login page
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

5. For testing, visit [http://try-sherlock.com:8080/](http://try-sherlock.com:8080/)

## External Code
- fingerprintjs2 -  [https://github.com/Valve/fingerprintjs2](https://github.com/Valve/fingerprintjs2)
- sha256.js -  [https://code.google.com/archive/p/crypto-js/](https://code.google.com/archive/p/crypto-js/)
- Font Awesome -  [http://fontawesome.io/](http://fontawesome.io/)

## Authors
- ![sullamij](img/team/1-small.jpg) sullamij
- ![jhoney](img/team/2-small.jpg) jhoney
- ![mjkim](img/team/3-small.jpg) mjkim

## License

```
MIT License

Copyright (c) 2016 The Eagle Team

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.
```
