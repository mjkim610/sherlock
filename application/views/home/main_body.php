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
      메인 페이지
      <button class="btn btn-primary" type="button" id="sherlock-btn" name="button">Try-it</button>
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
$('#sherlock-btn').click(function() {

  var app_id = 'Qdjjaalsdkjl12k3jasdLAKasdfJJksk';
  $.ajax({
    type : "POST",
    data : {
      app_id : app_id
    },
    url : "http://try-sherlock.com:8080/auth/api_signup",
    success: function(ajax_result)
    {
      var ajax_result = $.parseJSON(ajax_result);
      // token 받아오기

      // if(ajax_result['redirect_uri'].length == 0) // no data
      // {
      //   alert('try again..');
      //   return false;
      // }

      var get_string = '?';
      get_string = get_string + 'sherlock_type=' + encodeURI('fingerprint'); // fingerprint pin password
      get_string = get_string + '&token=' + encodeURI('Token Place'); // ajax_result['token']
      get_string = get_string + '&app_id=' + encodeURI('asd23fgasdgasf32'); // ajax_result['token']
      // get_string = get_string + '&redirect_uri=' + encodeURI('Token Place'); // ajax_result['redirect_uri']
      location.href = 'http://localhost/sherlock/authentication' + get_string;
    }
  });
});
</script>
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
