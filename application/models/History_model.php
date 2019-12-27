<?php
    class History_model extends CI_model {
        public function getHistory($id = null) {
            if($id === null) {
                return $this->db->get('history')->result_array(); 
            } else {
                return $this->db->get_where('history', ['id' => $id])->result_array();
            }
        }
        public function deleteHistory($id) {
            $this->db->delete('history', ['id' => $id]);
            return $this->db->affected_rows();
        }
        public function createHistory($data) {
            $this->db->insert('history', $data);
            return $this->db->affected_rows();
        } 
        // public function updateTask($data, $id) {
        //     $this->db->update('task', $data, ['id' => $id]);
        //     return $this->db->affected_rows();
        // }
    }
?>