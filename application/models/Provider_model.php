<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Provider_model extends CI_Model
{
  function __construct()
  {
    parent::__construct();
  }

  function get_provider_site($provider_id)
  {
    $this->db->where('provider_id', $provider_id);
    $this->db->from('provider');
    $provider = $this->db->get()->row();

    if( ! $provider) return 'no provider';

    $this->db->where('provider_id', $provider_id);
    $this->db->from('service');
    $service = $this->db->get()->result();

    return $service;
  }

  function is_right_provider($provider_id, $app_id)
  {
    $this->db->where('provider_id', $provider_id);
    $this->db->where('app_id', $app_id);
    $this->db->from('service');
    $service = $this->db->get()->row();

    return $service;
  }

  function set_service($new_datas)
  {
    if($new_datas['extra']['state'] == 'regist')
    {
      $this->db->where('provider_id', $new_datas['extra']['provider_id']);
      $this->db->from('service');
      $num_of_service = $this->db->count_all_results();

      if($num_of_service >= MAX_MY_SITE_NUM) return 'over maximum';

      $table_name = 'z_'.make_random_string(30);
      while(1)
      {
        if ($this->db->table_exists($table_name))
          $table_name = 'z_'.make_random_string(30);
        else break;
      }

      $app_id = make_random_string(30);
      while(1)
      {
        $this->db->where('app_id', $app_id);
        $this->db->from('service');
        $service = $this->db->get()->row();
        if($service) $app_id = make_random_string(30);
        else break;
      }

      $token = make_random_string(50);

      foreach ($new_datas['datas'] as $key => $value) {
        $this->db->set($key, $value);
      }

      $this->db->set('provider_id', $new_datas['extra']['provider_id']);
      $this->db->set('token', $token);
      $this->db->set('app_id', $app_id);
      $this->db->set('table_name', $table_name);
      $this->db->set('state', 'prepare');
      $this->db->set('mod_date', 'NOW()', FALSE);
      $this->db->set('reg_date', 'NOW()', FALSE);
      $res = $this->db->insert('service');

      if($res) return 'ok';
    }
    else if($new_datas['extra']['state'] == 'edit')
    {
      foreach ($new_datas['datas'] as $key => $value) {
        $this->db->set($key, $value);
      }

      $token = make_random_string(50);
      $this->db->set('token', $token);
      // ntbf 수정 후 바로 이용하는건 문제의 소지가 있음
      // $this->db->set('state', 'prepare');
      $this->db->set('mod_date', 'NOW()', FALSE);
      $this->db->where('app_id', $new_datas['extra']['app_id']);
      $res = $this->db->update('service');

      if($res) return 'ok';
    }

    return 'error';

  }
}
