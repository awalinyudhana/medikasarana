<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->acl->auth('product');
        $this->load->library('grocery_CRUD');
        $this->load->model('ModProduct');
    }

    public function render($output)
    {
        $this->parser->parse('index.tpl', $output);
    }

    public function index($id_product = null)
    {
        $crud = new grocery_CRUD();
        // if (!empty($id_product) && is_numeric($id_product)) {
        //     $crud->where('product.parent', $id_product)
        //         ->unset_read()
        //         ->unset_add()
        //         ->unset_edit()
        //         ->unset_delete();
        // } else {
        //     $crud->add_action('Lihat Sub Produk', '', '', 'read-icon', array($this, 'addSubProductAction'));
        // }

        // $state = $crud->getState();
        // $state_info = $crud->getStateInfo();
        // if ($state == 'add') {
        //     $productParentField = $this->ModProduct->getProductOnlyForDropdown();
        //     $crud->field_type('parent', 'dropdown', $productParentField);
        // }

        $crud->set_table('product')
            ->columns('barcode', 'name', 'id_product_category', 'id_product_unit', 'brand', 'sell_price', 'date_expired', 'size', 'license', 'stock', 'minimum_stock')
            ->display_as('id_product_category', 'Product Category')
            ->display_as('id_product_unit', 'Product Satuan')
            ->display_as('date_expired', 'Date Expired')
            ->display_as('license', 'AKL/AKD')
            ->display_as('minimum_stock', 'Minimum Stock')
            ->display_as('value', 'Nilai Satuan')
            ->callback_column('sell_price', array($this, 'currencyFormat'))
            ->set_relation('id_product_category', 'product_category', 'category')
            ->set_relation('id_product_unit', 'product_unit', '{unit} / {value}')
            ->fields('barcode', 'id_product_category', 'parent', 'name', 'brand', 'id_product_unit', 'size', 'date_expired', 'license', 'minimum_stock')
            ->required_fields('id_product_category', 'name', 'brand', 'id_product_unit', 'minimum_stock')
            ->unset_fields('weight', 'length', 'width', 'height', 'sell_price', 'stock')
            // ->callback_edit_field('parent', array($this, 'setProductParentField'))
            ->callback_field('parent', array($this, 'setProductParentField'))
            ->callback_field('id_product_category', array($this, 'productCategoryField'))
//            ->unique_fields('barcode')
            ->unset_read();

        $output = $crud->render();

        $this->render($output);
    }

    public function currencyFormat($value, $row)
    {
        return "Rp " . number_format($value);
    }

    function addSubProductAction($value, $row)
    {
        return site_url('product/index') . '/' . $row->id_product;
    }

    function setProductParentField($value, $primary_key)
    {
        $productField = $this->ModProduct->getProductOnlyForDropdown();

        $html = '<link type="text/css" rel="stylesheet" href="'.base_url().'/assets/grocery_crud/css/jquery_plugins/chosen/chosen.css" />';
        $html .= '<script src="'.base_url().'/assets/grocery_crud/js/jquery_plugins/jquery.chosen.min.js"></script>';
        $html .= '<script src="'.base_url().'/assets/grocery_crud/js/jquery_plugins/config/jquery.chosen.config.js"></script>';

        $html.= "<div><select name='id_product' class='chosen-select' data-placeholder='Pilih Produk' style='width:500px;'>";
        $html.= '<option value=""></option>';

        foreach ($categories as $row) {
            if ($value == $row['id_product']) {
                $html.= "<option value='$row['id_product']' selected>$row['name']</option>";
            } else {
                $html.= "<option value='$row['id_product']'>$row['name']</option>";
            }
        }
        // foreach ($productField as $key => $forvalue) {
        //     if ($key == $value) {
        //         $html.= "<option value='$key' selected>$forvalue</option>";
        //     } else {
        //         $html.= "<option value='$key'>$forvalue</option>";
        //     }
        // }
        $html.= '</select></div>';
        return $html;
        // return form_dropdown('id_product', $productField, $value);
    }

    public function category($action = null, $id_product_category = null)
    {
        $this->session->set_userdata('selected_table', 'product_category');
        $crud = new grocery_CRUD();
        if (!empty($id_product_category) && is_numeric($id_product_category) && $action == 'parent') {
            $crud->where('parent', $id_product_category)
                ->unset_add()
                ->unset_edit()
                ->unset_delete();
        } else {
            $crud->add_action('Lihat Sub Produk Kategori', '', '', 'read-icon', array($this, 'addSubCategoryAction'));
        }

        $crud->set_table('product_category')
            ->columns('category', 'parent', 'note')
            ->fields('category', 'parent', 'note')
            ->required_fields('category')
            ->display_as('category', 'Nama Kategori')
//                ->callback_add_field('category', array($this, 'setPrefixCode'))
            ->callback_field('note', array($this, 'setTextarea'))
//                ->callback_add_field('prefix_code', array($this, 'disablePrefixCode'))
//                ->callback_edit_field('prefix_code', array($this, 'disablePrefixCode'))
            // ->callback_before_insert(array($this, 'checkPrefixCode'))
            ->callback_field('parent', array($this, 'categoryParentField'))
            ->callback_column('parent', array($this, 'categoryParentName'))
            ->unset_read()
            ->unset_delete();

        $output = $crud->render();
        $this->render($output);
    }

    public function categoryParentName($value, $row)
    {
        $categoriesName = $this->ModProduct->getcategoryName($row->parent);
        return $categoriesName;
    }

    public function categoryParentField($value = '', $primary_key = null)
    {
        $categories = $this->ModProduct->getAvailableCategoryParent($primary_key);


        $html = '<link type="text/css" rel="stylesheet" href="'.base_url().'/assets/grocery_crud/css/jquery_plugins/chosen/chosen.css" />';
        $html .= '<script src="'.base_url().'/assets/grocery_crud/js/jquery_plugins/jquery.chosen.min.js"></script>';
        $html .= '<script src="'.base_url().'/assets/grocery_crud/js/jquery_plugins/config/jquery.chosen.config.js"></script>';

        $html.= "<div><select name='parent' class='chosen-select' data-placeholder='Pilih Categori' style='width:500px;'>";
        $html.= '<option value=""></option>';

        foreach ($categories as $row) {
            if (!empty($value) && $value == $row['id_product_category']) {
                $html.= "<option value='".$row['id_product_category']."' selected>".$row['category']."</option>";
            } else {
                $html.= "<option value='".$row['id_product_category']."'>".$row['category']."</option>";
            }
        }
        $html.= '</select></div>';
        return $html;

        /*
        $text = '<select id="field-parent" name="parent" class="chosen-select chzn-done" data-placeholder="Select Parent" style="width: 300px;"><option value="">Select Parent</option>';
        foreach ($categories as $row) {
            if (!empty($value) && $value == $row['id_product_category']) {
                $text .= '<option value="' . $row['id_product_category'] . '" selected>' . $row['category'] . '</option>';
            } else {
                $text .= '<option value="' . $row['id_product_category'] . '">' . $row['category'] . '</option>';
            }
            // $text .= '<option value="' . $row['id_product_category'] . '">' . $row['category'] . '-' . $value . '-' . $row['parent'] .'</option>';
        }
        $text .= '</select>';
        return $text;*/
    }

    public function productCategoryField($value = '', $primary_key = null)
    {


        $categories = $this->ModProduct->getCategoryProductOnly();

        $html = '<link type="text/css" rel="stylesheet" href="'.base_url().'/assets/grocery_crud/css/jquery_plugins/chosen/chosen.css" />';
        $html .= '<script src="'.base_url().'/assets/grocery_crud/js/jquery_plugins/jquery.chosen.min.js"></script>';
        $html .= '<script src="'.base_url().'/assets/grocery_crud/js/jquery_plugins/config/jquery.chosen.config.js"></script>';

        $html.= "<div><select name='id_product_category' class='chosen-select' data-placeholder='Pilih Categori' style='width:500px;'>";
        $html.= '<option value=""></option>';

        foreach ($categories as $row) {
            if (!empty($value) && $value == $row['id_product_category']) {
                $html.= "<option value='".$row['id_product_category']."' selected>".$row['category']."</option>";
            } else {
                $html.= "<option value='".$row['id_product_category']."'>".$row['category']."</option>";
            }
        }
        $html.= '</select></div>';
        return $html;

        /*
        $text = '<select id="field-parent" name="parent" class="chosen-select chzn-done" data-placeholder="Select Parent" style="width: 300px;"><option value="">Select Parent</option>';
        foreach ($categories as $row) {
            if (!empty($value) && $value == $row['id_product_category']) {
                $text .= '<option value="' . $row['id_product_category'] . '" selected>' . $row['category'] . '</option>';
            } else {
                $text .= '<option value="' . $row['id_product_category'] . '">' . $row['category'] . '</option>';
            }
            // $text .= '<option value="' . $row['id_product_category'] . '">' . $row['category'] . '-' . $value . '-' . $row['parent'] .'</option>';
        }
        $text .= '</select>';
        return $text;*/
    }

    function addSubCategoryAction($value, $row)
    {
        return site_url('product/category/parent') . '/' . $row->id_product_category;
    }

    public function unit()
    {
        $this->session->set_userdata('selected_table', 'product_unit');
        $crud = new grocery_CRUD();
        $crud->set_table('product_unit')
            ->display_as('unit', 'Satuan')
            ->columns('unit', 'value', 'note')
            ->fields('unit', 'value', 'note')
            ->unset_delete()
            ->required_fields('unit', 'value')
            // ->display_as('prefix_code', 'Prefix Code')
//                ->callback_add_field('unit', array($this, 'setPrefixCode'))
            ->callback_field('note', array($this, 'setTextarea'))
//                ->callback_add_field('prefix_code', array($this, 'disablePrefixCode'))
//                ->callback_edit_field('prefix_code', array($this, 'disablePrefixCode'))
//            ->callback_before_insert(array($this, 'checkPrefixCode'))
            ->unset_read();
        $output = $crud->render();
        $this->render($output);
    }

    public function setPrefixCode($value = '', $primary_key = null)
    {
        if ($this->session->userdata('selected_table') == 'product_category') {
            return "<input type='text' name='category' class='insertCategoryPrefixCode' />";
        } else if ($this->session->userdata('selected_table') == 'product_unit') {
            return "<input type='text' name='unit' class='insertUnitPrefixCode' />";
        }

    }

    public function disablePrefixCode($value = '', $primary_key = null)
    {
        return "<input type='text' disabled name='disabled_prefix_code' value='$value' /><input type='hidden' name='prefix_code' value='$value' />";
    }

    public function setTextarea($value, $row)
    {
        return "<textarea name='note' rows='2' cols='40'>$value</textarea>";
    }

    public function checkPrefixCode($post_array, $table_name)
    {
        $selected_table = $this->session->userdata('selected_table');

        if ($selected_table == 'product_category') {
            $field_name = strtoupper(preg_replace('/\s+/', '', $post_array['category']));
            $length = 2;
        } else if ($selected_table == 'product_unit') {
            $field_name = strtolower(preg_replace('/\s+/', '', $post_array['unit']));
            $length = 3;
        }

        $prefix_code = substr($field_name, 0, $length);
        $post_array['prefix_code'] = $prefix_code;

        $prefix_code_status = $this->ModProduct->checkPrefixCode($prefix_code, $selected_table);

        while ($prefix_code_status) {
            $new_prefix_code = $this->generatePrefixCode($field_name, $length);
            $post_array['prefix_code'] = $new_prefix_code;
            $prefix_code_status = $this->ModProduct->checkPrefixCode($new_prefix_code, $selected_table);
        }

        return $post_array;
    }

    public function generatePrefixCode($field_name, $length)
    {
        $first_character = substr($field_name, 0, 1);
        $rest_character = substr($field_name, 1, strlen($field_name));

        $randomString = substr(str_shuffle($rest_character), 0, ($length - 1));

        return $first_character . $randomString;
    }

    public function completeReport()
    {
        $crud = new grocery_CRUD();
        $crud->set_table('product')
            ->columns('name')
            ->columns('category_parent', 'id_product_category', 'name')
            ->display_as('category_parent', 'Parent Kategori')
            ->display_as('id_product_category', 'Kategori Produk')
            ->display_as('name', 'Nama Produk')
            ->set_relation('id_product_category', 'product_category', 'category')
            ->callback_column('category_parent', array($this, 'getCategoryParentName'))
            ->unset_operations();
        $output = $crud->render();
        $this->render($output);
    }

    function getCategoryParentName($value, $row)
    {
        return $this->ModProduct->getCategoryParentName($row->id_product_category);
    }
} 