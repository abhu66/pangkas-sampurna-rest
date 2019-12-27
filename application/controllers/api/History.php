<?php
    use Restserver\Libraries\REST_Controller;
    defined('BASEPATH') OR exit('No direct script access allowed');
    require APPPATH . 'libraries/REST_Controller.php';
    require APPPATH . 'libraries/Format.php';
    class History extends REST_Controller {
        function __construct()
        {
            parent::__construct();
            $this->load->model('History_model', 'history');

        }
        // Get Data
        public function index_get() {
            $id = $this->get('id');
            // jika id tidak ada (tidak panggil) 
            if($id === null) {
                // maka panggil semua data
                $history = $this->history->getHistory();
                // tapi jika id di panggil maka hanya id tersebut yang akan muncul pada data tersebut
            } else {
                $history = $this->history->getHistory($id);
            }
            if($history) {
                $this->response([
                    'status' => true,
                    'message' => 'data is exist',
                    'data' => $history
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
                if($this->history->deleteHistory($id) > 0) {
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
            $idTask = $this->post('id_task');
            $idnKaryawan = $this->post('idn_karyawan');

            if($idTask !== null && ($idnKaryawan != null || !empty($idnKaryawan) ) ){
                $data = [
                    'id_task' => $this->post('id_task'),
                    'idn_karyawan' => $this->post('idn_karyawan'),
                    'keterangan' => $this->post('keterangan')
                ];
                if ($this->history->createHistory($data) > 0) {
                    $this->response([
                        'status' => true,
                        'message' => 'Trx berhasil disimpan !'
                    ], REST_Controller::HTTP_CREATED);
                } else {
                    $this->response([
                        'status' => false,
                        'message' => 'Trx gagal disimpan !'
                    ], REST_Controller::HTTP_NOT_FOUND);
                }
            }
            else {
                $this->response([
                    'status' => false,
                    'message' => 'Lengkapi data !'
                ], REST_Controller::HTTP_NOT_FOUND);
            }
           
        }
        // // update data
        // public function index_put() {
        //     $id = $this->put('id');
        //     $data = [
        //         'nama' => $this->put('identitas'),
        //         'deskripsi' => $this->put('deskripsi'),
        //         'biaya' => $this->put('biaya')
        //     ];
        //     if ($this->task->updateTask($data, $id) > 0) {
        //         $this->response([
        //             'status' => true,
        //             'message' => 'Update Task berhasil !'
        //         ], REST_Controller::HTTP_NO_CONTENT);
        //     } else {
        //         $this->response([
        //             'status' => false,
        //             'message' => 'Update Task gagal !'
        //         ], REST_Controller::HTTP_BAD_REQUEST);
        //     }
        // }
    }
?>