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
    사이트 관리
    다수 존재 가능

      app_id
      url
      threshold_1
      threshold_2
      description
      reg_date
      <?php print_my_site_table($my_sites); ?>
  </div>
</div>
