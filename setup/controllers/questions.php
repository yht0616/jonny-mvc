<?php

class questions_controller extends \application\core\controller {

	public function __construct() {
		parent::__construct();
	}

	public function view($id) {
		$select_questions = $this->database->select('*', 'questions', 'id = ' . $id);

		$select_answers = $this->database->select('*', 'answers', 'question_id = ' . $id);

		$data = array(
			'questions' => $select_questions,
			'answers' => $select_answers,
		);

		$this->load->view('questions/view', $data);
	}

}