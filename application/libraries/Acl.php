<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Simple config file based ACL
 *
 * @author Kevin Phillips <kevin@kevinphillips.co.nz>
 */
class Acl
{

    private $_CI;

    function __construct()
    {
        $this->_CI = &get_instance();
        $this->_CI->config->load('acl');
        $this->db = $this->_CI->db;
        $this->menu = "";
    }

    /**
     * function that checks that the user has the required permissions
     *
     * @param string $controller
     * @param array $required_permissions
     * @param integer $author_uid
     * @return boolean
     */
    public function auth($module, $login = true)
    {

        $msg = $this->_CI->config->item('module_auth_message');
        if ($login) {
            if (!$this->is_logged_in()) {
                $this->_CI->session->set_flashdata('message',
                    [
                        'class' => 'error',
                        'msg' => $msg,
                        'anchor' => current_url()
                    ]
                );
                redirect(base_url($this->_CI->config->item('login_controller')));
            }
        }
        $user_roles = $this->_CI->session->userdata('roles');
//        $module = $this->module($dir);
        if (is_array($user_roles) && in_array($module, $user_roles))
            return true;
        $this->_CI->session->set_flashdata('message',
            [
                'class' => 'error',
                'msg' => $msg
            ]
        );
        redirect(base_url($this->_CI->config->item('login_landing_page')));
    }

    /**
     * Function to see module folder
     */

//    public function module($dir)
//    {
//
//        $dir = explode('/', $dir, -1);
//        $length = count($dir);
//        return strtolower($dir[$length - 1]);
//    }

    /**
     * Function to see if a user is logged in
     */
    public function is_logged_in()
    {
        $uid = $this->_CI->session->userdata('uid');
        if ($uid) {
            return TRUE;
        }
    }


    function validate($redirect = NULL)
    {
        $username = $this->_CI->input->post('username');
        $password = $this->_CI->input->post('password');
        $this->_CI->form_validation->set_rules('username', 'Username', 'required|strip_tags');
        $this->_CI->form_validation->set_rules('password', 'Password', 'required|strip_tags');
        if ($this->_CI->form_validation->run() === FALSE) {
            $msg = validation_errors('<p>', '</p>');
            $this->_CI->session->set_flashdata('message', array('class' => 'error', 'msg' => $msg));
            redirect(base_url($this->_CI->config->item('login_controller')));
        } else {
            $users = $this->getUsers($username);
            $msg = $this->_CI->config->item('failed_login_message');
            if ($users) {
//                $user = $users[$username];
                $user = $users;
                $user_hash_password = $this->_CI->config->item('hash_password');
                if ($user_hash_password) {
                    $password = $this->hash_password($password);
                }
                if ($user['password'] == $password) {
                    // User has been authenticated lets log them in
                    $roles = json_decode($user['roles'], true);
                    $msg = $this->_CI->config->item('login_message');
                    $this->_CI->session->set_flashdata('message', array('class' => 'success', 'msg' => $msg));
                    $data = array(
                        'uid' => $user['id_staff'],
                        'roles' => $roles,
                        'username' => $username,
                        'name' => $user['name'],
                        'name_group' => $user['name_group'],
                        'menu' => $this->getMenu($roles)
                    );
                    $this->_CI->session->set_userdata($data);
                    $page = isset($redirect) ? $redirect : $this->_CI->config->item('login_landing_page');
                    redirect(base_url($page));
                } else {
                    $this->_CI->session->set_flashdata('message', array('class' => 'error', 'msg' => $msg));
                    redirect(base_url($this->_CI->config->item('login_controller')));
                }
            } else {
                // Users have not been set in the config form
                $this->_CI->session->set_flashdata('message', array('class' => 'error', 'msg' => $msg));
                redirect(base_url($this->_CI->config->item('login_controller')));
            }
        }

    }

    /**
     * Function to log user out and redirect them to
     * logged out landing page
     *
     * @param string $redirect Optional
     */
    public function logout($redirect = NULL)
    {
        $page = isset($redirect) ? $redirect : $this->_CI->config->item('logout_landing_page');

        $session_data = $this->_CI->session->all_userdata();
        foreach ($session_data as $_key => $_value) {
            $this->_CI->session->unset_userdata($_key);
        }

        $logout_message = $this->_CI->config->item('logout_message');
        $this->_CI->session->set_flashdata('message', array('class' => 'success', 'msg' => $logout_message));

        redirect(base_url($page));
    }

    /**
     * Function that returns a password hashed
     *
     * @param string $password
     * @param string $salt
     * @return string $hashed_password
     */
    public function hash_password($password = NULL)
    {
        if ($password) {
            // Do we need to get the salt ?
            $salt = $this->_CI->config->item('salt');
            if ($salt) {
                $password = $salt . $password;
            }
            $hashed_password = do_hash($password);

            return $hashed_password;
        }
    }

    /**
     * Function that returns a users data
     *
     * @param string $username
     */
    private function getUsers($param)
    {
        return $this->db
            ->from('staff')
            ->join('staff_group', 'staff.id_group = staff_group.id_group')
            ->where('username', $param)
            ->get()
            ->row_array();
    }

    /**
     * Function that returns available menu
     * @param array $roles
     */

    private function getMenu($roles)
    {
        $router = $this->_CI->config->item('module_router');
        $this->menu .= "<ul class=\"navigation\">";
        $this->roles = $roles;
        $this->filter($router);
        $this->menu .= "</ul>";
        return $this->menu;
    }


    private function filter($router = array())
    {
        foreach ($router as $value) {
            if (isset($value['child']) && !is_null($value['child']) && is_array($value['child'])) {
                $title = isset($value['title']) ? $value['title'] : "";
                $icon = isset($value['icon']) ? $value['icon'] : "";
                $this->menu .= "<li>";
                $this->menu .= "<a href=\"#\"><span>$title</span><i class=\"$icon\"></i></a>";
                $this->menu .= "<ul>";
                $this->filter($value['child']);
                $this->menu .= "</ul></li>";
            } else if (in_array($value['module'], $this->roles)) {
                $title = isset($value['title']) ? $value['title'] : "";
                $url = isset($value['title']) ? $value['url'] : "";
                $this->menu .= "<li>";
                $this->menu .= "<a href=\"".base_url($url)."\">$title</a>";
                $this->menu .= "</li>";
            }
        }
    }

    public function getModulesList()
    {
        $modules = $this->_CI->config->item('module_list');
        return $modules;
    }

}

/* End of application/libraries/acl.php */