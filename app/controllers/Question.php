<?php

class Question extends Controller {

	public function __construct() {
		parent::__construct();
	}

	public function index() {
		header("Location: ".SITE_URL."/question/all");
	}

	public function category($name = "") {
		$this->model->setTable('category');
		if(($name == "add" || $name == "update" || $name == "delete" || $name == "get") && (Session::isLoggedIn(1) || Session::isLoggedIn(2))) {
			$result = array('status' => 0);	
			if(isset($_POST) && count($_POST) > 0) {
				if($name == "get") {
					return $this->getCategory($result);
				}
				if($name == "delete") {
					return $this->deleteCategory($result);
				}
				if($name == "update" && isset($_POST['id'])) {
					return $this->updateCategory($result);
				}
				if($name == "add") {
					return $this->addCategory($result);
				}
			}else{
				header("Location: ".SITE_URL."/home/dashboard");
			}	

		} else if($name == ''){	
			if(Session::isLoggedIn(1) || Session::isLoggedIn(2)) {
				$this->setForeignModel('QuestionModel');
				$this->foreignModel->setTable('program');
				$allPassage = $this->foreignModel->getAllQuestion();
				$this->model->data['program'] = $allPassage;
				$this->model->template = VIEWS_DIR.DS."questions".DS."category.php";
				$this->view->render();
			}else {
				header("Location: ".SITE_URL."/home/dashboard");
			}			
		} else {
			header("Location: ".SITE_URL."/home/message");
		}
    }
    
    public function all($name = "") {
		$this->model->setTable('questions');
		if(($name == "add" || $name == "update" || $name == "delete" || $name == "get" || $name == "getPassages" || $name == "getCategoryForProgram") && (Session::isLoggedIn(1) || Session::isLoggedIn(2))) {
			$result = array('status' => 0);	
			if(isset($_POST) && count($_POST) > 0) {
				if($name == "get") {
					return $this->getQuestion($result);
				}
				if($name == "delete") {
					return $this->deleteQuestion($result);
				}
				if($name == "update" && isset($_POST['id'])) {
					return $this->updateQuestion($result);
				}
				if($name == "add") {
					return $this->addQuestion($result);
				}
				if($name == "getPassages") {
					return $this->getPassagesPrivate($result);
				}
				if($name == "getCategoryForProgram") {
					return $this->getCategoryForProgramPrivate($result);
				}
			}else{
				header("Location: ".SITE_URL."/home/dashboard");
			}	

		} else if($name == ''){	
			if(Session::isLoggedIn(1) || Session::isLoggedIn(2)) {
				$this->model->setTable('category');
				$all = $this->model->getAllQuestion();
				$this->model->data['category'] = $all;
				$this->setForeignModel('QuestionModel');
				$this->foreignModel->setTable('program');
				$allPassage = $this->foreignModel->getAllQuestion();
				$this->model->data['program'] = $allPassage;
				$this->model->template = VIEWS_DIR.DS."questions".DS."questions.php";
				$this->view->render();
			}else {
				header("Location: ".SITE_URL."/home/dashboard");
			}			
		} else {
			header("Location: ".SITE_URL."/home/message");
		}
    }


    private function getCategoryForProgramPrivate($result) {
    	if(!isset($_POST['filterProgram'])) {
			$result['error'] = array("Invalid selection.");
			$result['status'] = 0;
		}else {
			$programId = Input::get('filterProgram');
			$dataToSearch = array('programId' => $programId);

			$this->setForeignModel("QuestionModel");
			$this->foreignModel->setTable("category");
			$res = $this->foreignModel->searchQuestion($dataToSearch);

			if(count($res) > 0) {
				$result['category'] = $res;
				$result['status'] = 1;
			}else {
				$result['error'] = array("Category not found for this program");
				$result['status'] = 0;
			}
		}
		$result['success'] = ($result['status'] == 1) ? true : false;
		unset($_POST);
		return print json_encode($result);
    }
    
    public function program($name='') {
    	$this->model->setTable('program');
		if(($name == "add" || $name == "update" || $name == "delete" || $name == "get") && (Session::isLoggedIn(1) || Session::isLoggedIn(2))) {
			$result = array('status' => 0);	
			if(isset($_POST) && count($_POST) > 0) {
				if($name == "get") {
					return $this->getProgram($result);
				}
				if($name == "delete") {
					return $this->deleteProgram($result);
				}
				if($name == "update" && isset($_POST['id'])) {
					return $this->updateProgram($result);
				}
				if($name == "add") {
					return $this->addProgram($result);
				}
			}else{
				header("Location: ".SITE_URL."/home/dashboard");
			}	

		} else if($name == ''){	
			if(Session::isLoggedIn(1) || Session::isLoggedIn(2)) {
				$this->model->template = VIEWS_DIR.DS."questions".DS."program.php";
				$this->view->render();
			}else {
				header("Location: ".SITE_URL."/home/dashboard");
			}			
		} else {
			header("Location: ".SITE_URL."/home/message");
		}
		
	}

	public function model($name=''){
		if($name != ""){
			if(Session::isLoggedIn(1) || Session::isLoggedIn(2)) {
				$this->setForeignModel("QuestionModel");
				$this->foreignModel->setTable("program");
				$allPrograms = $this->foreignModel->getAllQuestion();
				$this->model->data['programs'] = $allPrograms;
				$program = null;
				$allInfo = null;
				foreach ($allPrograms as $value) {
					if($name == strtolower(trim(str_replace(' ', '', $value['name'])))) {
						$program = $value['name'];
						$allInfo = $value;
					}
				}
				if(!is_null($program)) {
					$this->model->setTable("category");
					$allCategories = $this->model->getAllQuestion();
					$this->model->data['program'] = $allInfo;
					$this->model->data['category'] = $allCategories;
					$this->model->template = VIEWS_DIR.DS."questions".DS."model.php";
					$this->view->render();
				}else {
					header("Location: ".SITE_URL."/home/message");
				}
			}else {
				header("Location: ".SITE_URL."/home/dashboard");
			}	
		}else{
			header("Location: ".SITE_URL."/home/message");
		}
	}

	public function modelController($name = '') {
		$this->model->setTable('questionmodel');
		if(($name == "add" || $name == "update" || $name == "delete" || $name == "get") && (Session::isLoggedIn(1) || Session::isLoggedIn(2))) {
			$result = array('status' => 0);	
			if(isset($_POST) && count($_POST) > 0) {
				if($name == "get" && isset($_POST['programId'])) {
					return $this->getModel($result);
				}
				if($name == "delete") {
					return $this->deleteModel($result);
				}
				if($name == "update" && isset($_POST['id'])) {
					return $this->updateModel($result);
				}
				if($name == "add") {
					return $this->addModel($result);
				}
			}else{
				header("Location: ".SITE_URL."/home/dashboard");
			}	

		} else if($name == ''){
			header("Location: ".SITE_URL."/home/dashboard");	
		} else {
			header("Location: ".SITE_URL."/home/message");
		}
	}

	private function getModel($result) {
		$startIndex = $_POST['start'];
		$totalCount = $_POST['length'];
		$startIndex = ($totalCount == -1) ? 0 : $startIndex;
		$columnToSort = null;
		$sortDir = null;
		$stringToSearch = null;
		$fieldToSearch = array();
		if(isset($_POST["order"][0]["column"])){
			$sortDir = Sanitize::escape($_POST["order"][0]["dir"]);

			$columnToSort = $_POST["order"][0]["column"];

			$columnToSort = (!isset($_POST["columns"][$columnToSort]["name"]) && $_POST["columns"][$columnToSort]["orderable"]) ? $_POST["columns"][$columnToSort]["name"] : "id" ;
			$columnToSort = ($columnToSort == "order") ? "id" : $columnToSort;
			$columnToSort = ($columnToSort == "category") ? "categoryId" : $columnToSort;
			$columnToSort = Sanitize::escape($columnToSort);
		}
		if(isset($_POST["search"]["value"])) {
			$stringToSearch = Sanitize::escape($_POST["search"]["value"]);
		}
		$allModels = $this->model->getAllQuestionConditions($stringToSearch,$fieldToSearch,$columnToSort,$sortDir);

		$res = array();
		foreach ($allModels as $value) {
			if($value['programId'] == Input::get('programId')) {
				array_push($res, $value);
			}
		}

		$newArr = $this->model->searchQuestion(array('programId' => Input::get('programId')));

		foreach ($newArr as $key => $value) {
			foreach ($res as $key1 => $value1) {
				if($value['id'] == $value1['id']) $res[$key1]['order'] = $key + 1;
			}
		}

		$total = count($res);
		$index = 0;
		$arr = array();
		$totalCount = ($totalCount == -1) ? $total : $totalCount;
		for ($i = $startIndex; $i < $startIndex + $totalCount && $i < $total; $i++){
			$toSearch = array("id" => $res[$i]['categoryId']);
			$this->setForeignModel("QuestionModel");
			$this->foreignModel->setTable("category");
			$categories = $this->foreignModel->searchQuestion($toSearch);	

			$progID = (count($categories) > 0) ? $categories[0]['programId'] : -1;
			$progName = "undefined";
			$programInnerId = 0;
			if($progID > 0) {
				$this->foreignModel->setTable("program");
				$toSearch = array('id' => $progID);
				$programToSearch = $this->foreignModel->searchQuestion($toSearch);
				if(count($programToSearch) > 0) {
					$progName = $programToSearch[0]['name'];
					$programInnerId = $programToSearch[0]['id'];
				}
			}
			$arr[$index] = $res[$i];
			$arr[$index]['programName'] = $progName;
			$arr[$index]['programInnerId'] = $programInnerId;
			$arr[$index]['category'] = (count($categories) > 0) ? $categories[0]['name'] : 'undefined';
			switch ($arr[$index]['minLevel']) {
				case 1:
					$arr[$index]['levelName'] = "Basic";
					break;
				case 2:
					$arr[$index]['levelName'] = "Medium";
					break;
				case 3:
					$arr[$index]['levelName'] = "Hard";
					break;
			}
			$index++;
		}

		if(count($arr) >= 1){
			$result['status'] = 1;
		}
		$result['data'] = $arr;
		$result['success'] = ($result['status'] == 1) ? true : false;
		$result['draw'] = $_POST['draw'];
		$result['recordsTotal'] = $total;
		$result['recordsFiltered'] = $index;
		unset($_POST);
		return print json_encode($result);
	}

	private function deleteModel($result) {
		if(!isset($_POST['id'])) {
			$result['error'] = array("Invalid selection.");
			$result['status'] = 0;
		}else {
			$idToDel = Input::get('id');
			$dataToSearch = array('id' => $idToDel);
			$res = $this->model->searchQuestion($dataToSearch);
			if(count($res) >= 1) {
				$out = $this->model->deleteQuestion($idToDel);
				if($out == 1) {
					$result['status'] = 1;
				}else {
					$result['error'] = array("Connection Problem with server.");
					$result['status'] = 0;
				}
			}else {
				$result['error'] = array("No such model found.");
				$result['status'] = 0;
			}
		}
		$result['success'] = ($result['status'] == 1) ? true : false;
		unset($_POST);
		return print json_encode($result);
	}

	private function updateModel($result) {
		$data = array();
		foreach ($_POST as $key => $value) {
			$data[$key] = Input::get($key);
		}
		$validate = new Validator();
		$validation = $validate->check($_POST, array());
		if($data['noOfQuestions'] <= 0) $validate->addError("No of Questions must be greater than 0!");
		if($data['minLevel'] <= 0 || $data['minLevel'] > 3 ) $validate->addError("Level isnot valid!");
		if($data['categoryId'] <= 0) $validate->addError("Category not valid!");
		if($validate->passed()){
			$dataForSearch = array('id' => $data['id']);
			$res = $this->model->searchQuestion($dataForSearch);
			if(count($res) >= 1) {
				$searchForQuestions = $this->setForeignModel("QuestionModel");
				$this->foreignModel->setTable("questions");
				$dataToSearch = array("categoryId" => $data['categoryId'], "level" => $data['minLevel']);
				$resultOfSearch = $this->foreignModel->searchQuestion($dataToSearch);
				if(count($resultOfSearch) >= $data["noOfQuestions"]) {
					$idToChange = $data['id'];
					unset($data['id']);
					$ret = $this->model->updateQuestion($idToChange, $data);
					if($ret == 1) {
						$result['status'] = 1;
						$result['success'] = true;
					} else {
						$result['status'] = -1;
						$result['errors'] = $validate->addError("Nothing updated!");
					}
				}else {
					$result['status'] = 0;
					$validate->addError("Only ".count($resultOfSearch)." questions of this level and category are available in Database!");
				}							
			} else {
				$result['errors'] = $validate->addError("No such model found.");
				$result['status'] = 0;
			}
		} else {
			$result['status'] = 0;
		}
		if($result['status'] == 0 || $result['status'] == -1) {
			$result['errors'] = $validate->errors();
			$result['success'] = false;
		}
		unset($_POST);
		return print json_encode($result);
	}

	private function addModel($result){
		$validate = new Validator();
		$validation = $validate->check($_POST, array());
		if(Input::get('noOfQuestions') <= 0) $validate->addError("No of Questions must be greater than 0!");
		if(Input::get('minLevel') <= 0 || Input::get('minLevel') > 3 ) $validate->addError("Level isnot valid!");
		if(Input::get('categoryId') <= 0) $validate->addError("Category not valid!");
		if($validate->passed()){
			$data = array();
			$data['id'] = null;
			foreach ($_POST as $key => $value) {
				$data[$key] = Input::get($key);
			}
			$searchForQuestions = $this->setForeignModel("QuestionModel");
			$this->foreignModel->setTable("questions");
			$dataToSearch = array("categoryId" => $data['categoryId'], "level" => $data['minLevel']);
			$resultOfSearch = $this->foreignModel->searchQuestion($dataToSearch);
			if(count($resultOfSearch) >= $data["noOfQuestions"]) {
				$id = $this->model->registerQuestion($data);
				if($id != 0){
					$result['status'] = 1;
					$result['success'] = true;
				}else{
					$result['status'] = -1;
					$validate->addError("Problem with connection to server!");
				}
			}else {
				$result['status'] = 0;
				$validate->addError("Only ".count($resultOfSearch)." questions of this level and category are available in Database!");
			}
			
		} else {
			$result['status'] = 0;
		}
		if($result['status'] == 0 || $result['status'] == -1) {
			$result['errors'] = $validate->errors();
			$result['success'] = false;
		} 
		unset($_POST);
		return print json_encode($result);			
	}

	private function getCategory($result) {
		$startIndex = $_POST['start'];
		$totalCount = $_POST['length'];
		$startIndex = ($totalCount == -1) ? 0 : $startIndex;
		$columnToSort = null;
		$sortDir = null;
		$stringToSearch = null;
		$fieldToSearch = array("name","description");
		if(isset($_POST["order"][0]["column"])){
			$sortDir = Sanitize::escape($_POST["order"][0]["dir"]);

			$columnToSort = $_POST["order"][0]["column"];

			$columnToSort = (!isset($_POST["columns"][$columnToSort]["name"]) && $_POST["columns"][$columnToSort]["orderable"]) ? $_POST["columns"][$columnToSort]["name"] : "name" ;
			$columnToSort = Sanitize::escape($columnToSort);
		}
		if(isset($_POST["search"]["value"])) {
			$stringToSearch = Sanitize::escape($_POST["search"]["value"]);
		}
		$res = $this->model->getAllQuestionConditions($stringToSearch,$fieldToSearch,$columnToSort,$sortDir);
			
		if(isset($_POST['filterProgram']) && $_POST['filterProgram'] > 0) {
			$i = 0;
			foreach ($res as $value) {
				if($value['programId'] != $_POST['filterProgram']) {
					array_splice($res, $i, 1);
					$i--;
				}
				$i++;
			}
		}

		$total = count($res);
		$index = 0;
		$arr = array();
		$totalCount = ($totalCount == -1) ? $total : $totalCount;
		for ($i = $startIndex; $i < $startIndex + $totalCount && $i < $total; $i++){
			$arr[$index] = $res[$i];
			$progID = $res[$i]['programId'];
			$progName = "undefined";
			if($progID > 0) {
				$this->setForeignModel("QuestionModel");
				$this->foreignModel->setTable("program");
				$toSearch = array('id' => $progID);
				$programToSearch = $this->foreignModel->searchQuestion($toSearch);
				if(count($programToSearch) > 0) {
					$progName = $programToSearch[0]['name'];
				}
			}
			$arr[$index]['programName'] = $progName;
			$index++;
		}

		if(count($arr) >= 1){
			$result['status'] = 1;
		}
		$result['data'] = $arr;
		$result['success'] = ($result['status'] == 1) ? true : false;
		$result['draw'] = $_POST['draw'];
		$totalCategories = count($this->model->getAllQuestion());
		$result['recordsTotal'] = $totalCategories;
		$result['recordsFiltered'] = $total;
		unset($_POST);
		return print json_encode($result);
	}

	private function deleteCategory($result) {
		if(!isset($_POST['id'])) {
			$result['error'] = array("Invalid selection.");
			$result['status'] = 0;
		}else {
			$idToDel = Input::get('id');
			$dataToSearch = array('id' => $idToDel);
			$res = $this->model->searchQuestion($dataToSearch);
			if(count($res) >= 1) {
				$out = $this->model->deleteQuestion($idToDel);
				if($out == 1) {
					$result['status'] = 1;
					$this->setForeignModel("QuestionModel");
					$this->foreignModel->setTable("questions");
					$toDelete = array('categoryId' => $idToDel);
					$questionsToDelete = $this->foreignModel->searchQuestion($toDelete);
					foreach ($questionsToDelete as $value) {
						$this->foreignModel->deleteQuestion($value['id']);
					}
					$this->foreignModel->setTable("questionmodel");
					$toDelete = array('categoryId' => $idToDel);
					$questionsToDelete = $this->foreignModel->searchQuestion($toDelete);
					foreach ($questionsToDelete as $value) {
						$this->foreignModel->deleteQuestion($value['id']);
					}
				}else {
					$result['error'] = array("Connection Problem with server.");
					$result['status'] = 0;
				}
			}else {
				$result['error'] = array("No such category found.");
				$result['status'] = 0;
			}
		}
		$result['success'] = ($result['status'] == 1) ? true : false;
		unset($_POST);
		return print json_encode($result);
	}

	private function updateCategory($result) {
		$data = array();
		foreach ($_POST as $key => $value) {
			$data[$key] = Input::get($key);
		}
		$validate = new Validator();
		$validation = $validate->check($_POST, array(
			'name' => array(
				'name' => 'Name',
				'required' => true,
				'min' => 1,
				'max' => 30
			)
		));
		if($validate->passed()){
			$dataForSearch = array('id' => $data['id']);
			$res = $this->model->searchQuestion($dataForSearch);
			if(count($res) >= 1) {
				$idToChange = $data['id'];
				unset($data['id']);
				$ret = $this->model->updateQuestion($idToChange, $data);
				if($ret == 1) {
					$result['status'] = 1;
					$result['success'] = true;
				} else {
					$result['status'] = -1;
					$result['errors'] = $validate->addError("Nothing updated!");
				}							
			} else {
				$result['errors'] = $validate->addError("No such category found.");
				$result['status'] = 0;
			}
		} else {
			$result['status'] = 0;
		}
		if($result['status'] == 0 || $result['status'] == -1) {
			$result['errors'] = $validate->errors();
			$result['success'] = false;
		}
		unset($_POST);
		return print json_encode($result);
	}

	private function addCategory($result){
		$validate = new Validator();
		$validation = $validate->check($_POST, array(
			'name' => array(
				'name' => 'Name',
				'required' => true,
				'min' => 1,
				'max' => 30
			)
		));
		if($validate->passed()){
			$data = array();
			$data['id'] = null;
			foreach ($_POST as $key => $value) {
				$data[$key] = Input::get($key);
			}
			$id = $this->model->registerQuestion($data);
			if($id != 0){
				$result['status'] = 1;
				$result['success'] = true;
			}else{
				$result['status'] = -1;
				$result['errors'] = $validate->addError("Problem with connection to server!");
			}
		} else {
			$result['status'] = 0;
		}
		if($result['status'] == 0 || $result['status'] == -1) {
			$result['errors'] = $validate->errors();
			$result['success'] = false;
		} 
		unset($_POST);
		return print json_encode($result);			
	}

	private function getProgram($result) {
		$startIndex = $_POST['start'];
		$totalCount = $_POST['length'];
		$startIndex = ($totalCount == -1) ? 0 : $startIndex;
		$columnToSort = null;
		$sortDir = null;
		$stringToSearch = null;
		$fieldToSearch = array("name","duration");
		if(isset($_POST["order"][0]["column"])){
			$sortDir = Sanitize::escape($_POST["order"][0]["dir"]);

			$columnToSort = $_POST["order"][0]["column"];

			$columnToSort = (!isset($_POST["columns"][$columnToSort]["name"]) && $_POST["columns"][$columnToSort]["orderable"]) ? $_POST["columns"][$columnToSort]["name"] : "name" ;
			$columnToSort = Sanitize::escape($columnToSort);
		}
		if(isset($_POST["search"]["value"])) {
			$stringToSearch = Sanitize::escape($_POST["search"]["value"]);
		}
		$res = $this->model->getAllQuestionConditions($stringToSearch,$fieldToSearch,$columnToSort,$sortDir);
		$total = count($res);
		$index = 0;
		$arr = array();
		$totalCount = ($totalCount == -1) ? $total : $totalCount;
		for ($i = $startIndex; $i < $startIndex + $totalCount && $i < $total; $i++){
			$arr[$index] = $res[$i];
			$arr[$index]['welcome'] = html_entity_decode($arr[$index]['welcome']);
			$arr[$index]['thanks'] = html_entity_decode($arr[$index]['thanks']);
			$arr[$index]['url'] = urlencode(strtolower(trim(str_replace(' ', '', $arr[$index]['name']))));
			$index++;
		}

		if(count($arr) >= 1){
			$result['status'] = 1;
		}
		$result['data'] = $arr;
		$result['success'] = ($result['status'] == 1) ? true : false;
		$result['draw'] = $_POST['draw'];
		$totalCategories = count($this->model->getAllQuestion());
		$result['recordsTotal'] = $totalCategories;
		$result['recordsFiltered'] = $total;
		unset($_POST);
		return print json_encode($result);
	}

	private function deleteProgram($result) {
		if(!isset($_POST['id'])) {
			$result['error'] = array("Invalid selection.");
			$result['status'] = 0;
		}else {
			$idToDel = Input::get('id');
			$dataToSearch = array('id' => $idToDel);
			$res = $this->model->searchQuestion($dataToSearch);
			if(count($res) >= 1) {
				$out = $this->model->deleteQuestion($idToDel);
				if($out == 1) {
					$result['status'] = 1;
					$this->setForeignModel("QuestionModel");
					$this->foreignModel->setTable("questionmodel");
					$toDelete = array('programId' => $idToDel);
					$questionsToDelete = $this->foreignModel->searchQuestion($toDelete);
					foreach ($questionsToDelete as $value) {
						$this->foreignModel->deleteQuestion($value['id']);
					}
				}else {
					$result['error'] = array("Connection Problem with server.");
					$result['status'] = 0;
				}
			}else {
				$result['error'] = array("No such program found.");
				$result['status'] = 0;
			}
		}
		$result['success'] = ($result['status'] == 1) ? true : false;
		unset($_POST);
		return print json_encode($result);
	}

	private function updateProgram($result) {
		$data = array();
		foreach ($_POST as $key => $value) {
			$data[$key] = Input::get($key);
		}
		$validate = new Validator();
		$validation = $validate->check($_POST, array(
			'name' => array(
				'name' => 'Name',
				'required' => true,
				'min' => 1,
				'max' => 30
			),
			'welcome' => array(
				'name' => 'Welcome Message',
				'required' => true,
				'min' => 1,
				'max' => 5000
			),
			'thanks' => array(
				'name' => 'Exit Message',
				'required' => true,
				'min' => 1,
				'max' => 5000
			)
		));
		if(Input::get('duration') <= 0 ) $validate->addError("Duration isnot valid!");
		if($validate->passed()){
			$dataForSearch = array('id' => $data['id']);
			$res = $this->model->searchQuestion($dataForSearch);
			if(count($res) >= 1) {
				$idToChange = $data['id'];
				unset($data['id']);
				$ret = $this->model->updateQuestion($idToChange, $data);
				if($ret == 1) {
					$result['status'] = 1;
					$result['success'] = true;
				} else {
					$result['status'] = -1;
					$result['errors'] = $validate->addError("Nothing updated!");
				}							
			} else {
				$result['errors'] = $validate->addError("No such program found.");
				$result['status'] = 0;
			}
		} else {
			$result['status'] = 0;
		}
		if($result['status'] == 0 || $result['status'] == -1) {
			$result['errors'] = $validate->errors();
			$result['success'] = false;
		}
		unset($_POST);
		return print json_encode($result);
	}

	private function addProgram($result){
		$validate = new Validator();
		$validation = $validate->check($_POST, array(
			'name' => array(
				'name' => 'Name',
				'required' => true,
				'min' => 1,
				'max' => 30
			),
			'welcome' => array(
				'name' => 'Welcome Message',
				'required' => true,
				'min' => 1,
				'max' => 5000
			),
			'thanks' => array(
				'name' => 'Exit Message',
				'required' => true,
				'min' => 1,
				'max' => 5000
			)
		));
		if(Input::get('duration') <= 0 ) $validate->addError("Duration isnot valid!");
		if($validate->passed()){
			$data = array();
			$data['id'] = null;
			foreach ($_POST as $key => $value) {
				$data[$key] = Input::get($key);
			}
			$id = $this->model->registerQuestion($data);
			if($id != 0){
				$result['status'] = 1;
				$result['success'] = true;
			}else{
				$result['status'] = -1;
				$result['errors'] = $validate->addError("Problem with connection to server!");
			}
		} else {
			$result['status'] = 0;
		}
		if($result['status'] == 0 || $result['status'] == -1) {
			$result['errors'] = $validate->errors();
			$result['success'] = false;
		} 
		unset($_POST);
		return print json_encode($result);			
	}

	private function getPassagesPrivate($result) {
    	if(!isset($_POST['confirm']) || $_POST['confirm'] != 1) {
			$result['error'] = array("Invalid selection.");
			$result['status'] = 0;
		}else {
			$this->setForeignModel("QuestionModel");
			$this->foreignModel->setTable("passage");
			$res = $this->foreignModel->getAllQuestion();
			if(count($res) > 0) {
				$result['passages'] = $this->sortForId($res);
				$result['status'] = 1;
			}else {
				$result['error'] = array("No passages found");
				$result['status'] = 0;
			}
		}
		$result['success'] = ($result['status'] == 1) ? true : false;
		unset($_POST);
		return print json_encode($result);
    }

    private function sortForId($records) {
		$finalOutput = array();
		foreach ($records as $value) {
			$finalOutput[$value['id']] = $value;			
		}
		return $finalOutput;
	}

	private function getQuestion($result) {
		$startIndex = $_POST['start'];
		$totalCount = $_POST['length'];
		$startIndex = ($totalCount == -1) ? 0 : $startIndex; 
		$columnToSort = null;
		$sortDir = null;
		$stringToSearch = null;
		$fieldToSearch = array("question");
		if(isset($_POST["order"][0]["column"])){
			$sortDir = Sanitize::escape($_POST["order"][0]["dir"]);

			$columnToSort = $_POST["order"][0]["column"];

			$columnToSort = (isset($_POST["columns"][$columnToSort]["data"]) && $_POST["columns"][$columnToSort]["orderable"]) ? $_POST["columns"][$columnToSort]["data"] : "question" ;
			$columnToSort = Sanitize::escape($columnToSort);

			$columnToSort = ($columnToSort == "category") ? "categoryId" : $columnToSort;
			$columnToSort = ($columnToSort == "levelName") ? "level" : $columnToSort;
		}
		if(isset($_POST["search"]["value"])) {
			$stringToSearch = Sanitize::escape($_POST["search"]["value"]);
		}
		$res = $this->model->getAllQuestionConditions($stringToSearch,$fieldToSearch,$columnToSort,$sortDir);

		if(isset($_POST['filterProgram']) && $_POST['filterProgram'] > 0) {
			$i = 0;
			foreach ($res as $value) {
				if($value['programId'] != $_POST['filterProgram']) {
					array_splice($res, $i, 1);
					$i--;
				}
				$i++;
			}
		}

		if(isset($_POST['filterData']) && $_POST['filterData'] > 0) {
			$i = 0;
			foreach ($res as $value) {
				if($value['categoryId'] != $_POST['filterData']) {
					array_splice($res, $i, 1);
					$i--;
				}
				$i++;
			}
		}

		$total = count($res);

		$index = 0;
		$arr = array();

		$totalCount = ($totalCount == -1) ? $total : $totalCount;

		for ($i = $startIndex; $i < $startIndex + $totalCount && $i < $total; $i++){
			$toSearch = array("id" => $res[$i]['categoryId']);
			$this->setForeignModel("QuestionModel");
			$this->foreignModel->setTable("category");
			$categories = $this->foreignModel->searchQuestion($toSearch);			
			$arr[$index] = $res[$i];
			$arr[$index]['question'] = html_entity_decode($res[$i]['question']);
			$arr[$index]['answer'] = html_entity_decode($res[$i]['answer']);
			$arr[$index]['choice2'] = html_entity_decode($res[$i]['choice2']);
			$arr[$index]['choice3'] = html_entity_decode($res[$i]['choice3']);
			$arr[$index]['choice4'] = html_entity_decode($res[$i]['choice4']);
			$arr[$index]['category'] = $categories[0]['name'];
			switch ($arr[$index]['level']) {
				case 1:
					$arr[$index]['levelName'] = "Basic";
					break;
				case 2:
					$arr[$index]['levelName'] = "Medium";
					break;
				case 3:
					$arr[$index]['levelName'] = "Hard";
					break;
			}
			if($arr[$index]['passageId'] > 0) {
				$this->setForeignModel("QuestionModel");
				$this->foreignModel->setTable("passage");
				$co = $this->foreignModel->searchQuestion(array('id' => $arr[$index]['passageId']));
				if(count($co) > 0) {
					$arr[$index]['containPassage'] = 1;
					$arr[$index]['passageId'] = $co[0]['id'];
					$arr[$index]['passageTitle'] = $co[0]['passageTitle'];
					$arr[$index]['passage'] = html_entity_decode($co[0]['passage']);
				}else {
					$arr[$index]['containPassage'] = 0;
				}
			}else {
				$arr[$index]['containPassage'] = 0;
			}
			$index++;
		}

		if(count($arr) >= 1){
			$result['status'] = 1;
		}
		$result['data'] = $arr;
		$result['success'] = ($result['status'] == 1) ? true : false;
		$result['draw'] = $_POST['draw'];
		$totalCategories = count($this->model->getAllQuestion());
		$result['recordsTotal'] = $totalCategories;
		$result['recordsFiltered'] = $total;
		unset($_POST);
		return print json_encode($result);
	}

	private function deleteQuestion($result) {
		$this->setForeignModel('QuestionModel');
		$this->foreignModel->setTable('passage');
		if(!isset($_POST['id'])) {
			$result['error'] = array("Invalid selection.");
			$result['status'] = 0;
		}else {
			$idToDel = Input::get('id');
			$dataToSearch = array('id' => $idToDel);
			$res = $this->model->searchQuestion($dataToSearch);
			if(count($res) >= 1) {
				$out = $this->model->deleteQuestion($idToDel);
				if($res[0]['passageId'] >= 1) {
					$co = $this->model->searchQuestion(array('passageId' => $res[0]['passageId']));
					if(count($co) < 1) {
						$this->foreignModel->deleteQuestion($res[0]['passageId']);
					}
				}
				if($out == 1) {
					$result['status'] = 1;
				}else {
					$result['error'] = array("Connection Problem with server.");
					$result['status'] = 0;
				}
			}else {
				$result['error'] = array("No such question found.");
				$result['status'] = 0;
			}
		}
		$result['success'] = ($result['status'] == 1) ? true : false;
		unset($_POST);
		return print json_encode($result);
	}

	private function updateQuestion($result) {
		$this->setForeignModel('QuestionModel');
		$this->foreignModel->setTable('passage');
		$data = array();
		foreach ($_POST as $key => $value) {
			$data[$key] = Input::get($key);
		}
		$validate = new Validator();
		$validation = $validate->check($_POST, array(
			'question' => array(
				'name' => 'Question',
				'required' => true,
				'min' => 1,
				'max' => 10000
			),
			'answer' => array(
				'name' => 'Answer',
				'required' => true,
				'min' => 1,
				'max' => 2000
			),
			'choice2' => array(
				'name' => '2nd. Choice',
				'required' => true,
				'min' => 1,
				'max' => 2000
			),
			'choice3' => array(
				'name' => '3rd. Choice',
				'required' => true,
				'min' => 1,
				'max' => 2000
			),
			'choice4' => array(
				'name' => '4th. Choice',
				'required' => true,
				'min' => 1,
				'max' => 2000
			)
		));
		if(Input::get('level') <= 0 || Input::get('minLevel') > 3 ) $validate->addError("Level isnot valid!");
		if(Input::get('categoryId') <= 0) $validate->addError("Category not valid!");
		if(Input::get('programId') <= 0) $validate->addError("Program not valid!");

		$allAns = array($_POST['answer'],$_POST['choice2'],$_POST['choice3'],$_POST['choice4']);
		if(count(array_unique($allAns)) < 4) {
			$validate->addError("Duplicate answers");
		}

		if(Input::get('containPassage') == 1) {
			if(Input::get('passageId') == -1) {
				$validation = $validate->check($_POST, array(
				'passageTitle' => array(
					'name' => 'Passage Title',
					'required' => true,
					'min' => 1,
					'max' => 50
				),
				'passage' => array(
					'name' => 'Passage Content',
					'required' => true,
					'min' => 1,
					'max' => 10000
				)));
				$toAdd = array();
				$toAdd['passage'] = Input::get('passage');
				$toAdd['passageTitle'] = Input::get('passageTitle');
				$idToCheck = Input::get('passageId');
				$thePassage = $this->foreignModel->searchQuestion($toAdd);
				if(count($thePassage) > 0) {
					$validate->addError("Passage you want to create already exists");
				}
			}else {
				$idToCheck = Input::get('passageId');
				$thePassage = $this->foreignModel->searchQuestion(array('id' => $idToCheck));
				if(count($thePassage) == 0) {
					$validate->addError("Passage selected doesnot exist anymore.");
				}
			}
		}
		if($validate->passed()){
			$dataForSearch = array('id' => $data['id']);
			$res = $this->model->searchQuestion($dataForSearch);
			if(count($res) >= 1) {
				$idToChange = $data['id'];
				unset($data['id']);
				$resultConf = 0;
				$change = 0;
				if(Input::get('containPassage') == 1) {
					$toAdd = array();
					$toAdd['passage'] = Input::get('passage');
					$toAdd['passageTitle'] = Input::get('passageTitle');
					if(Input::get('passageId') == -1) {
						$resultConf = $this->foreignModel->registerQuestion($toAdd);
						$data['passageId'] = $resultConf;
					}else {
						$resultConf = 1;
						$change = $this->foreignModel->updateQuestion(Input::get('passageId'), $toAdd);
					}
				}else {
					$resultConf = 1;
					$data['passageId'] = null;
				}
				unset($data['containPassage']);
				unset($data['passage']);
				unset($data['passageTitle']);
				if($resultConf > 0) {
					$ret = $this->model->updateQuestion($idToChange, $data);
					if($res[0]['passageId'] >= 1) {
						$co = $this->model->searchQuestion(array('passageId' => $res[0]['passageId']));
						if(count($co) < 1) {
							$this->foreignModel->deleteQuestion($res[0]['passageId']);
						}
					}
					if($ret == 1 || $change != 0) {
						$result['status'] = 1;
						$result['success'] = true;
					} else {
						$result['status'] = -1;
						$result['errors'] = $validate->addError("Nothing updated!");
					}
				}else {
					$result['status'] = -1;
					$result['errors'] = $validate->addError("Problem with passage table!");
				}							
			} else {
				$result['errors'] = $validate->addError("No such category found.");
				$result['status'] = 0;
			}
		} else {
			$result['status'] = 0;
		}
		if($result['status'] == 0 || $result['status'] == -1) {
			$result['errors'] = $validate->errors();
			$result['success'] = false;
		}
		unset($_POST);
		return print json_encode($result);
	}

	private function addQuestion($result){
		$this->setForeignModel('QuestionModel');
		$this->foreignModel->setTable('passage');
		$validate = new Validator();
		$validation = $validate->check($_POST, array(
			'question' => array(
				'name' => 'Question',
				'required' => true,
				'min' => 1,
				'max' => 10000
			),
			'answer' => array(
				'name' => 'Answer',
				'required' => true,
				'min' => 1,
				'max' => 2000
			),
			'choice2' => array(
				'name' => '2nd. Choice',
				'required' => true,
				'min' => 1,
				'max' => 2000
			),
			'choice3' => array(
				'name' => '3rd. Choice',
				'required' => true,
				'min' => 1,
				'max' => 2000
			),
			'choice4' => array(
				'name' => '4th. Choice',
				'required' => true,
				'min' => 1,
				'max' => 2000
			),
			'level' => array(
				'name' => 'Level',
				'minLevel' => 0,
				'maxLevel' => 3
			)
		));

		$allAns = array($_POST['answer'],$_POST['choice2'],$_POST['choice3'],$_POST['choice4']);
		if(count(array_unique($allAns)) < 4) {
			$validate->addError("Duplicate answers");
		}

		if(Input::get('programId') <= 0) $validate->addError("Program not valid!");
		if(Input::get('categoryId') <= 0) $validate->addError("Category not valid!");

		if(Input::get('containPassage') == 1) {
			if(Input::get('passageId') == -1) {
				$validation = $validate->check($_POST, array(
				'passageTitle' => array(
					'name' => 'Passage Title',
					'required' => true,
					'min' => 1,
					'max' => 50
				),
				'passage' => array(
					'name' => 'Passage Content',
					'required' => true,
					'min' => 1,
					'max' => 10000
				)));
				$toAdd = array();
				$toAdd['passage'] = Input::get('passage');
				$toAdd['passageTitle'] = Input::get('passageTitle');
				$idToCheck = Input::get('passageId');
				$thePassage = $this->foreignModel->searchQuestion($toAdd);
				if(count($thePassage) > 0) {
					$validate->addError("Passage you want to create already exists");
				}
			} else {
				$idToCheck = Input::get('passageId');
				$thePassage = $this->foreignModel->searchQuestion(array('id' => $idToCheck));
				if(count($thePassage) == 0) {
					$validate->addError("Passage selected doesnot exist anymore.");
				}
			}
		}
		if($validate->passed()){
			$data = array();
			$data['id'] = null;
			foreach ($_POST as $key => $value) {
				$data[$key] = Input::get($key);
			}

			$resultConf = 0;
			if(Input::get('containPassage') == 1) {
				if(Input::get('passageId') == -1) {
					$toAdd = array();
					$toAdd['passage'] = Input::get('passage');
					$toAdd['passageTitle'] = Input::get('passageTitle');
					$resultConf = $this->foreignModel->registerQuestion($toAdd);
					$data['passageId'] = $resultConf;
				}else {
					$resultConf = 1;
				}
			}else {
				$resultConf = 1;
				$data['passageId'] = null;
			}
			unset($data['containPassage']);
			unset($data['passage']);
			unset($data['passageTitle']);
			if($resultConf > 0) {
				$id = $this->model->registerQuestion($data);
				if($id != 0){
					$result['status'] = 1;
					$result['success'] = true;
				}else{
					$result['status'] = -1;
					$result['errors'] = $validate->addError("Problem with connection to server!");
				}
			}else {
				$result['status'] = -1;
				$result['errors'] = $validate->addError("Problem with passage table!");
			}			
		} else {
			$result['status'] = 0;
		}
		if($result['status'] == 0 || $result['status'] == -1) {
			$result['errors'] = $validate->errors();
			$result['success'] = false;
		} 
		unset($_POST);
		return print json_encode($result);			
	}

}

?>