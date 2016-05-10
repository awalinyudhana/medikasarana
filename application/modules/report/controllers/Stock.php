<?php
/**
 * Created by PhpStorm.
 * User: Lin
 * Date: 7/30/2015
 * Time: 10:57 AM
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Stock extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->acl->auth('report_stock');
        $this->load->model('ModStock');
    }

    public function index()
    {
        $data['items'] = $this->ModStock->get();
        $this->parser->parse("stock.tpl", $data);
    }
}