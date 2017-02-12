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
}
