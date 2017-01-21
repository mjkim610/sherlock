<div class="container">
  <div class="row">
    <div class="col-sm-4 col-sm-offset-4" style="min-width: 300px">
      <?php
        if ($this->session->flashdata('errors'))
        {
          echo $this->session->flashdata('errors');
        }
        if ($this->session->flashdata('message'))
        {
          echo "<div class='alert'>";
          echo "<span class='closebtn'>&times;</span>";
          echo "<span>".$this->session->flashdata('message')."</span>";
          echo "</div>";
        }
      ?>
      <h1 class="text-center login-title">Sherlock API Demo: Sign Up</h1>
      <div class="account-wall">
        <img class="profile-img" src="<?=site_url('static/img/team/1.jpg')?>"
        alt="">
        <form class="form-signup" action="<?=site_url('auth/signup')?>" method="post" onsubmit="return check_signup();">
          <input type="email" class="form-control" id="form_email" name="email" placeholder="Email" value="<?=$this->session->flashdata('email')?>" required autofocus>
          <input type="password" class="form-control" id="form_password" name="password" placeholder="Password" required>
          <input type="password" class="form-control" id="form_pin" name="pin" placeholder="PIN" required>
          <button class="btn btn-lg btn-primary btn-block" type="submit" id="wow">Sign up</button>
          <a href="#" class="pull-right need-help">Need help? </a><span class="clearfix"></span>
          <a href="<?=site_url('provider-signup')?>" class="pull-right need-help">Sign up as provider </a><span class="clearfix"></span>
          <input name="redirect" type="hidden" value="<?= $this->uri->uri_string() ?>" >
        </form>
      </div>
      <a href="<?=site_url('login')?>" class="text-center additional-message" id="wow" onclick="javascript">Log in </a>
    </div>
  </div>
</div>

<script type="text/javascript">
  function check_signup()
  {
    var email = $('#form_email').val();
    var password = $('#form_password').val();
    var pin = $('#form_pin').val();

    if(email == '')
    {
      alert('이메일을 입력해주세요');
      $('#form_email').focus();
      return false;
    }
    if(password == '')
    {
      alert('비밀번호를 입력해주세요');
      $('#form_password').focus();
      return false;
    }
    if(pin == '')
    {
      alert('핀번호를 입력해주세요');
      $('#form_pin').focus();
      return false;
    }
    if(!(/^\d{4}$/.test(pin)))
    {
      alert('핀번호는 4자리 숫자의 형식이어야 합입니다');
      $('#form_pin').focus();
      return false;
    }
    return true;
  }
</script>
