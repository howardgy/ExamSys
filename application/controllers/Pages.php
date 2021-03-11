<?php
defined('BASEPATH') OR exit('No direct script access allowed');
define("appName","麻醉科在线考试系统");
define("staticPath","/ExamSys/static");

class Pages extends CI_Controller {

	private function loadCSS($indicators){
		$string = '';
		$staticPath = staticPath;
		foreach($indicators as $i){
			$string .= "<link href='{$staticPath}/css/{$i}.css' rel='stylesheet'>";
		}
		return $string;
	}

	private function loadJS($indicators){
		$string = '';
		$staticPath = staticPath;
		foreach($indicators as $i){
			$string .= "<script type='text/javascript' src='{$staticPath}/js/{$i}.js'></script>";
		}
		return $string;
	}

	private function check_if_logged_in(){
		$this->load->library('session');
		if(isset($_SESSION['level'])){
			if($_SESSION['level'] == 0){
				echo("<script>window.location.href='/ExamSys/index.php/Pages/student';</script>");
			}else{
				echo("<script>window.location.href='/ExamSys/index.php/Pages/teacher';</script>");
			}
			die();
		}
	}

	public function index(){
		$this->check_if_logged_in();

		$this->load->view('header', [
			'title' => appName . ' - 首页',
			'loadCSS' => $this->loadCSS([
				'bootstrap.min-3',
				'Signin',
				'common'
			]),
			'loadJS' => $this->loadJS([
				'jquery',
				'bootstrap.min-3',
				'Global'
			])
		]);
		$this->load->view('index');
	}

	private function err_msg($str){
		$w = "<div style='text-align: center; font-size: 30px; margin-top:200px;'>$str</div>"; 
		$w .= "<div style='text-align: center; font-size: 15px;'><a href='/ExamSys'>返回首页</a></div>"; 
		return $w;
	}

	public function reg(){
		$this->check_if_logged_in();
		
		$this->load->view('header', [
			'title' => appName . ' - 注册',
			'loadCSS' => $this->loadCSS([
				'bootstrap.min-3',
				'Signin',
				'common'
			]),
			'loadJS' => $this->loadJS([
				'jquery',
				'bootstrap.min-3',
				'md5',
				'Global'
			])
			//Reg.js在view里引用
		]);
		$this->load->view('reg', []);
	}

	public function sheet($tid = null, $stuAccount = null, $test_history_id = null){
		$status = 0;
		$err_msg = '';
		$if_snapshot = 0;
		$questions = [];
		$test_info = [];

		if($tid == null){
			$err_msg = '参数错误';
		}else{
			$this->load->library('session');
			if(!isset($_SESSION['level'])){
				die($this->err_msg('拒绝访问：您没有登录'));
			}else if($_SESSION['level'] != 1){
				die($this->err_msg('无权限访问'));
			}

			$this->load->database();

			if($stuAccount == null){
				//按原题来找
				$test_info = $this->db->query("SELECT * FROM test WHERE id=$tid")->row();
				$ques_count = $this->db->query("SELECT COUNT(id) AS ques_count FROM ques_included WHERE tid=$tid;")->row()->ques_count;
				$test_info->ques_count = $ques_count;
				
				if($test_info){
					$status = 1;
					$questions = $this->db->query("SELECT * FROM question WHERE question.id IN (SELECT qid FROM ques_included WHERE tid=$tid);")->result();
					foreach($questions as $q){
						$q->choices = json_decode($q->choices);
					}
				}else{
					$err_msg = '无法找到该考试';
				}
			}else{
				//按snapshot来找
				$test_history = $this->db->query("SELECT * FROM test_history WHERE id=$test_history_id")->row();
				if($test_history){
					$status = 1;
					$if_snapshot = 1;
					$test_info = json_decode($test_history->snapshot_test);
					$test_info->test_history = $test_history;
					$stuName = $this->db->query("SELECT name FROM user WHERE type=0 AND account=$test_history->stuAccount")->row()->name;
					$test_info->test_history->stuName = $stuName;					
					$questions = $this->db->query("SELECT * FROM ques_history WHERE tid=$tid AND stuAccount=$stuAccount")->result();
					foreach($questions as $q){
						$q->choices = json_decode($q->snapshot_choices);
					}
				}else{
					$err_msg = '无法找到该考试快照';
				}
			}
			
		}

		$this->load->view('header', [
			'title' => appName . ' - 试卷',
			'loadCSS' => $this->loadCSS([
				'bootstrap.min-3',
				'common',
				'Sheet'
			]),
			'loadJS' => $this->loadJS([
				'jquery',
				'bootstrap.min-3',
				'Global'
			])
		]);
		$this->load->view('sheet', [
			'bar_content' => 'teacher',
			'status' => $status,
			'err_msg' => $err_msg,
			'questions' => $questions,
			'test_info' => $test_info,
			'if_snapshot' => $if_snapshot
		]);
	}

	public function student(){
		$this->load->library('session');

		if(!isset($_SESSION['level'])){
			die($this->err_msg('拒绝访问：您没有登录'));
		}else if($_SESSION['level']!=0){
			die($this->err_msg('无权限访问'));
		} 
		
		$this->load->view('header', [
			'title' => appName . ' - 考生',
			'loadCSS' => $this->loadCSS([
				'bootstrap.min-3',
				'signin',
				'Student',
				'common'
			]),
			'loadJS' => $this->loadJS([
				'jquery',
				'bootstrap.min-3',
				'Global',
				'md5',
				'Student',
				'userinfo'
			])
		]);
		$this->load->view('student', [
			'bar_content' => 'student'
		]);
	}

	public function teacher($sub_page = 0){
		$pages_count = 5;
		$page_script = "<script>init_page1();</script>";
		if(isset($sub_page) && (intval($sub_page) <= $pages_count) && (intval($sub_page) > 0)){
			$page_script = "<script>init_page$sub_page();</script>";
		}

		$this->load->library('session');

		if(!isset($_SESSION['level'])){
			die($this->err_msg('拒绝访问：您没有登录'));
		}else if($_SESSION['level'] != 1){
			die($this->err_msg('无权限访问'));
		} 

		$this->load->view('header', [
			'title' => appName . ' - 老师',
			'loadCSS' => $this->loadCSS([
				'bootstrap.min-3',
				'Signin',
				'dashboard',
				'Teacher',
				'common'
			]),
			'loadJS' => $this->loadJS([
				'jquery',
				'bootstrap.min-3',
				'Global',
				'md5',
				'Teacher',
				'userinfo'
			])
		]);
		$this->load->view('teacher', [
			'page_script' => $page_script,
			'bar_content' => 'teacher'
		]);
	}

	public function test($testid){
		$this->load->database();
		$this->load->library('session');

		if(!isset($_SESSION['level'])){
			die($this->err_msg('拒绝访问：您没有登录'));
		}else if($_SESSION['level']!=0){
			die($this->err_msg('无权限访问'));
		}

		$UserId = $_SESSION['UserId'];
		$test = $this->db->query("SELECT * FROM test WHERE id=$testid;")->row();
		$test -> ques_count = $this->db->query("SELECT COUNT(*) AS count FROM ques_included WHERE tid=$testid")->result()[0]->count;
		$status_row = $this->db->query("SELECT * FROM test_history WHERE test_id=$testid AND stuAccount=$UserId")->row();
		if($status_row){
			$test -> status = $status_row -> status;
		}else{
			$test -> status = 0;
		}

		$this->load->view('header', [
			'title' => appName . ' - 考试',
			'loadCSS' => $this->loadCSS([
				'bootstrap.min-3',
				'dashboard',
				'Test',
				'common'
			]),
			'loadJS' => $this->loadJS([
				'jquery',
				'bootstrap.min-3',
				'Global',
				'Test'
			])
		]);
		$this->load->view('test', [
			'bar_content' => 'test' . $test -> status,
			'test' => $test
		]);
	}

}
