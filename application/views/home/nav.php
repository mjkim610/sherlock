<nav class="navbar navbar-fixed-top">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#nav-btn" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand text-center" href="<?=site_url('/');?>"><img src="<?=site_url('static/img/sherlock-logo.png')?>" alt="sherlock"></a>
    </div>
    <div class="collapse navbar-collapse" id="nav-btn">
      <ul class="nav navbar-nav nav_menu">
        <?php $nav_menu_css = "background: #003d54; color: #fff;" ?>
        <li><a href="<?=site_url('about')?>" style="<?=($this->uri->segment(1) == 'about') ? $nav_menu_css:''?>">What is Sherlock?</a></li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <?php if ($this->session->userdata('user_id')): ?>
          <li class="dropdown" style="<?=($this->uri->segment(1) == 'my') ? $nav_menu_css:''?>"><a class="dropdown-toggle" data-toggle="dropdown" href="#">My sherlock<span class="caret"></span></a>
            <ul class="dropdown-menu">
            <!-- ntbf 관리자, 유저 구분하고 각각에 메뉴 구성하기 -->
            <?php if ($this->session->userdata('user_type') == 'user'): ?>
              <li><a href="<?=site_url('my/fingerprint')?>" style="<?=($this->uri->segment(2) == 'fingerprint') ? $nav_menu_css:''?>">My Fingerprint</a></li>
              <li><a href="<?=site_url('my/user2')?>" style="<?=($this->uri->segment(2) == 'user2') ? $nav_menu_css:''?>">User menu2</a></li>
            <?php elseif ($this->session->userdata('user_type') == 'provider'): ?>
              <li><a href="<?=site_url('my/site')?>" style="<?=($this->uri->segment(2) == 'site') ? $nav_menu_css:''?>">My site</a></li>
              <li><a href="<?=site_url('my/provider2')?>" style="<?=($this->uri->segment(2) == 'provider2') ? $nav_menu_css:''?>">Provider menu2</a></li>
            <?php endif; ?>
            </ul>
          </li>
          <li><a href="<?=site_url('user');?>" style="<?=($this->uri->segment(1) == 'user') ? $nav_menu_css:''?>">Edit info</a></li>
          <li><a href="<?=site_url('auth/logout');?>">Logout</a></li>
        <?php else: ?>
          <li><a href="<?=site_url('signup');?>">Sign up</a></li>
          <li><a href="<?=site_url('login?returnURL='.rawurlencode(current_url()))?>">Login</a></li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>

<div class="container" style="padding-top:30px;">
