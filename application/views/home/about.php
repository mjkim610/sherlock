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
<div class="row">
  <div class="col-sm-10 col-sm-offset-1">
    <a href="<?=site_url('about/dev')?>" class="btn btn-lg btn-link">Are you a developer?</a>
    <img class="about-image" src="<?=site_url('/static/img/about/d2_onepage.png')?>" alt="Sherlock Description (Korean)">
  </div>
</div>
