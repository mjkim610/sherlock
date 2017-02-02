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

        <?php if($sherlock_type == 'password'): ?>
          <div class="form-group form-sherlock-password" >
              <input type="password" class="form-control" id="sherlock_password" name="password" placeholder="Password">
          </div>
        <?php elseif($sherlock_type == 'pin'): ?>
          <div class="form-group form-sherlock-pin">
              <input type="password" class="form-control" id="sherlock_pin" name="pin" placeholder="PIN">
          </div>
        <?php endif; ?>
        <input type="hidden" name="sherlock_type" value="<?=$sherlock_type?>">

          <button class="btn btn-lg btn-primary btn-block" type="button" id="wow" onclick="sherlock_login()">Log in</button>
          <a href="#" class="pull-right need-help">Need help? </a><span class="clearfix"></span>
        </form>
      </div>
      <!-- ntbf 회원가입 흐름을 어떻게 가져갈 것인지 -->
      <a href="<?=site_url('signup')?>" class="text-center additional-message" id="wow" onclick="javascript">Sign Up</a>
    </div>
  </div>
</div>
