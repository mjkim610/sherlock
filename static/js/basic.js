function validateURL(url) {
  var reurl = /^(http[s]?:\/\/){0,1}(www\.){0,1}[a-zA-Z0-9\.\-]+\.[a-zA-Z]{2,5}[\.]{0,1}/;
  return reurl.test(url);
}

function check_provider_regist_form()
{
  // Validate URL
  var url = $("#url").val();
  if ( ! validateURL(url))
  {
    alert("Please enter a valid URL including http[s]://");
    $("#url").focus();
    return false;
  }

  var redirect_url = $("#redirect_url").val();
  if ( ! validateURL(redirect_url))
  {
    alert("Please enter a valid URL including http[s]://");
    $("#redirect_url").focus();
    return false;
  }

  var threshold_1 = Number($("#threshold_1").val());
  var threshold_2 = Number($("#threshold_2").val());
  if (threshold_1 == 0 || threshold_2 == 0)
  {
    alert("Threshold should be integer in 1~100");
    return false;
  }

  if(threshold_1 <= threshold_2)
  {
    alert("Threshold 1 should be bigger than Threshold 2");
    return false;
  }

  return true;
}
