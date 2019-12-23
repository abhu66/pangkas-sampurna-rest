<?php
    use Restserver\Libraries\REST_Controller;
    defined('BASEPATH') OR exit('No direct script access allowed');
    require APPPATH . 'libraries/REST_Controller.php';
    require APPPATH . 'libraries/Format.php';
    class Task extends REST_Controller {
        function __construct()
        {
            parent::__construct();
            $this->load->model('Task_model', 'task');
        }
        // Get Data
        public function index_get() {
            $id = $this->get('id');
            // jika id tidak ada (tidak panggil) 
            if($id === null) {
                // maka panggil semua data
                $task = $this->task->getTask();
                // tapi jika id di panggil maka hanya id tersebut yang akan muncul pada data tersebut
            } else {
                $task = $this->task->getTask($id);
            }
            if($task) {
                $this->response([
                    'status' => true,
                    'data' => $task
                ], REST_Controller::HTTP_OK); // NOT_FOUND (404) being the HTTP response code
            } else {
                $this->response([
                    'status' => false,
                    'message' => 'id not found'
                ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
            
            }
        }
        // delete data
        public function index_delete() {
            $id = $this->delete('id');
            if($id === null) {
                $this->response([
                    'status' => false,
                    'message' => 'provide an id'
                ], REST_Controller::HTTP_BAD_REQUEST); 
            } else {
                if($this->task->deleteTask($id) > 0) {
                    // Ok
                    $this->response([
                        'status' => true,
                        'id' => $id,
                        'message' => 'deleted success'
                    ], REST_Controller::HTTP_NO_CONTENT);
                } else {
                    // id not found
                    $this->response([
                        'status' => false,
                        'message' => 'id not found'
                    ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
                
                }
            }
        }
        // post data
        public function index_post() {
            $data = [
                'nama' => $this->post('nama'),
                'deskripsi' => $this->post('deskripsi'),
                'biaya' => $this->post('biaya')

            ];
            if ($this->task->createTask($data) > 0) {
                $this->response([
                    'status' => true,
                    'message' => 'Task berhasil ditambahkan !'
                ], REST_Controller::HTTP_CREATED);
            } else {
                $this->response([
                    'status' => false,
                    'message' => 'Task gagal ditambahkan !'
                ], REST_Controller::HTTP_NOT_FOUND);
            }
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