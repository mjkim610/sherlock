<div class="container">
  <div class="row">
    <div class="col-sm-4 col-sm-offset-4" style="min-width: 300px">
      <h1 class="text-center login-title">Sherlock API : Sign up</h1>
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
        <form id="sherlock_login_form" class="form-login" action="<?=site_url('authenticate/signup/submit')?>" method="post">
          <div class="">
            <dl>
              <dt>Your Email</dt>
              <dd> <?=$user_info->email?></dd>
              <dt>Service Name</dt>
              <dd> <?=$service_info->service_name?></dd>
              <dt>Service description</dt>
              <dd> <?=$service_info->description?></dd>
            </dl>
            <br>
            <div class="text-center text-info">
              Really wanna sign up??
            </div>
          </div>
          <button class="btn btn-lg btn-primary btn-block" type="submit">Sign up</button>
          <a href="<?=site_url('/')?>" target="_blank" class="pull-right need-help"><i class="fa fa-arrow-right" aria-hidden="true" style="vertical-align: text-top;"></i> Sherlock home</a>

          <input type="hidden" name="token" value="<?=$token?>" >
          <input type="hidden" name="app_id" value="<?=$app_id?>" >
          <input type="hidden" name="id_token" value="<?=$id_token?>" >
          <input type="hidden" name="redirect" value="<?= $this->uri->uri_string() ?>" >
        </form>
      </div>
    </div>
  </div>
</div>
