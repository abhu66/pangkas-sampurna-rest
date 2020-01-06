<?php
    use Restserver\Libraries\REST_Controller;
    defined('BASEPATH') OR exit('No direct script access allowed');
    require APPPATH . 'libraries/REST_Controller.php';
    require APPPATH . 'libraries/Format.php';
    class History extends CI_Controller {
        function __construct()
        {
            parent::__construct();
            $this->load->model('History_model', 'history');
            $this->load->helper('date');

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
        public function add() {
            $idnKaryawan = $this->input->post('idn_karyawan');
            $namaTask    = $this->input->post('nama');
            $keterangan  = $this->input->post('keterangan');
    
            if($this->history->createHistory($idnKaryawan,$namaTask,$keterangan,date('Y-m-d H:i:s'))){
                    $data['error'] = false;
                    $data['error_message'] ="-";
                    $data['now'] = date('Y-m-d H:i:s');
                } else {
                    $data['error'] = true;
                    $data['error_message'] ="Tambah data history gagal !";
                    $data['now'] = date('Y-m-d H:i:s');
                }
                $this->output->set_output(json_encode($data))->_display();
                exit;
           
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