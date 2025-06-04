<?php
class Helloworld extends CI_Controller {
public function index(): string
{
$this->load->model('modelku');
$data=$this->modelku->getData();
$this->load->view('hello', $data);
}
}