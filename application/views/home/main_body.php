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
    <h2>Main page.</h2>
    <h4>Welecome to Sherlock Authentication page</h4>
    <div class="main-section">
      <h4>You can try Sherlock Authentication API here</h4>
      <button class="btn btn-lg btn-primary" type="button" id="sherlock-btn" onclick="Sherlock_init('asd23fgasdgasf32')" name="button">Sherlock auth</button>
    </div>
    <div class="main-section">
      <h4>You can check your Browser fingerprint that we use to authenticate</h4>
      <button class="btn btn-lg btn-primary" type="button" id="sherlock-test-btn" name="button">Check your fingerprint</button>
      <div>
        <span id="components"></span>
      </div>
    <div class="main-section">
      <h4>Guide for</h4>
      <a href="<?=site_url('about')?>" class="btn btn-lg btn-link" id="sherlock-test-btn">User</a>
      <a href="<?=site_url('about/dev')?>" class="btn btn-lg btn-link" id="sherlock-test-btn">Service Provider</a>
    </div>
  </div>
</div>

<script type="text/javascript">
$('#sherlock-test-btn').click(function() {
  var d1 = new Date();
  var fp = new Fingerprint2();
  fp.get(function(result, components) {
      var d2 = new Date();
      var timeString = "Time took to calculate the fingerprint: " + (d2 - d1) + "ms";

      var output = '';
      var linenumber = 1;
      for (var property in components) {
          output += linenumber + ': <b>' + components[property]['key'] + '</b><br>' + String(components[property]['value']).substring(0, 1248)+'<br><br>';
          linenumber++;
      }
      $("#fp").text(result);
      $("#time").text(timeString);
      $("#components").html(output);
  });
});
</script>
