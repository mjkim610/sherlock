<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('error_message_goto')){
  function error_message_goto($message, $path)
  {
    $CI =& get_instance();
    $CI->session->set_flashdata('message', $message);
    redirect($path);
  }
}

if ( ! function_exists('print_fingerprint_table')){
  function print_fingerprint_table($fingerprints)
  {
    $card_num = MAX_FINGERPRINT_NUM;

    $fp_index = 0;
    foreach ($fingerprints as $fingerprint)
    {
      $card_num--;
      // ntbf 아직 수정안함
      echo '<div class="col-sm-4">';
      echo '  <div class="fingerprint_card">';
      echo '    <div class="title">';
      echo      $fingerprint->title;
      echo '    </div>';
      echo '    <div class="date">';
      echo      $fingerprint->reg_date;
      echo '    </div>';
      echo '    <div class="button">';
      echo '        <button type="button" id="delete_button_'.$fingerprint->fingerprint_id.'" name="button" onclick="delete_fingerprint('.$fingerprint->fingerprint_id.');">Delete</button>';
      echo '    </div>';
      echo '  </div>';
      echo '</div>';
    }

    for($i = 0; $i < $card_num; $i++)
    {
      echo '<div class="col-sm-4">';
      echo '  <div class="fingerprint_card">';
      echo '      <div class="title">';
      echo '        <input type="text" id="title_'.$i.'" name="title" placeholder="Fingerprint description">';
      echo '      </div>';
      echo '      <div class="button">';
      echo '        <button type="button" id="regist_button_'.$i.'" name="button" onclick="regist_fingerprint('.$i.');">Regist</button>';
      echo '      </div>';
      echo '  </div>';
      echo '</div>';
    }
    echo '    <form id="fingerprint_form" action="'.site_url('user/regist_fingerprint').'" method="post">';
    echo '    </form>';
  }
}

if ( ! function_exists('print_my_site_table')){
  function print_my_site_table($my_sites)
  {
    $card_num = MAX_MY_SITE_NUM;

    $fp_index = 0;
    foreach ($my_sites as $my_site)
    {
      $card_num--;
      // ntbf 아직 수정안함
      echo '<div class="col-sm-4 '.$my_site->state.'">';
      echo '  <div class="my-site-card">';
      echo '    <div class="app_id">';
      echo        'App ID : '.$my_site->app_id;
          echo '</div>';
      echo '    <div class="service_name">';
      echo        $my_site->service_name;
      echo '    </div>';
      echo '    <div class="reg_date">';
      echo        $my_site->reg_date;
      echo '    </div>';
      echo '    <div class="button">';
      echo '        <a href="'.site_url('provider/regist/'.$my_site->app_id).'" class="btn btn-primary">Edit</a>';
      echo '    </div>';
      echo '  </div>';
      echo '</div>';
    }

    for($i = 0; $i < $card_num; $i++)
    {
      echo '<div class="col-sm-4">';
      echo '  <div class="my-site-card">';
      echo '    <div class="banner">';
      echo '    Regist to use Sherlock';
      echo '    </div>';
      echo '    <div class="button">';
      echo '      <a href="'.site_url('provider/regist').'" class="btn btn-primary">Regist</a>';
      echo '    </div>';
      echo '  </div>';
      echo '</div>';
    }
  }
}


if ( ! function_exists('make_random_string')){
  function make_random_string($length = 50)
  {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }

    return $randomString;
  }
}
