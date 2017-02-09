<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Sherlock_model extends CI_Model
{
  function __construct()
  {
    parent::__construct();
  }

  function init($appKey)
  {
    $this->db->where('appKey', $appKey);
    $this->db->from('service');
    $service = $this->db->get()->row();

    if( ! $service) return 'error';
    else return $service->token;
  }

  function compare_fingerprint($datas)
  {
    // 우리 회원인지 검사
    $this->db->where('email', $datas['email']);
    $this->db->from('user');
    $user = $this->db->get()->row();

    if( ! $user) return 'no user';

    // ntbf db에서 threshold 값 불러와야하는데..
    $this->db->where('app_id', $datas['app_id']);
    $this->db->where('token', $datas['token']);
    $this->db->from('service');
    $service = $this->db->get()->row();

    if( ! $service) return 'no service';

    $threshold_1 = $service->threshold_1;
    $threshold_2 = $service->threshold_2;
    $table_name = $service->table_name;
    $url = $service->url;

    // 우선 fp 검사
    $score = $this->get_fp_weight_score($datas);
    if( ! $score) return array('error', 'no score');

    if($datas['sherlock_type'] == 'fingerprint')
    {
      if($score < $threshold_1) return array('error', 'fp-wrong');
    }
    else if($datas['sherlock_type'] == 'pin')
    {
      if($score < $threshold_2) return array('error', 'pin hack');
      else if( ! password_verify($datas['pin'], $user->pin))
      {
        return array('error', 'pin wrong');
      }
    }
    else if($datas['sherlock_type'] == 'password')
    {
      if( ! password_verify($datas['password'], $user->password))
      {
        return array('error', 'password wrong');
      }
    }
    else return array('error', 'no sherlock type');

    // 해당 서비스의 회원인지 검사. 회원이면 로그인. 아니면 회원가입
    $this->db->where('user_id', $user->user_id);
    $this->db->from($table_name);
    $service_user = $this->db->get()->row();

    if( ! $service_user) return array('error', 'no service user');

    // redirect url 로 코드랑 보내면 될것같은데 어떤 방식으로???????
    return array('success', $service_user->user_code);

    // 회원가입은  어떻게 시키지?
  }

  function get_fp_weight_score($datas)
  {
    $this->db->where('email', $datas['email']);
    $this->db->from('user');
    $user = $this->db->get()->row();
    $user_id = $user->user_id;

    $this->db->where('user_id', $user_id);
    $this->db->from('fingerprint');
    $fingerprints = $this->db->get()->result();

    if( ! $fingerprints) return array('error', 'no fingerprint');

    $max_score = 0;

    $weight = json_decode(WEIGHT);
    foreach ($fingerprints as $fingerprint)
    {
      $tmp_score = 0;
      for($i = 1; $i <= 28; $i++)
      {
        $label = 'fp_'.$i;
        if($fingerprint->$label == $datas[$label])
        {
          $tmp_score += $weight[$i-1];
        }
      }
      if($tmp_score > $max_score) $max_score = $tmp_score;
    }

    return $max_score;
  }

  // unused
  function signup($datas)
  {
    $this->db->where('token', $datas['token']);
    $this->db->from('service');
    $service = $this->db->get()->row();

    if( ! $service)
    {
      return array('error', 'token error');
    }

    $tname = $service->tname;
    $mix = $service->mix;

    $this->db->where('email', $datas['email']);
    $this->db->from($tname);
    $user = $this->db->get()->row();

    if($user)
    {
      return array('error', 'email exist');
    }

    $this->db->set('email', $datas['email']);
    $this->db->set('password', $datas['password']);
    $this->db->set('pin', $datas['pin']);
    foreach ($datas['fps'] as $key => $value) {
      $this->db->set($key, $value);
    }
    $this->db->set('reg_date', 'NOW()', FALSE);
    $res = $this->db->insert($tname);

    if($res) return array('ok', 'ok');
    else return array('error', 'db fail');
  }

  // unused
  function login($datas)
  {
    $this->db->where('token', $datas['token']);
    $this->db->from('service');
    $service = $this->db->get()->row();

    if( ! $service)
    {
      return 'token error';
    }

    $tname = $service->tname;
    $mix = $service->mix;
    $thresh_1 = $service->thresh_1;
    $thresh_2 = $service->thresh_2;

    $this->db->where('email', $datas['email']);
    $this->db->from($tname);
    $user = $this->db->get()->row();

    if( ! $user) return array('error', 'no user');

    if($datas['loginType'] == 'email')
    {
      $weight = json_decode(WEIGHT);

      $score = 0;
      $i = 0;
      foreach ($datas['fps'] as $key => $value) {
        if($user->$key == $value)
        {
          $score += $weight[$i];
        }
        $i++;
      }
      if($score > $thresh_1) return array('ok', 'ok');
      else if($score > $thresh_2) return array('move', 'to pin');
      else return array('move', 'to pwd');
    }
    else if($datas['loginType'] == 'pin')
    {
      if($user->pin == $datas['pin']) return array('ok', 'ok');
      else return array('move', 'to pwd');
    }
    else if($datas['loginType'] == 'password')
    {
      if($user->password == $datas['password']) return array('ok', 'ok');
      else return array('error', 'password wrong');
    }
    else
    {
      return array('error', 'no loginType');
    }
  }
}
