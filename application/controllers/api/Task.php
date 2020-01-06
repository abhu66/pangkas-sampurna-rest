<?php
    use Restserver\Libraries\REST_Controller;
    defined('BASEPATH') OR exit('No direct script access allowed');
    require APPPATH . 'libraries/REST_Controller.php';
    require APPPATH . 'libraries/Format.php';
    class Task extends CI_Controller {
        function __construct()
        {
            parent::__construct();
            $this->load->model('Task_model', 'task');
            $this->output->set_content_type('application/json','utf-8');
        }

        public function getAllTask(){
            $id  = $this->input->post('id');
            $tasks  = $this->task->getTask($id);
            if($tasks){
                $data['error'] = false;
                $data['error_message'] = '-';
            }
            else {
                $data['error'] = true;
                $data['error_message'] = 'terjadi kesalahan';
            }
            $data['tasks'] = $tasks;
            $this->output->set_output(json_encode($data))->_display();
            exit;
        }

        // post data
        public function add() {
            //var_dump($this->post('nama')); exit;
            $nama = $this->input->post('nama');
            $deskripsi = $this->input->post('deskripsi');
            $biaya = $this->input->post('biaya');
            
            if($this->task->createTask($nama,$deskripsi,$biaya)){
                $data['error'] = false;
                $data['error_message'] ="-";
            } else {
                $data['error'] = true;
                $data['error_message'] ="Tambah data Task gagal !";
            }
            $this->output->set_output(json_encode($data))->_display();
            exit;
            
        }
        // update data
        public function index_put() {
            $id = $this->put('id');
            $data = [
                'nama' => $this->put('identitas'),
                'deskripsi' => $this->put('deskripsi'),
                'biaya' => $this->put('biaya')
            ];
            if ($this->task->updateTask($data, $id) > 0) {
                $this->response([
                    'status' => true,
                    'message' => 'Update Task berhasil !'
                ], REST_Controller::HTTP_NO_CONTENT);
            } else {
                $this->response([
                    'status' => false,
                    'message' => 'Update Task gagal !'
                ], REST_Controller::HTTP_BAD_REQUEST);
            }
        }
    }
?>