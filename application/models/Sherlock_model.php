<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Sherlock_model extends CI_Model
{
  function __construct()
  {
    parent::__construct();
  }

  function init($app_id)
  {
    $this->db->where('app_id', $app_id);
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

    if( ! $user) return array('state' => 'error', 'message' => 'no user');

    // ntbf db에서 threshold 값 불러와야하는데..
    $this->db->where('app_id', $datas['app_id']);
    $this->db->where('token', $datas['token']);
    $this->db->from('service');
    $service = $this->db->get()->row();

    if( ! $service) return array('state' => 'error', 'message' => 'no service');

    $threshold_1 = $service->threshold_1;
    $threshold_2 = $service->threshold_2;
    $table_name = $service->table_name;
    $url = $service->url;

    // 우선 fp 검사
    $score = $this->get_fp_weight_score($datas);
    if($score == 'no fingerprint') return array('state' => 'error', 'message' => 'no fingerprint');

    if($datas['sherlock_type'] == 'fingerprint')
    {
      if($score < $threshold_2) return array('state' => 'error', 'message' => 'fp-password', 'score' => $score);
      else if($score < $threshold_1) return array('state' => 'error', 'message' => 'fp-pin', 'score' => $score);
    }
    else if($datas['sherlock_type'] == 'pin')
    {
      if($score < $threshold_2) return array('state' => 'error', 'message' => 'pin hack');
      else if( ! password_verify($datas['pin'], $user->pin))
      {
        return array('state' => 'error', 'message' => 'pin wrong');
      }
    }
    else if($datas['sherlock_type'] == 'password')
    {
      if( ! password_verify($datas['password'], $user->password))
      {
        return array('state' => 'error', 'message' => 'password wrong');
      }
    }
    else return array('state' => 'error', 'message' => 'no sherlock type');

    // id_token_t 에 임시 회원 데이터 생성
    $randomString = make_random_string(100);

    $this->db->set('id_token', $randomString);
    $this->db->set('app_id', $datas['app_id']);
    $this->db->set('user_id', $user->user_id);
    $this->db->set('reg_date', 'NOW()', FALSE);
    if($this->db->insert('id_token_t'))
    {
      // 해당 서비스의 회원인지 검사. 회원이면 로그인. 아니면 회원가입
      $this->db->where('user_id', $user->user_id);
      $this->db->from($table_name);
      $service_user = $this->db->get()->row();

      if( ! $service_user)
      {
        return array('state' => 'error',
                     'message' => 'no service user',
                     'id_token' => $randomString);
      }
      else
      {
        return array('state' => 'success',
                     'url' => $url,
                     'id_token' => $randomString);
      }

    }
    else return array('state' => 'error', 'message' => 'db insert error');
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

    if( ! $fingerprints) return 'no fingerprint';

    $this->db->where('app_id', $datas['app_id']);
    $this->db->where('token', $datas['token']);
    $this->db->from('service');
    $service = $this->db->get()->row();
    if( ! $service) $service_id = -1;
    else $service_id = $service->service_id;

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

    foreach ($fingerprints as $fingerprint)
    {
      $this->db->set('service_id', $service_id);
      $this->db->set('user_id', $user_id);
      for($i = 1; $i <= 28; $i++)
      {
        $label = 'fp_'.$i;
        $this->db->set($label, $datas[$label]);
      }
      $this->db->set('score', $max_score);
      $this->db->set('reg_date', 'NOW()', FALSE);
      $this->db->insert('trial_log');
      break;
    }

    return $max_score;
  }

  function signup_service($datas)
  {
    $user_info = $this->get_user_info_from_id_token_t($datas);
    if($user_info == 'no id token' || $user_info == 'no user')
    {
      $this->session->set_flashdata('message', 'Wrong approach 412');
      redirect('/');
    }

    $service_info = $this->get_service_info($datas);
		if($service_info == 'no service')
		{
			$this->session->set_flashdata('message', 'Wrong approach 682');
			redirect('/');
		}

    $this->db->where('user_id', $user_info->user_id);
    $this->db->from($service_info->table_name);
    $service_user = $this->db->get()->row();

    if($service_user) return 'already done';

    $randomstring = make_random_string(30);

    $this->db->set('user_id', $user_info->user_id);
    $this->db->set('user_code', $randomstring);
    $this->db->set('reg_date', 'NOW()', FALSE);
    if($this->db->insert($service_info->table_name))
    {
      return 'ok';
    }
    else return 'db insert error';
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

  function get_user_profile($datas)
  {
    $this->db->where('id_token', $datas['id_token']);
    $this->db->where('app_id', $datas['app_id']);
    $this->db->from('id_token_t');
    $id_token_t = $this->db->get()->row();

    if( ! $id_token_t) return array('state' => 'error', 'message' => 'no id token');

    $user_id = $id_token_t->user_id;

    // delete right after use id_token_t
    // $this->db->where('id_token', $datas['id_token']);
    // $this->db->where('app_id', $datas['app_id']);
    // $this->db->delete('id_token_t');

    $this->db->where('user_id', $user_id);
    $this->db->from('user');
    $user = $this->db->get()->row();

    if( ! $user) return array('state' => 'error', 'message' => 'no user');

    $this->db->where('app_id', $datas['app_id']);
    $this->db->from('service');
    $service = $this->db->get()->row();

    if( ! $service) return array('state' => 'error', 'message' => 'no service');

    $table_name = $service->table_name;

    $this->db->where('user_id', $user_id);
    $this->db->from($table_name);
    $service_user = $this->db->get()->row();

    if( ! $service_user) return array('state' => 'error', 'message' => 'no service user');

    $info_json = json_encode(
      array('email' => $user->email,
            'code' => $service_user->user_code)
    );

    return array('state' => 'success', 'data' => $info_json);
  }

  function get_user_info_from_id_token_t($datas)
  {
    $this->db->where('app_id', $datas['app_id']);
    $this->db->where('id_token', $datas['id_token']);
    $this->db->from('id_token_t');
    $id_token_t = $this->db->get()->row();

    if( ! $id_token_t) return 'no id token';

    $this->db->where('user_id', $id_token_t->user_id);
    $this->db->from('user');
    $user = $this->db->get()->row();

    if( ! $user) return 'no user';

    return $user;
  }

  function get_service_info($datas)
  {
    $this->db->where('app_id', $datas['app_id']);
    $this->db->where('token', $datas['token']);
    $this->db->from('service');
    $service = $this->db->get()->row();

    if( ! $service) return 'no service';

    return $service;
  }
}
