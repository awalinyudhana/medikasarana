<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Warehouse extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->acl->auth('warehouse');
        $this->load->library('grocery_CRUD');
        $this->load->model('ModWarehouse');
    }

    public function render($output)
    {
        $this->parser->parse('index.tpl', $output);
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
//        $this->render($output);
        $this->parser->parse('rack.tpl', $output);
    }

    function addWarehouseID($post_array)
    {
        $post_array['id_warehouse'] = 1;
        return $post_array;
    }

    public function placing()
    {
        $crud = new grocery_CRUD();

        $state = $crud->getState();
        if ($state == 'add') {
            $productField = $this->ModWarehouse->getProductOnlyForDropdown();
            $crud->field_type('id_product', 'dropdown', $productField);
        } else {
            $crud->set_relation('id_product', 'product', 'name');
        }

        $crud->set_table('warehouse_rack_detail')
            ->display_as('id_rack', 'Nama Rak')
            ->display_as('id_product', 'Nama Produk')
            ->display_as('stock', 'Stok')
            ->display_as('satuan', 'Produk Satuan')
            ->columns('id_rack', 'parent', 'id_product', 'satuan', 'stock')
            ->set_relation('id_rack', 'warehouse_rack', 'name')
            ->unset_fields('total')
            ->unset_add_fields('parent')
            ->unset_edit_fields('parent')
            ->callback_column('stock', array($this, 'addProductStockColumn'))
            ->callback_column('satuan', array($this, 'setProdukSatuan'))
            ->callback_column('parent', array($this, 'setParentRack'))
            ->required_fields('id_rack', 'id_product')
            ->callback_edit_field('id_product', array($this, 'setProductField'))
            ->unset_read();
        $output = $crud->render();
//        $this->render($output);
        $this->parser->parse('placing.tpl', $output);
    }

    public function setTextarea($value, $row)
    {
        return "<textarea name='note' rows='2' cols='40'>$value</textarea>";
    }

    public function addProductStockColumn($value, $row)
    {
        $product_stock = $this->ModWarehouse->getProductStock($row->id_product);
        return $product_stock;
    }

    public function setProdukSatuan($value, $row)
    {
        $productUnitData = $this->ModWarehouse->getProductUnitData($row->id_product);
        if ($productUnitData) {
            return $productUnitData->unit . ' / ' . $productUnitData->value;
        } else {
            return 'N/A';
        }
    }

    public function setParentRack($value, $row){
            return $this->ModWarehouse->getNameRackParent($row->id_product);
    }

    public function setProductField($value, $primary_key)
    {
        $productField = $this->ModWarehouse->getProductOnlyForDropdown($value);

        $html = '<link type="text/css" rel="stylesheet" href="' . base_url() . '/assets/grocery_crud/css/jquery_plugins/chosen/chosen.css" />';
        $html .= '<script src="' . base_url() . '/assets/grocery_crud/js/jquery_plugins/jquery.chosen.min.js"></script>';
        $html .= '<script src="' . base_url() . '/assets/grocery_crud/js/jquery_plugins/config/jquery.chosen.config.js"></script>';

        $html .= "<div><select name='id_product' class='chosen-select' data-placeholder='Pilih Produk' style='width:500px;'>";
        $html .= '<option value=""></option>';

        foreach ($productField as $key => $forvalue) {
            if ($key == $value) {
                $html .= "<option value='$key' selected>$forvalue</option>";
            } else {
                $html .= "<option value='$key'>$forvalue</option>";
            }
        }
        $html .= '</select></div>';
        return $html;
        // return form_dropdown('id_product', $productField, $value);
    }
} 