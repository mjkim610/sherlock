<div class="container">
  <div class="row">
    <div class="col-sm-4 col-sm-offset-4" style="min-width: 300px">
      <h1 class="text-center login-title">Sherlock API Demo: Log In</h1>
      <div class="account-wall">
        <img class="profile-img" src="<?=site_url('static/img/team/1.jpg')?>"
        alt="">
        <form class="form-login">
          <div class="form-group form-sherlock-email">
            <input type="email" class="form-control" id="sherlock_email" name="email" placeholder="Email" required autofocus>
          </div>

          <div class="form-group form-sherlock-password" style="display:none;" >
            <input type="password" class="form-control" id="sherlock_password" name="password" placeholder="Password">
          </div>

          <div class="form-group form-sherlock-pin" style="display:none;" >
            <input type="password" class="form-control" id="sherlock_pin" name="pin" placeholder="PIN">
          </div>

          <button class="btn btn-lg btn-primary btn-block" type="button" id="wow" onclick="sherlock_login()">Log in</button>
          <p id="result"></p>
          <a href="#" class="pull-right need-help">Need help? </a><span class="clearfix"></span>
        </form>
      </div>
      <a href="<?=site_url('signup')?>" class="text-center additional-message" id="wow" onclick="javascript">Sign Up </a>
    </div>
  </div>
</div>
