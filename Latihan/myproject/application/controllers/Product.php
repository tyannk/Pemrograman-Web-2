<?php

use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xls;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx as WriterXlsx;

require 'vendor/autoload.php';

class Product extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('product_model');
    }
    function index()
    {
        $data['product'] = $this->product_model->get_product();
        $this->load->view('product_view', $data);
    }
    function add_new()
    {
        $this->load->view('add_product_view');
    }
    function save()
    {
        $product_name = $this->input->post('product_name');
        $product_price = $this->input->post('product_price');
        $this->product_model->save($product_name, $product_price);
        redirect('product');
    }
    function delete()
    {
        $product_id = $this->uri->segment(3);
        $this->product_model->delete($product_id);
        redirect('product');
    }
    function get_edit()
    {
        $product_id = $this->uri->segment(3);
        $result = $this->product_model->get_product_id($product_id);
        if ($result->num_rows() > 0) {
            $i = $result->row_array();
            $data = array(
                'product_id' => $i['product_id'],
                'product_name' => $i['product_name'],
                'product_price' => $i['product_price']
            );
            $this->load->view('edit_product_view', $data);
        } else {
            echo "Data Was Not Found";
        }
    }
    function update()
    {
        $product_id = $this->input->post('product_id');
        $product_name = $this->input->post('product_name');
        $product_price = $this->input->post('product_price');
        $this->product_model->update($product_id, $product_name, $product_price);
        redirect('product');
    }
    public function export()
    {
        $this->load->model('Product_model');
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'product_id');
        $sheet->setCellValue('B1', 'product_name');
        $sheet->setCellValue('C1', 'product_price');

        $x = 2;
        foreach ($this->product_model->eksport_data() as $row) {
            $sheet->setCellValue('A' . $x, $row->product_id);
            $sheet->setCellValue('B' . $x, $row->product_name);
            $sheet->setCellValue('C' . $x, $row->product_price);
            $x++;
        }
        $writer = new WriterXlsx($spreadsheet);
        $filename = 'laporan-product';

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }
}
