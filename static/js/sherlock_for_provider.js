// sherlock js  for service provider
// just for when click sherlock-login button
function Sherlock_init(app_id)
{
  $.ajax({
    type : "POST",
    data : {
      app_id : app_id
    },
    // url : "http://localhost/sherlock/authenticate/init",
    url : "https://try-sherlock.com/authenticate/init",
    success: function(token)
    {
      var get_string = '?';
      get_string = get_string + 'sherlock_type=' + encodeURI('fingerprint'); // fingerprint pin password
      get_string = get_string + '&token=' + encodeURI(token); // ajax_result['token']
      get_string = get_string + '&app_id=' + encodeURI(app_id); // ajax_result['token']
      // location.href = 'http://localhost/sherlock/authenticate' + get_string;
      location.href = 'https://try-sherlock.com/authenticate' + get_string;
    },
    error: function (xhr, ajaxOptions, thrownError) {
         console.log(xhr.status);
         console.log(xhr.responseText);
         console.log(thrownError);
     }
  });
}
