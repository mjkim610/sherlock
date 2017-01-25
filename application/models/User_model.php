<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class User_model extends CI_Model
{
  function __construct()
  {
    parent::__construct();
  }

  function get_user_fingerprints($user_id)
  {
    $this->db->where('user_id', $user_id);
    $this->db->from('fingerprint');
    $fingerprints = $this->db->get()->result();
    return $fingerprints;
  }

  function regist_fingerprint($datas)
  {
    foreach ($datas as $key => $value) {
      $this->db->set($key, $value);
    }
    $this->db->set('user_id', $datas['user_id']);
    $this->db->set('reg_date', 'now()', false);
    $res = $this->db->insert('fingerprint');
    return $res;
  }
}
