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
    메인 페이지
    <button class="btn btn-primary" type="button" id="sherlock-btn" name="button">Try-it</button>
  </div>
</div>

<script type="text/javascript">
$('#sherlock-btn').click(function() {
  var get_string = '?';
  get_string = get_string + 'type=' + encodeURI('fingerprint pin password');
  get_string = get_string + '&token=' + encodeURI('Token Place');
  location.href = 'http://localhost/sherlock/sherlock/auth' + get_string;
});
</script>
