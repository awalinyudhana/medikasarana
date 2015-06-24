<?php
/**
 * Created by PhpStorm.
 * User: Lin
 * Date: 5/25/2015
 * Time: 3:03 PM
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->acl->auth('users');
        $this->load->library('grocery_CRUD');
        $this->menu = "";
        $this->roles = $this->session->userdata('roles');
        $this->load->model('ModUsers');
    }

    public function render($output)
    {
        $this->parser->parse("index.tpl", $output);
    }

    public function renderGroup($output)
    {
        $this->parser->parse("group-index.tpl", $output);
    }

    public function index()
    {
        $crud = new grocery_CRUD();

        $crud->set_table('staff')
            ->columns('id_group', 'nip', 'name', 'username', 'email', 'register_date')
            ->display_as('id_group', 'Group Name')
            ->display_as('nip', 'NIP')
            ->display_as('register_date', 'Register Date')
            ->set_relation('id_group', 'staff_group', 'name_group')
            ->field_type('password', 'password')
            ->callback_field('password', array($this, 'setPasswordInputToEmpty'))
            ->callback_before_insert(array($this, 'checkPassword'))
            ->callback_before_update(array($this, 'encryptPasswordCallback'))
            ->required_fields('id_group', 'nip', 'name', 'username', 'email')
            ->set_rules('email', 'Email', 'valid_email')
            ->set_rules('nip', 'NIP', 'integer|required')
            ->unset_fields('register_date')
            ->unset_read();
        $output = $crud->render();
        $this->render($output);
    }

    function checkPassword($post_array)
    {
        if (empty($post_array['password'])) {
            $message = 'The Password field is required';
            $this->form_validation->set_message('password', $message);
            return false;
        } else {
            $post_array['password'] = $this->acl->hash_password($post_array['password']);
            return $post_array;
        }
    }

    function setPasswordInputToEmpty()
    {
        return "<input type='password' name='password' value='' />";
    }

    function encryptPasswordCallback($post_array, $primary_key)
    {
        if (!empty($post_array['password'])) {
            $post_array['password'] = $this->acl->hash_password($post_array['password']);
        } else {
            unset($post_array['password']);
        }

        return $post_array;
    }

    public function group()
    {
        $crud = new grocery_CRUD();

        $crud->set_table('staff_group')
            ->columns('name_group', 'note', 'jml_user')
            ->fields('name_group', 'note')
            ->display_as('name_group', 'Group Name')
            ->display_as('jml_user', 'Jumlah User')
            ->required_fields('name_group')
            ->callback_column('jml_user', array($this, 'countJmlUser'))
            ->callback_field('note', array($this, 'setTextarea'))
            ->add_action('Update Role', '', '', 'read-icon', array($this, 'addUpdateRoleAction'))
            ->unset_read();
        $output = $crud->render();
        $this->renderGroup($output);
    }

    public function setTextarea()
    {
        return "<textarea name='note' rows='2' cols='40'></textarea>";
    }

    function countJmlUser($value, $row)
    {
        $jmlUser = $this->ModUsers->getUserGroupCount($row->id_group);
        return $jmlUser;
    }

    function addUpdateRoleAction($value, $row)
    {
        return site_url('users/update-group-role') . '/' . $row->id_group;
    }

    public function updateRole($id_group)
    {
        if ($this->input->post()) {
            $data['roles'] = json_encode($this->input->post('selected_modules'));
            $this->ModUsers->updateUserGroup($id_group, $data);
            redirect('users/group');
            return false;
        }

        $modulesList = $this->acl->getModulesList();
        $userGroupRoles = $this->ModUsers->getUserGroupRole($id_group);
        if(!$userGroupRoles or is_null($userGroupRoles['roles']) or empty($userGroupRoles['roles']) or $userGroupRoles['roles'] == ""){
            $fixedUserGroupRoles = array();
        }else{
            $fixedUserGroupRoles = json_decode($userGroupRoles['roles']);
        }
        $data['userGroupRoles'] = $fixedUserGroupRoles;
        $data['modulesList'] = $modulesList;
        $data['name_group'] = strtoupper($userGroupRoles['name_group']);
        $this->parser->parse('update-role.tpl', $data);
    }
}