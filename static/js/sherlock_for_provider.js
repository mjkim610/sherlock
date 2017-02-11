// sherlock js  for service provider
// just for when click sherlock-login button
function Sherlock_init(app_id)
{
  var app_id = 'asd23fgasdgasf32'; // Your App ID Here
  $.ajax({
    type : "POST",
    data : {
      app_id : app_id
    },
    // url : "http://localhost/sherlock/authenticate/init",
    url : "http://try-sherlock.com/authenticate/init",
    success: function(token)
    {
      var get_string = '?';
      get_string = get_string + 'sherlock_type=' + encodeURI('fingerprint'); // fingerprint pin password
      get_string = get_string + '&token=' + encodeURI(token); // ajax_result['token']
      get_string = get_string + '&app_id=' + encodeURI(app_id); // ajax_result['token']
      // location.href = 'http://localhost/sherlock/authenticate' + get_string;
      location.href = 'http://try-sherlock.com/authenticate' + get_string;
    }
  });
}
