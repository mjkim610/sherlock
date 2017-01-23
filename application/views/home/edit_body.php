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
    개인정보 수정페이지
  </div>
</div>
