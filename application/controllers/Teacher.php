<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Teacher extends CI_Controller
{
    
    public function add_ques_to_existing_test(){
        $this->load->database();
        $tid = $this->input->post('tid');
        $qids = $this->input->post('qids');
        
        $success = 0;
        $added_count = 0;
        $err_msg = null;

        try{
            foreach($qids as $qid){
                //先查询是否存在
                $exist = $this->db->query("select * from ques_included where tid=$tid AND qid=$qid")->row();
                if(!$exist){
                    $this->db->insert('ques_included', [
                        'tid' => $tid,
                        'qid' => $qid
                    ]);
                    $added_count ++;
                }
                
            }
            $success = 1;

        }catch(Exception $e){
            $err_msg = $e->getMessage();
        }

        echo json_encode([
            'token' => [
                'tid' => $tid,
                'qids' => $qids
            ],
            'success' => $success,
            'qid_count' => count($qids),
            'added_count' => $added_count,
            'err_msg' => $err_msg
        ]);
    }

    public function add_ques_to_new_test(){
        $this->load->database();
        $qids = $this->input->post('qids');
        $test_name = $this->input->post('test_name', true);
        $this->load->library('session');
        $teacherAccount = $this->session->UserId;
        $success = 0;
        $err_msg = null;

        try{
            $this->db->insert('test', [
                'name' => $test_name,
                'status' => 0,
                'teacherAccount' => $teacherAccount,
                'timeLimit' => 60
            ]);
            $tid = $this->db->insert_id();
            
            foreach($qids as $qid){
                $this->db->insert('ques_included', [
                    'tid' => $tid,
                    'qid' => $qid
                ]);
            }


            $success = 1;
        }catch(Exception $e){
            $err_msg = $e->getMessage();
        }

        echo json_encode([
            'token' => [
                'qids' => $qids,
                'test_name' => $test_name,
                'teacherAccount' => $teacherAccount
            ],
            'insert_test_id' => $tid,
            'success' => $success,
            'err_msg' => $err_msg
        ]);
    }

    public function update_question(){
        $this->load->database();
        $content = $this->input->post('content', true);
        $choices = $this->input->post('choices', true);
        $qid = $this->input->post('qid');
        $timestamp = date("Y-m-d H:i:s");
        $success = 0;
        $err_msg = null;
        
        try{
            $this->db->where('id', $qid);
            $this->db->update('question', [
                'content' => $content,
                'choices' => json_encode($choices),
                'timestamp' => $timestamp
            ]);
            $success = 1;
        }catch(Exception $e){
            $err_msg = $e->getMessage();
        }

        echo json_encode([
            'token' => [
                'content' => $content,
                'choices' => $choices,
                'qid' => $qid,
                'timestamp' => $timestamp
            ],
            'success' => $success,
            'err_msg' => $err_msg
        ]);

    }


    public function add_test(){
        $this->load->database();
        $name = $this->input->post('name', true);
        $timeLimit = $this->input->post('timeLimit', true);
        $status = $this->input->post('status');
        $subject = $this->input->post('subject', true);
        $show_score = $this->input->post('show_score');
        $this->load->library('session');
        $teacherAccount = $this->session->UserId;
        $success = 0;
        $err_msg = null;

        try{
            $this->db->insert('test', [
                'name' => $name,
                'timeLimit' => $timeLimit,
                'status' => $status,
                'subject' => $subject,
                'show_score' => $show_score,
                'teacherAccount' => $teacherAccount
            ]);
            $success = 1;
        }catch(Exception $e){
            $err_msg = $e->getMessage();
        }

        echo json_encode([
            'token' => [
                'name' => $name,
                'timeLimit' => $timeLimit,
                'status' => $status,
                'subject' => $subject,
                'show_score' => $show_score,
                'teacherAccount' => $teacherAccount
            ],
            'success' => $success,
            'err_msg' => $err_msg
        ]);
    }


    public function update_test(){
        $this->load->database();
        $tid = $this->input->post('tid');
        $name = $this->input->post('name', true);
        $timeLimit = $this->input->post('timeLimit', true);
        $status = $this->input->post('status');
        $subject = $this->input->post('subject', true);
        $show_score = $this->input->post('show_score');
        $timestamp = date("Y-m-d H:i:s");
        $success = 0;
        $err_msg = null;
        
        try{
            $this->db->where('id', $tid);
            $this->db->update('test', [
                'name' => $name,
                'timeLimit' => $timeLimit,
                'status' => $status,
                'subject' => $subject,
                'show_score' => $show_score,
                'timestamp' => $timestamp
            ]);
            $success = 1;
        }catch(Exception $e){
            $err_msg = $e->getMessage();
        }

        echo json_encode([
            'token' => [
                'tid' => $tid,
                'name' => $name,
                'timeLimit' => $timeLimit,
                'status' => $status,
                'subject' => $subject,
                'show_score' => $show_score,
                'timestamp' => $timestamp
            ],
            'success' => $success,
            'err_msg' => $err_msg
        ]);
    }

    public function view_test(){
        $this->load->database();
        $tid = $this->input->post('tid');

        $test = $this->db->query("SELECT * FROM test WHERE id=$tid")->row();
        $question = $this->db->query("SELECT * FROM question WHERE id IN (SELECT qid FROM ques_included WHERE tid=$tid);")->result();

        echo json_encode([
            'token' => [
                'tid' => $tid
            ],
            'test' => $test,
            'question' => $question
        ]);
    }

    public function view_finished_test(){
        $this->load->database();
        $tid = $this->input->post('tid');
        $stuAccount = $this->input->post('stuAccount');

        $test = $this->db->query("SELECT snapshot_test FROM test_history WHERE test_id=$tid AND stuAccount=$stuAccount")->row();
        $question = $this->db->query("SELECT * FROM ques_history WHERE tid=$tid AND stuAccount=$stuAccount;")->result();

        echo json_encode([
            'token' => [
                'tid' => $tid
            ],
            'test' => $test,
            'question' => $question
        ]);
    }

    public function get_test(){
        $this->load->database();
        $tid = $this->input->post('tid');

        $test = $this->db->query("SELECT * FROM test WHERE id=$tid;")->row();
    
        echo json_encode([
            'token' => [
                'tid' => $tid
            ],
            'test' => $test
        ]);
    }

    public function get_question(){
        $this->load->database();
        $qid = $this->input->post('qid');

        $question = $this->db->query("SELECT * FROM question WHERE id=$qid;")->row();
        $question->choices = json_decode($question->choices);
        $question->teacherName = $this->db->query("SELECT name FROM user WHERE account=$question->teacherAccount AND type=1;")->row()->name;
        $this->get_correct_rate_core($question, $qid);

        echo json_encode([
            'token' => [
                'qid' => $qid
            ],
            'question' => $question
        ]);
    }

    public function delete_test_history(){
        $this->load->database();
        $test_history_id = $this->input->post('test_history_id');

        $test_history = $this->db->query("SELECT * FROM test_history WHERE id=$test_history_id")->row();
        //删ques_included
        $this->db->query("DELETE FROM ques_history WHERE tid=$test_history->test_id AND stuAccount=$test_history->stuAccount");
        $ques_history_affected = $this->db->affected_rows();
        //test_history
        $this->db->delete('test_history', [
            'id' => $test_history_id
        ]);
        $test_history_affected = $this->db->affected_rows();

        echo json_encode([
            'token' => [
                'test_history_id' => $test_history_id
            ],
            'ques_history_affected' => $ques_history_affected,
            'test_history_affected' => $test_history_affected
        ]);
    }

    public function delete_test(){
        $this->load->database();
        $tid = $this->input->post('tid');
        $delete_test_history_also = $this->input->post('delete_test_history_also');
        $test_history_affected = 0;
        $ques_history_affected = 0;

        //删test
        $this->db->delete('test', [
            'id' => $tid
        ]);
        $test_affected = $this->db->affected_rows();
        //删ques_included
        $this->db->query("DELETE FROM ques_included WHERE ques_included.tid=$tid");
        $ques_included_affected = $this->db->affected_rows();

        if($delete_test_history_also == 1){
            //删test_history
            $this->db->query("DELETE FROM test_history WHERE test_history.test_id=$tid");
            $test_history_affected = $this->db->affected_rows();

            //删除ques_history
            $this->db->query("DELETE FROM ques_history WHERE ques_history.tid=$tid");
            $ques_history_affected = $this->db->affected_rows();
        }
        
        echo json_encode([
            'token' => [
                'tid' => $tid,
                'delete_test_history_also' => $delete_test_history_also
            ],
            'test_affected' => $test_affected,
            'ques_included_affected' => $ques_included_affected,
            'test_history_affected' => $test_history_affected,
            'ques_history_affected' => $ques_history_affected
        ]);
    }

    public function delete_question(){
        $this->load->database();
        $qid = $this->input->post('qid');

        //question
        $this->db->delete('question', [
            'id' => $qid
        ]);
        $question_affected = $this->db->affected_rows();
        //删ques_included
        $this->db->query("DELETE FROM ques_included WHERE ques_included.qid NOT IN (SELECT id FROM question)");
        $ques_included_affected = $this->db->affected_rows();
        
        echo json_encode([
            'token' => [
                'qid' => $qid
            ],
            'question_affected' => $question_affected,
            'ques_included_affected' => $ques_included_affected
        ]);
    }

    public function remove_a_ques_from_test(){
        $this->load->database();
        $tid = $this->input->post('tid');
        $qid = $this->input->post('qid');

        $this->db->query("DELETE FROM ques_included WHERE tid=$tid AND qid=$qid;");
        $ques_included_affected = $this->db->affected_rows();

        echo json_encode([
            'token' => [
                'tid' => $tid,
                'qid' => $qid
            ],
            'ques_included_affected' => $ques_included_affected
        ]);
    }


    public function loadScores(){
        $this->load->database();
        // $result = $this->db->query("SELECT test_history.id, test_history.test_id, test_history.stuAccount, test_history.status, test_history.finish, test_history.score, user.name AS stuName, test.name AS test_name FROM test_history,user,test WHERE user.account=test_history.stuAccount AND user.type=0 AND test.id=test_history.test_id ORDER BY test_history.id DESC")->result();
        $result = $this->db->query("SELECT test_history.*, user.name AS stuName FROM test_history,user WHERE user.account=test_history.stuAccount AND user.type=0 AND test_history.status=2 ORDER BY id DESC")->result();
        foreach($result as $r){
            $test_info = json_decode($r->snapshot_test);
            $r->test_name = $test_info->name;
        }

        echo json_encode([
            'result' => $result
        ]);
    }


    public function loadTests(){
        $this->load->database();
        $SQL = "SELECT * FROM test ORDER BY id DESC;";
        $result = $this->db->query($SQL)->result();
        foreach($result as $r){
            $tid = $r -> id;
            
            $total = $this->db->query("SELECT COUNT(*) as total FROM ques_included WHERE tid=$tid")->row()->total;
            $r -> q_count =  $total;

            $SQL3 = "SELECT user.account FROM user WHERE user.account in (SELECT ques_history.stuAccount FROM ques_history WHERE tid =$tid) AND user.type=0 ORDER BY id DESC;";
            $res3 = $this->db->query($SQL3)->result();
            $r -> students = $res3;
            $r -> student_count = count($res3);

            $teacherAccount = $r -> teacherAccount;
            $SQL4 = "SELECT name FROM user WHERE type=1 AND account='$teacherAccount'";
            $r -> teacherName = $this->db->query($SQL4)->row()->name;
        }

        echo json_encode([
            'result' => $result
        ]);
    }


    public function loadQues()
    {
        $this->load->database();
        $tid = $this->input->post('tid');

        if($tid == -1){
            $SQL = "SELECT * FROM question ORDER BY id DESC;";
            $result = $this->db->query($SQL)->result();
            $this->get_correct_rate($result);
        }else{
            $SQL = "SELECT * FROM question WHERE question.id IN (SELECT qid FROM ques_included WHERE tid=$tid) ORDER BY id DESC;";
            $result = $this->db->query($SQL)->result();
            $this->get_correct_rate($result);
        }

        $sql3 = "SELECT test.id, test.name FROM test ORDER BY id DESC;";
        $res3 = $this->db->query($sql3)->result();

        echo json_encode([
            'token' => [
                'tid' => $tid
            ],
            'data' => $result,
            'AllQuesSets' => $res3
        ]);
    }

    private function get_correct_rate($result){
        foreach($result as $r){
            $this->get_correct_rate_core($r, $r->id);
        }
    }

    private function get_correct_rate_core($r, $qid){
        $res = $this->db->query("SELECT COUNT(*) as total, SUM(correct) as correct FROM ques_history WHERE qid=$qid")->row();
        $total = $res->total;
        $correct = $res->correct;
        $r->tested_count = $total;
        if($total < 5){
            $r->difficulty = '数据不足';
        }else{
            $r->difficulty = round($correct / $total * 100, 2) . "%";
        }
    }


    public function RecordQues(){
        $this->load->database();
        $content = $this->input->post('content', true);
        $choices = $this->input->post('choices', true);
        $this->load->library('session');
        $UserId = $this->session->UserId;
        
        $success = 0;
        $err_msg = null;

        try{
            $this->db->insert('question', [
                'content' => $content,
                'choices' => json_encode($choices),
                'teacherAccount' => $UserId
            ]);
            $success = 1;
        }catch(Exception $e){
            $err_msg = $e->getMessage();
        }

        echo json_encode([
            'token' => [
                'content' => $content,
                'choices' => $choices,
                'teacherAccount' => $UserId
            ],
            'success' => $success,
            'err_msg' => $err_msg
        ]);
    }

    // public function check(){
    //     //排查重复
    //     $this->load->database();
    //     $ques = $this->db->query("SELECT * FROM ques_included WHERE tid=14")->result();
    //     $SQL = "SELECT * FROM question WHERE question.id IN (SELECT qid FROM ques_included WHERE tid=14) ORDER BY id DESC;";
    //     $inclu = $this->db->query($SQL)->result();
        
    //     $count = 1;
    //     foreach($ques as $r){
    //         $qid = $r->qid;
    //         $row = $this->db->query("SELECT * FROM question WHERE id=$qid")->row();
    //         if($row){
    //             echo ("$count. $qid exist</br>");
    //             $count ++;
    //         }
    //     }

    //     //查看重复
    //     $this->load->database();
    //     $ques = $this->db->query("SELECT * FROM ques_included WHERE tid=14")->result();
    //     foreach($ques as $r){
    //         $qid = $r->qid;
    //         $same_tid_qid = $this->db->query("SELECT * FROM ques_included WHERE tid=14 AND qid=$qid")->result();
    //         $print = [];
    //         foreach($same_tid_qid as $s){
    //             array_push($print, [
    //                 'row_id' => $s->id,
    //                 'tid' => 14,
    //                 'qid' => $qid
    //             ]);
    //         }
            
    //         echo json_encode($print);
    //         echo "</br>";
    //     }

        // 删除重复
        // $this->load->database();
        // $ques = $this->db->query("SELECT * FROM ques_included WHERE tid=14")->result();
        // foreach($ques as $r){
        //     $qid = $r->qid;
        //     $same_tid_qid = $this->db->query("SELECT * FROM ques_included WHERE tid=14 AND qid=$qid")->result();
        //     $key = 0;
        //     foreach($same_tid_qid as $s){
        //         if($key > 0){
        //             $this->db->delete('ques_included', [
        //                 'id' => $s->id
        //             ]);
        //         }else{
        //             $key ++;
        //         }
        //     }
        // }
        // echo "finished";
    // }
}
