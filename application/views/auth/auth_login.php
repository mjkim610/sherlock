<div class="container">
  <div class="row">
    <div class="col-sm-4 col-sm-offset-4" style="min-width: 300px">
      <h1 class="text-center login-title">Sherlock API Demo: Log In</h1>
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
      <div class="account-wall">
        <img class="profile-img" src="<?=site_url('static/img/sherlock/favicon3.png')?>"
        alt="">
        <form id="sherlock_login_form" class="form-login" action="<?=site_url('sherlock/auth_login')?>" method="post">
          <div class="form-group form-sherlock-email">
            <input type="email" class="form-control" id="sherlock_email" name="email" placeholder="Email" required>
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
          <input type="hidden" id="sherlock_type" name="sherlock_type" value="<?=$sherlock_type?>">
          <input type="hidden" name="token" value="<?=$token?>" >
          <input type="hidden" name="app_id" value="<?=$app_id?>" >
          <input type="hidden" name="redirect" value="<?= $this->uri->uri_string() ?>" >
          <button class="btn btn-lg btn-primary btn-block" type="button" id="wow" onclick="sherlock_authentication()">Log in</button>
          <a href="<?=site_url('/')?>" target="_blank" class="pull-right need-help"><i class="fa fa-arrow-right" aria-hidden="true" style="vertical-align: text-top;"></i> Sherlock home</a>
        </form>
      </div>
      <!-- ntbf 회원가입 흐름을 어떻게 가져갈 것인지 -->
      <a href="<?=site_url('signup')?>" class="text-center additional-message" id="wow" onclick="javascript">Sign Up</a>
    </div>
  </div>
</div>
<script type="text/javascript">
  function sherlock_authentication()//0~2
  {
    if($("#sherlock_email").val().length <= 0)
    {
      alert("Email required");
      $("#sherlock_email").focus();
      return false;
    }
    if($("#sherlock_type").val() === "password" && $("#sherlock_password").val().length <= 0)
    {
      alert("Password required");
      $("#sherlock_password").focus();
      return false;
    }
    if($("#sherlock_type").val() === "pin" && ($("#sherlock_pin").val().length != 4 || isNaN( $("#sherlock_pin").val() )))
    {
      alert("4 digits PIN required");
      $("#sherlock_pin").focus();
      return false;
    }

    var fp = new Fingerprint2();
    var index = 1;
    fp.get(function(result, components) {
      for (var property in components) {
        var input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'fp_'+index++;
        input.value = components[property]['value'];
        $('#sherlock_login_form').append(input);
      };

      $('#sherlock_login_form').submit();
    });
    return true;
  }
</script>
