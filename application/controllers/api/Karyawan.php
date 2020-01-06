<?php
    use Restserver\Libraries\REST_Controller;
    defined('BASEPATH') OR exit('No direct script access allowed');
    require APPPATH . 'libraries/REST_Controller.php';
    require APPPATH . 'libraries/Format.php';
    class Karyawan extends CI_Controller {
        function __construct()
        {
            parent::__construct();
            $this->load->model('Karyawan_model', 'karyawan');
            $this->output->set_content_type('application/json','utf-8');
        }
        // Get Data
        public function index_get() {
            $id = $this->get('id');
            // jika id tidak ada (tidak panggil) 
            if($id === null) {
                // maka panggil semua data
                $karyawan = $this->karyawan->getKaryawan();
                // tapi jika id di panggil maka hanya id tersebut yang akan muncul pada data tersebut
            } else {
                $karyawan = $this->karyawan->getKaryawan($id);
            }
            if($karyawan) {
                $this->response([
                    'status' => true,
                    'data' => $karyawan
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
                if($this->karyawan->deleteKaryawan($id) > 0) {
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
        // public function index_post() {
        //     $data = [
        //         'identitas' => $this->post('identitas'),
        //         'nama' => $this->post('nama'),
        //         'email' => $this->post('email'),
        //         'password' => $this->post('password'),
        //         'hp' => $this->post('hp')

        //     ];
        //     if ($this->karyawan->createKaryawan($data) > 0) {
        //         $this->response([
        //             'status' => true,
        //             'message' => 'Karyawan berhasil ditambahkan !'
        //         ], REST_Controller::HTTP_CREATED);
        //     } else {
        //         $this->response([
        //             'status' => false,
        //             'message' => 'Karyawan gagal ditambahkan !'
        //         ], REST_Controller::HTTP_NOT_FOUND);
        //     }
        // }
        // update data
        public function index_put() {
            $id = $this->put('id');
            $data = [
                'identitas' => $this->put('identitas'),
                'nama' => $this->put('nama'),
                'email' => $this->put('email'),
                'password' => $this->put('password'),
                'hp' => $this->put('hp')
            ];
            if ($this->karyawan->updateKaryawan($data, $id) > 0) {
                $this->response([
                    'status' => true,
                    'message' => 'Update Karyawan berhasil !'
                ], REST_Controller::HTTP_NO_CONTENT);
            } else {
                $this->response([
                    'status' => false,
                    'message' => 'Update Karyawan gagal !'
                ], REST_Controller::HTTP_BAD_REQUEST);
            }
        }

        public function loginKaryawan(){
            $username  = $this->input->post('username');
            $password  = $this->input->post('password');
            $karyawan  = $this->karyawan->loginProses($username,$password);
            if($karyawan){
                $data['error'] = false;
                $data['error_message'] = 'Karyawan ditemukan !';
            }
            else {
                $data['error'] = true;
                $data['error_message'] = 'Karyawan tidak ditemukan !';
            }
            $data['karyawan'] = $karyawan;
            $this->output->set_output(json_encode($data))->_display();
            exit;
        }
    }
?>