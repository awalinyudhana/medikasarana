<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Warehouse extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->acl->auth('warehouse');
        $this->load->library('grocery_CRUD');
    }

    public function render($output)
    {
 		 $this->parser->parse('index.tpl',$output);
    }

    public function index()
    {
        $crud = new grocery_CRUD();
 
        $crud->set_table('warehouse')
                ->display_as('zipcode', 'Zip Code')
                ->required_fields('name', 'address', 'zipcode', 'city', 'state', 'country', 'telp')
                ->unset_read()
                ->unset_add()
                ->unset_delete()
                ->callback_add_field('note', array($this, 'setTextarea'));
        $output = $crud->render();
        $this->render($output);
    }

    public function rack()
    {
    	$crud = new grocery_CRUD();
    	$crud->set_table('warehouse_rack')
                ->columns('name', 'parent')
                ->display_as('id_warehouse', 'Nama Warehouse')
                ->display_as('name', 'Rack Name')
                ->display_as('parent', 'Rack Parent')
                ->required_fields('name')
                ->set_relation('parent', 'warehouse_rack', 'name')
                ->unset_fields('length', 'width', 'height', 'weight')
                ->field_type('id_warehouse', 'invisible')
                ->callback_before_insert(array($this, 'addWarehouseID'))
                ->unset_read();
    	$output = $crud->render();
        $this->render($output);
    }

    function addWarehouseID($post_array)
    {
        $post_array['id_warehouse'] = 1;
        return $post_array;
    }

    public function productPlacing()
    {
        $crud = new grocery_CRUD();
        $crud->set_table('warehouse_rack_detail')
                ->display_as('id_rack', 'Rack Name')
                ->display_as('id_product', 'Product Name')
                ->columns('id_rack', 'id_product', 'stock')
                ->set_relation('id_rack', 'warehouse_rack', 'name')
                ->set_relation('id_product', 'product', 'name')
                ->unset_fields('total')
                ->callback_column('stock', array($this, 'addProductStockColumn'))
                ->required_fields('id_rack', 'id_product')
                ->unset_read();
        $output = $crud->render();
        $this->render($output);
    }

    public function setTextarea()
    {
        return "<textarea name='note' rows='2' cols='40'></textarea>";
    }

    public function addProductStockColumn($value, $row)
    {
        $this->load->model('ModWarehouse');
        $product_stock = $this->ModWarehouse->getProductStock($row->id_product);
        return $product_stock;
    }
} 