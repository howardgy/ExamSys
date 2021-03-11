<?php
defined('BASEPATH') or exit('No direct script access allowed');

class StuInfo extends CI_Controller
{
    public function index()
    {
        $this->load->database();
        $this->load->library('session');
        $UserId = $this->session->UserId;

        $SQL1 = "SELECT test_history.start, test_history.status, test_history.score, test.id, test.name, test.subject, test.show_score FROM test_history,test WHERE test_history.stuAccount=$UserId AND test_history.test_id=test.id ORDER BY test_history.start DESC";
        $res = $this->db->query($SQL1)->result();

        echo json_encode([
            'data' => $res
        ]);
    }

    public function getOpenTests(){
        // 显示的是题集
        $this->load->database();
        $SQL = "SELECT id, name FROM test WHERE status=1;";
        $result = $this->db->query($SQL)->result();
        echo json_encode($result);
    }

}
