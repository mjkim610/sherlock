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

  function delete_fingerprint($datas)
  {
    $this->db->where('fingerprint_id', $datas['fingerprint_id']);
    $this->db->where('user_id', $datas['user_id']);
    $this->db->from('fingerprint');
    $fingerprint = $this->db->get()->row();

    if(!$fingerprint) return 'error';

    $this->db->where('fingerprint_id', $datas['fingerprint_id']);
    $this->db->where('user_id', $datas['user_id']);
    $res = $this->db->delete('fingerprint');

    if($res) return 'ok';
    else return 'fail';

  }
}
