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
