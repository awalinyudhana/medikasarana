<?php defined('BASEPATH') OR exit('No direct script access allowed');

class UpdateProfile extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('ModUsers');
    }

    public function index()
    {
        $this->load->helper('security');
        if ($this->input->post()) {
            if ($this->form_validation->run('users/update-profile') === TRUE) {
                if ($this->old_password_check($this->input->post('old_password'))) {
                    $data = array(
                            'username' => $this->input->post('username'),
                            'password' => $this->acl->hash_password($this->input->post('password')),
                            'plain_password' => $this->input->post('password')
                        );
                    $this->ModUsers->updateProfile($this->session->userdata('uid'), $data);
                    
                    $staff_email = $this->ModUsers->getStaffEmail($this->session->userdata('uid'));
                    $this->sendEmail($staff_email, $this->input->post('username'), $this->input->post('password'));
                    redirect('login/logout');
                } else {
                    $data['error'] = 'Password lama salah';
                }
            }
        }
        $data[] = '';
        $this->parser->parse('update-profile.tpl', $data);
    }

    public function old_password_check($old_password) 
    {
        $old_password_hash = $this->acl->hash_password($old_password);
        if (!$this->ModUsers->checkOldPassword($this->session->userdata('uid'), $old_password_hash)) {
            $this->form_validation->set_message('old_password_check', 'Password Lama not match');
            return false;
        }
        return true;
    }

    private function sendEmail($to, $username, $password)
    {
        $this->load->library('email'); // load email library
        $this->email->from('medikasarana@gmail.com', 'Medika Sarana');
        $this->email->to($to);
        $this->email->subject('Perubahan User Profile');
        $this->email->message('Berikut adalah informasi profil baru anda: <br> Username: ' . $username . '<br> Password: ' . $password);
        if (!$this->email->send())
            echo "There is error in sending mail!";
    }
}