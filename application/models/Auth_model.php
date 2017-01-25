<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Auth_model extends CI_Model
{
  function __construct()
  {
    parent::__construct();
  }

  public function login($datas)
  {
    $this->db->where('email', $datas['email']);
    $this->db->from($datas['user_type']);
    $user = $this->db->get()->row();

    if(!$user)
    {
      return 'no email';
    }
    else
    {
      if(password_verify($datas['password'], $user->password))
      {
        $this->session->set_userdata(array('is_login'=> TRUE));
        $this->session->set_userdata(array('user_email'=> $datas['email']));
        if($datas['user_type'] == 'user') $this->session->set_userdata(array('user_id'=> $user->user_id));
        else if($datas['user_type'] == 'provider') $this->session->set_userdata(array('user_id'=> $user->provider_id));
        $this->session->set_userdata(array('user_type'=> $datas['user_type']));
        return 'ok';
      }
      else return 'pwd wrong';
    }
  }

  public function signup($data)
  {
    $this->db->where('email', $data['email']);
    $this->db->from('user');
    $user = $this->db->get()->row();

    $this->db->where('email', $data['email']);
    $this->db->from('provider');
    $provider = $this->db->get()->row();

    if($provider || $user)
    {
      return 'email existed';
    }
    else
    {
      $this->db->set('email', $data['email']);
      $this->db->set('password', password_hash($data['password'], PASSWORD_BCRYPT));
      $this->db->set('pin', password_hash($data['pin'], PASSWORD_BCRYPT));
      $this->db->set('reg_date', 'now()', false);
      $this->db->insert('user');

      $created_id = $this->db->insert_id();
      if($created_id)
      {
        $this->session->set_userdata(array('is_login'=> TRUE));
        $this->session->set_userdata(array('user_email'=> $datas['email']));
        $this->session->set_userdata(array('user_id'=> $created_id));
        $this->session->set_userdata(array('user_type'=> 'user'));
        return 'ok';
      }
      else
      {
        return 'error';
      }
    }
  }

  public function signup_provider($data)
  {
    $this->db->where('email', $data['email']);
    $this->db->from('user');
    $user = $this->db->get()->row();

    $this->db->where('email', $data['email']);
    $this->db->from('provider');
    $provider = $this->db->get()->row();

    if($provider || $user)
    {
      return 'email existed';
    }
    else
    {
      $this->db->set('email', $data['email']);
      $this->db->set('password', password_hash($data['password'], PASSWORD_BCRYPT));
      $this->db->set('name', $data['name']);
      $this->db->set('phone', $data['phone']);
      $this->db->set('reg_date', 'now()', false);
      $this->db->insert('provider');

      $created_id = $this->db->insert_id();
      if($created_id)
      {
        $this->session->set_userdata(array('is_login'=> TRUE));
        $this->session->set_userdata(array('user_email'=> $datas['email']));
        $this->session->set_userdata(array('user_id'=> $created_id));
        $this->session->set_userdata(array('user_type'=> 'provider'));
        return 'ok';
      }
      else
      {
        return 'error';
      }
    }
  }
  }
