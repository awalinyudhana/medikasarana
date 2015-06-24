<?php
/**
 * Created by PhpStorm.
 * User: Lin
 * Date: 5/25/2015
 * Time: 11:01 PM
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Repair extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        if ($this->input->post()) {
            $this->form_validation->set_rules('email', 'Email',
                array('required', 'valid_email',
                    array(
                        'email_callable',
                        function ($str) {
                            if ($this->db->where(['email' => $str])->get('staff')->num_rows() > 0) {
                                return TRUE;
                            } else {
                                return FALSE;
                            }
                        }
                    )
                ), array(
                    'email_callable' => 'The {field} field not match'
                )
            );
            if ($this->form_validation->run() === TRUE) {
                $this->doResetPassword($this->input->post('email'));
                $this->session->set_flashdata('message', array('class' => 'success', 'msg' => 'please check your email'));
            } else {
                $msg = validation_errors('<p>', '</p>');
                $this->session->set_flashdata('message', array('class' => 'error', 'msg' => $msg));
            }
        }
        $this->parser->parse('repair.tpl');
    }

    public function email_check($str)
    {
        if ($this->db->get_where('staff', ['email' => $str])->num_rows() > 0) {
            return TRUE;
        } else {
            $this->form_validation->set_message(__FUNCTION__, 'The {field} field not match');
            return FALSE;
        }

    }

    private function doResetPassword($str)
    {

        $password = $this->randomPassword();
        $this->db
            ->where('email', $str)
            ->update('staff', ['password' => $this->acl->hash_password($password)]);

        $this->sendEmail($password);
    }

    private function randomPassword()
    {
        $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
        $pass = array(); //remember to declare $pass as an array
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
        for ($i = 0; $i < 8; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass); //turn the array into a string
    }

    private function sendEmail($str)
    {

    }
}