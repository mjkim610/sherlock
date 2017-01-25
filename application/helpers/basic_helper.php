<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('print_fingerprint_table')){
  function print_fingerprint_table($fingerprints)
  {
    $card_num = 3;
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
      echo '     갱신버튼';
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
      echo '        <button type="button" id="button_'.$i.'" name="button" onclick="regist_fingerprint('.$i.');">Regist</button>';
      echo '      </div>';
      echo '  </div>';
      echo '</div>';
    }
    echo '    <form id="fingerprint_form" action="'.site_url('user/regist_fingerprint').'" method="post">';
    echo '    </form>';
  }
}
