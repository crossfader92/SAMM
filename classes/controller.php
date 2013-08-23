<?php
class Controller{

	private $request = null;
	private $template = '';
	private $view = null;

	/**
	 * constructor, creates the controller.
	 *
	 * @param Array $request Array of $_GET & $_POST.
	 */
	public function __construct($request){
		$this->view = new View();
		$this->request = $request;
		$this->template = !empty($request['view']) ? $request['view'] : 'default';
	}
	
	

	/**
	 * mothod for providing the content
	 *
	 * @return String content of the application.
	 */
	public function display(){
		$view = new View();
		switch($this->template){
				
			case 'default':
			default:
				$month =  date('m.Y', time());
				$finance = Model::getfinance("Jan,Kevin", $month);
				$allmonth = Model::getAllMonth();
				$conclusion = Model::getSchuldenFazit($finance);
				
				$view->assign('conclusion', $conclusion);
				$view->assign('allmonth', $allmonth);
				$view->assign('finance', $finance );
				$view->setTemplate('default');
		}
		$view->setTemplate('overview');
		return $view->loadTemplate();
	}
}
?>