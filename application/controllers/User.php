<?php
defined('BASEPATH') or exit('No direct script access allowed');
const invitation_student = null;
const invitation_teacher = '2562';

class User extends CI_Controller
{
    public function update_user(){
        $this->load->library('session');
        $this->load->database();
        $value = $this->input->post('value', true);
        $field = $this->input->post('field');
        $psw_old = $this->input->post('psw_old');
        $UserId = $_SESSION['UserId'];
        $level = $_SESSION['level'];
        $result = 0;
        $err_msg = null;
        
        try{
            $data = ['name' => $value];
            if($field == 'psw'){
                $psw_ori = $this->db->query("SELECT psw FROM user WHERE account=$UserId AND type=$level")->row()->psw;
                if($psw_ori != $psw_old){
                    echo json_encode([
                        'token' => [
                            'psw_old' => $psw_old,
                            'psw_new' => $value,
                            'field' => $field,
                            'UserId' => $UserId,
                            'level' => $level
                        ],
                        'result' => 0,
                        'err_msg' => 'old_psw_wrong',
                    ]);
                    die();
                }else{
                    $data = ['psw' => $value];
                }
            }
            
            $this->db->where('account', $UserId);
            $this->db->where('type', $level);
            $this->db->update('user', $data);

            $this->session->set_userdata('UserName', $value);
            $result = 1;
        }catch(Exception $e){
            $err_msg = $e->getMessage();
        }

        echo json_encode([
            'token' => [
                'value' => $value,
                'field' => $field,
                'UserId' => $UserId,
                'level' => $level
            ],
            'result' => $result,
            'err_msg' => $err_msg,
        ]);
    }

    public function login()
    {
        $this->load->library('session');
        $this->load->database();

        $UserId = $this->input->post('UserId', true);
        $UserPassword = $this->input->post('UserPassword', true);
        $UserPassword = md5($UserPassword);
        $UserLevel = $this->input->post('UserLevel');
        $result = null;
        $err_msg = null;

        $SQL = "SELECT * FROM user WHERE account=$UserId AND type=$UserLevel;";
        $path = null;
        $res = null;

        if ($UserLevel == 0) {
            $path = "/ExamSys/index.php/Pages/student";
        } else {
            $path = "/ExamSys/index.php/Pages/teacher";
        }

        $res = $this->db->query($SQL)->result();
        if ($res) { //id exist
            
            if ($res[0]->psw == $UserPassword) {
                $this->session->set_userdata('level', $UserLevel);
                $this->session->set_userdata('UserId', $UserId);
                $this->session->set_userdata('UserName', $res[0]->name);
                try{
                    $data = array(
                        'latestLogin' => date('Y-m-d H:i:s')
                    );
                    $this->db->where('id', $res[0]->id);
                    $this->db->update('user', $data);
                    //date('Y-m-d H:i:s')
                }catch(Exception $e){
                    $msg = $e->getMessage();
                    echo "<script>alert('$msg');</script>";
                }
                $result = 1;
                echo "<script>window.location.href='$path';</script>";

            } else {
                $result = 0;
                $err_msg = 'incorrect';
                echo "<script>alert('登录失败，请检查登录信息');</script>";
                echo "<script>window.location.href='/ExamSys';</script>";
            }
        }else{
            $result = 0;
            $err_msg = 'incorrect';
            echo "<script>alert('登录失败，请检查登录信息');</script>";
            echo "<script>window.location.href='/ExamSys';</script>";
        }

        // echo json_encode([
        //     'token' => [
        //         'UserId' => $UserId,
        //         'UserPassword' => $UserPassword,
        //         'UserLevel' => $UserLevel
        //     ],
        //     'result' => $result,
        //     'err_msg' => $err_msg
        // ]);
    }


    public function logout()
    {
        $this->load->library('session');
        session_destroy();
        echo "<script>window.location.href='/ExamSys';</script>";
    }


    public function signUp()
    {
        $this->load->database();
        $this->load->library('session');

        $username = $this->input->post('username', true);
        $userid = $this->input->post('userid', true);
        $password = $this->input->post('password', true);
        $type = $this->input->post('type');
        $invitation = $this->input->post('invitation', true);
        $success = 0;
        $err_msg = null;
        $invitation_check = 'failed';

        if($type == 0){
            if(invitation_student == null || $invitation == invitation_student){
                $invitation_check = 'passed';
            }
        }else{
            if(invitation_teacher == null || $invitation == invitation_teacher){
                $invitation_check = 'passed';
            }
        }

        if($invitation_check == 'passed'){
            try {
                $res = $this->db->insert('user', [
                    'account' => $userid,
                    'name' => $username,
                    'type' => $type,
                    'psw' => $password,
                ]);
    
                $this->session->set_userdata('level', $type);
                $this->session->set_userdata('UserId', $userid);
                $this->session->set_userdata('UserName', $username);
    
                $success = 1;
    
            } catch (Exception $e) {
                $err_msg = $e->getMessage();
            }
        }


        echo json_encode([
            'token' => [
                'username' => $username,
                'userid' => $userid,
                'password' => $password,
                'type' => $type,
                'invitation' => $invitation
            ],
            'success' => $success,
            'err_msg' => $err_msg,
            'invitation_check' => $invitation_check
        ]);
    }


    public function regCheck()
    {
        $this->load->database();

        $UserId = $this->input->post('UserId');
        $type = $this->input->post('type');
       
        $SQL = "SELECT * FROM user WHERE account='$UserId' AND type=$type;";
        $row = $this->db->query($SQL)->result();
        
        $r = 'absent';
        if ($row) {
            $r = 'exist';
        }
        
        echo($r);
    }
}
