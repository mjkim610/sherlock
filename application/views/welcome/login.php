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
      <h1 class="text-center login-title">Sherlock API Demo: Log In</h1>
      <div class="account-wall">
        <img class="profile-img" src="<?=site_url('static/img/team/1.jpg')?>" alt="">
        <!-- 이미지좀 바꿉시다ㅋㅋ -->
        <form class="form-login" action="<?=site_url('auth/login')?>" method="post">
          <div class="form-group form-sherlock-usertype">
            <label class="radio-inline"><input type="radio" name="user_type" value="user" checked>일반회원</label>
            <label class="radio-inline"><input type="radio" name="user_type" value="provider">관리자</label>
          </div>

          <div class="form-group form-sherlock-email">
            <input type="email" class="form-control" name="email" placeholder="Email" value="<?=$this->session->flashdata('email')?>" required autofocus>
          </div>

          <div class="form-group form-sherlock-password">
            <input type="password" class="form-control" name="password" placeholder="Password" required>
          </div>

          <button class="btn btn-lg btn-primary btn-block" type="submit" id="wow">Log in</button>
          <a href="#" class="pull-right need-help">Need help? </a><span class="clearfix"></span>
          <input name="redirect" type="hidden" value="<?= $this->uri->uri_string() ?>" >
        </form>
      </div>
      <a href="<?=site_url('signup')?>" class="text-center additional-message" id="wow" onclick="javascript">Sign Up </a>
    </div>
  </div>
</div>
