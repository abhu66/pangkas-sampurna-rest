<?php
    class Task_model extends CI_model {
        public function getTask($id = null) {
            
            if($id == null || $id == "") {
                return  $this->db->query("SELECT id,nama,deskripsi,biaya FROM Task")->result();
            } else {
                return $this->db->query("SELECT id,nama,deskripsi,biaya FROM Task WHERE id = '$id'")->result();
            }
        }

        public function deleteTask($id) {
            $this->db->delete('task', ['id' => $id]);
            return $this->db->affected_rows();
        }
        public function createTask($nama,$deskripsi,$biaya) {
            $query ="insert into Task values('','$nama','$deskripsi','$biaya')";
            return $this->db->query($query);
        } 
        public function updateTask($data, $id) {
           
        }
    }
?>