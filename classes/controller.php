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
				$month = $this->request['monat'];  
				$entries = Model::getOverview(time(), $month, $view);
				$view->setTemplate('default');
		}
		$this->view->setTemplate('overview');
		return $this->view->loadTemplate();
	}
}
?>