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
      <h1 class="text-center login-title">Sherlock API Demo: Provider Sign Up</h1>
      <div class="account-wall">
        <img class="profile-img" src="<?=site_url('static/img/sherlock/favicon3.png')?>"
        alt="">
        <form class="form-signup" action="<?=site_url('auth/provider_signup')?>" method="post" onsubmit="return check_provider_signup();">
          <input type="email" class="form-control" id="form_email" name="email" placeholder="Email" value="<?=$this->session->flashdata('email')?>" required autofocus>
          <input type="password" class="form-control" id="form_password" name="password" placeholder="Password" required>
          <input type="text" class="form-control" id="form_name" name="name" placeholder="Name" value="<?=$this->session->flashdata('name')?>" required>
          <input type="text" class="form-control" id="form_phone" name="phone" placeholder="Phone number (xxx-xxxx-xxxx)" value="<?=$this->session->flashdata('phone')?>" required>
          <button class="btn btn-lg btn-primary btn-block" type="submit" id="wow">Sign up</button>
          <a href="<?=site_url('signup')?>" class="pull-right btn btn-link">Sign up as user </a>
          <input name="redirect" type="hidden" value="<?= $this->uri->uri_string() ?>" >
        </form>
      </div>
      <a href="<?=site_url('login')?>" class="text-center additional-message" id="wow" onclick="javascript">Log in </a>
    </div>
  </div>
</div>

<script type="text/javascript">
  function check_provider_signup()
  {
    var email = $('#form_email').val();
    var password = $('#form_password').val();
    var name = $('#form_name').val();
    var phone = $('#form_phone').val();

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
    if(name == '')
    {
      alert('이름을 입력해주세요');
      $('#form_name').focus();
      return false;
    }
    if(phone == '')
    {
      alert('연락가능한 전화번호를 입력해주세요');
      $('#form_phone').focus();
      return false;
    }
    if(!(/([0-9]{3})-([0-9]{3,4})-([0-9]{4})$/.test(phone)))
    {
      alert('전화번호의 형식은 xxx-xxxx-xxxx 입니다');
      $('#form_phone').focus();
      return false;
    }
    return true;
  }
</script>
