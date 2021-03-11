<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Test extends CI_Controller
{
    public function set_mark(){
        $this->load->library('session');
        $this->load->database();
        $marked = $this->input->post('marked', true);
        $tid = $this->input->post('tid');
        $qid = $this->input->post('qid');
        $stuAccount = $_SESSION['UserId'];
        $result = 0;
        $marks = []; //更新box的标记
        $err_msg = null;
        
        try{
            $this->db->where('tid', $tid);
            $this->db->where('qid', $qid);
            $this->db->where('stuAccount', $stuAccount);
            $this->db->update('ques_history', [
                'marked' => $marked
            ]);
            $result = 1;

            $marks_res = $this->db->query("SELECT qid, marked FROM ques_history WHERE tid=$tid AND stuAccount=$stuAccount")->result();
            foreach($marks_res as $m){
                array_push($marks, [
                    'qid' => $m -> qid,
                    'marked' => $m -> marked
                ]);
            }
        }catch(Exception $e){
            $err_msg = $e->getMessage();
        }

        echo json_encode([
            'token' => [
                'marked' => $marked,
                'tid' => $tid,
                'qid' => $qid,
                'stuAccount' => $stuAccount
            ],
            'result' => $result,
            'marks' => $marks,
            'err_msg' => $err_msg,
        ]);
    }

    public function startTest()
    {
        $this->load->database();
        $stuAccount = $this->input->post('stuAccount');
        $test_id = $this->input->post('test_id');
        $result = 0;
        $err_msg = null;

        try{
            $data = array(
                'test_id' => $test_id,
                'stuAccount' => $stuAccount
            );
            $this->db->insert('test_history', $data);


            $result = 1;
        }catch(Exception $e){
            $err_msg = $e->getMessage();
        }

        echo json_encode([
            'token' => [
                'stuAccount' => $stuAccount,
                'test_id' => $test_id
            ],
            'result' => $result,
            'err_msg' => $err_msg
        ]);
    }

    public function AquireQues(){
        $stuAccount = $this->input->post('stuAccount');
        $test_id = $this->input->post('test_id');
        $this->AquireQues_core($stuAccount, $test_id);
    }

    private function AquireQues_core($stuAccount, $test_id){
        $this->load->database();
        $already_done = [];
        $ques_all= [];
        $ques_left = [];
        $percentage = null;
        $next_question = null;
        $undone = false;
        $msg = null;
        $next_question_order = null;
        $undone_marked = 0;
        $marks = [];
        
        //$already_done_res = $this->db->query("SELECT qid FROM ques_history WHERE ")->result();
        
        //获取已做、未做、百分比
        //已做
        $already_done_res = $this->db->query("SELECT qid FROM ques_history WHERE tid=$test_id AND stuAccount=$stuAccount AND status=1")->result();
        foreach($already_done_res as $a){
            array_push($already_done, $a->qid);
        }
        $already_done_str = implode(',', $already_done);
        //全部
        $ques_all_res = $this->db->query("SELECT qid FROM ques_included WHERE tid=$test_id")->result();
        foreach($ques_all_res as $a){
            array_push($ques_all, $a->qid);
        }
        //剩下
        $ques_left_res = $this->db->query("SELECT qid FROM ques_included WHERE tid=$test_id AND qid NOT IN (SELECT qid FROM ques_history WHERE tid=$test_id AND stuAccount=$stuAccount AND status=1)")->result();
        foreach($ques_left_res as $l){
            array_push($ques_left, $l->qid);
        }
        if(count($ques_left_res) > 0)
        
        if(count($already_done) == 0 || count($ques_all) == 0){
            $percentage = "0";
        }else{
            $percentage = round(count($already_done) / count($ques_all) * 100, 2);
        }
        //marks
        $marks_res = $this->db->query("SELECT qid, marked FROM ques_history WHERE tid=$test_id AND stuAccount=$stuAccount")->result();
        foreach($marks_res as $m){
            array_push($marks, [
                'qid' => $m -> qid,
                'marked' => $m -> marked
            ]);
        }


        $undone_row = $this->db->query("SELECT qid,marked FROM ques_history WHERE tid=$test_id AND stuAccount=$stuAccount AND status=0")->row();
        if($undone_row){
            //有处于status=0的题，恢复
            $undone = true;
            $undone_marked = $undone_row->marked;
            $next_question = $this->getQuestion($undone_row->qid, $test_id, $stuAccount, $undone);
            $next_question_order = count($already_done) + 1;
            $msg = 'generated';
        }else{
            //都答了，显示新题
            if(count($already_done) == 0){
                //没做过
                if(count($ques_left) == 0){
                    //题库没有题，报错
                    $msg = 'Test set is empty';
                }else{
                    //随机抽第一题
                    shuffle($ques_all);
                    $next_question = $this->getQuestion($ques_all[0], $test_id, $stuAccount, $undone);
                    $next_question_order = count($already_done) + 1;
                    $msg = 'generated';
                }
            }else{
                if(count($ques_left) == 0){
                    //报已做完
                    $msg = 'finished';
                    $percentage = '100';
                }else{
                    //随机抽下一题
                    shuffle($ques_left);
                    $next_question = $this->getQuestion($ques_left[0], $test_id, $stuAccount, $undone);
                    $next_question_order = count($already_done) + 1;
                    $msg = 'generated';
                }
            }
        }
        $ques_left_R = $ques_left;
        array_splice($ques_left_R, 0, 1);
        
        //看有没有历史中处于0状态的题
            //有则直接恢复这题
            //没有
                //获取已经做的题id：1，2，3，
                    //从所有题中，排除这些题
                        //如果没有了，则返回没有，问要不要交卷
                        //随机挑选一题
                //如果是没有，则直接开始随机挑选一题

        echo json_encode([
            'token' => [
                'stuAccount' => $stuAccount,
                'test_id' => $test_id
            ],
            'already_done' => $already_done,
            'ques_all' => $ques_all,
            'ques_left' => $ques_left,
            'ques_left_R' => $ques_left_R, //without current
            'percentage' => $percentage,
            'undone' => $undone,
            'msg' => $msg,
            'next_question' => $next_question,
            'next_question_order' => $next_question_order,
            'undone_marked' => $undone_marked,
            'marks' => $marks
        ]);
    }

    public function updateAnswer(){
        $this->load->database();
        $history_id = $this->input->post('history_id');
        $stuChoice = $this->input->post('stuChoice');
        $correct = $this->input->post('correct');
        $timestamp = date("Y-m-d H:i:s");
        $success = 0;
        $err_msg = null;
        
        try{
            $this->db->where('id', $history_id);
            $this->db->update('ques_history', [
                'stuChoice' => $stuChoice,
                'correct' => $correct,
                'timestamp' => $timestamp
            ]);
            $success = 1;
        }catch(Exception $e){
            $err_msg = $e->getMessage();
        }

        echo json_encode([
            'token' => [
                'history_id' => $history_id,
                'stuChoice' => $stuChoice,
                'correct' => $correct,
                'timestamp' => $timestamp
            ],
            'success' => $success,
            'err_msg' => $err_msg
        ]);
    }

    public function reviewQuestion(){
        $this->load->library('session');
        $this->load->database();
        $tid = $this->input->post('tid');
        $qid = $this->input->post('qid');
        $UserId = $_SESSION['UserId'];
        $data = null;
        $done = false;

        $data = $this->db->query("SELECT * FROM ques_history WHERE stuAccount=$UserId AND tid=$tid AND qid=$qid")->row();
        if($data){
            $data->choices = json_decode($data->snapshot_choices);
            $done = true;
        }

        echo json_encode([
            'token' => [
                'tid' => $tid,
                'qid' => $qid,
                'stuAccount' => $UserId
            ],
            'data' => $data,
            'done' => $done
        ]);
    }

    private function getQuestion($qid, $tid, $stuAccount, $undone){
        
        $question_row = $this->db->query("SELECT * FROM question WHERE id=$qid")->row();
        
        if($question_row){
            $choices = json_decode($question_row -> choices);
            shuffle($choices);
            $data = [
                'qid' => $qid,
                'question_content' => $question_row -> content,
                'choices' => $choices
            ];

            if($undone == false){
                //并不是继续做
                $this->db->insert('ques_history', [
                    'stuAccount' => $stuAccount,
                    'qid' => $qid,
                    'tid' => $tid,
                    'snapshot_content' => $question_row -> content,
                    'snapshot_choices' => json_encode($choices)
                ]);
            };

            return $data;
        }else{
            return null;
        }
    }


    public function finish_test(){
        $this->load->database();
        $stuAccount = $this->input->post('stuAccount');
        $tid = $this->input->post('tid');
        $success = 0;
        $err_msg = null;


        //计算总分并更新考试历史
        //计算总题数
        $total = $this->db->query("SELECT COUNT(*) as total FROM ques_included WHERE tid=$tid")->row()->total;
        //计算总分
        $correct = $this->db->query("SELECT COUNT(*) as correct FROM ques_history WHERE tid=$tid AND stuAccount=$stuAccount AND status=1 AND correct=1")->row()->correct;
        //计算得分
        if($correct == 0 || $total == 0){
            $score = 0;
        }else{
            $score = round($correct / $total * 100, 2);
        }

        $test = $this->db->query("SELECT * FROM test WHERE id=$tid")->row();
        $snapshot_test = [
            'name' => $test->name,
            'timeLimit' => $test->timeLimit,
            'subject' => $test->subject,
            'ques_count' => $total
        ];

        //更新
        try{
            $id = $this->db->query("SELECT id FROM test_history WHERE stuAccount=$stuAccount AND test_id=$tid")->row()->id;
            $this->db->where('id', $id);
            $this->db->update('test_history', [
                'status' => 2,
                'finish' => date("Y-m-d H:i:s"),
                'score' => $score,
                'correct_count' => $correct,
                'snapshot_test' => json_encode($snapshot_test)
            ]);
            $success = 1;
        }catch(Exception $e){
            $err_msg = $e->getMessage();
        }

        echo json_encode([
            'token' => [
                'stuAccount' => $stuAccount,
                'tid' => $tid
            ],
            'score' => $score,
            'success' => $success,
            'err_msg' => $err_msg
        ]);
    }

    public function submit_n_show_next(){
        $this->load->database();
        $stuAccount = $this->input->post('stuAccount');
        $tid = $this->input->post('tid');
        $qid = $this->input->post('qid');
        $stuChoice = $this->input->post('stuChoice');
        $correct = $this->input->post('correct');

        $id = $this->db->query("SELECT id FROM ques_history WHERE stuAccount=$stuAccount AND tid=$tid AND qid=$qid")->row()->id;
        $this->db->where('id', $id);
        $this->db->update('ques_history', [
            'stuChoice' => $stuChoice,
            'status' => 1,
            'correct' => $correct
        ]);

        $this->AquireQues_core($stuAccount, $tid);
    }
}
