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
  <div class="col-sm-12">
    <div class="col-sm-10 col-sm-offset-1">
      <h2>메인 페이지</h2>
      <button class="btn btn-primary" type="button" id="sherlock-btn" onclick="Sherlock_init('asd23fgasdgasf32')" name="button">Try-it</button>
    </div>
  </div>
  <div class="col-sm-12">
    <div class="col-sm-10 col-sm-offset-1">
      <button class="btn btn-primary" type="button" id="sherlock-test-btn" name="button">Test your fingerprint</button>
      <div>
        <span id="components"></span>
      </div>
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
