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
    <!--
    <button class="btn btn-lg btn-primary btn-block" type="button" id="description-ko">Description (Korean)</button>
    <button class="btn btn-lg btn-primary btn-block" type="button" id="description-en">Description (English)</button>
    -->

    <img src="<?=site_url('/static/img/about/sherlock-description-ko.png')?>" alt="Sherlock Description (Korean)" style="max-width: 100%; max-height: 100%">

    <!--
    <img src="<?=site_url('/static/img/about/sherlock-description-ko.png')?>" alt="Sherlock Description (English)" style="max-width: 100%; max-height: 100%">
    -->

  </div>
</div>
