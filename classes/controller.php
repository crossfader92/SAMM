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
			case 'entry':
				$view->setTemplate('entry');
				$entryid = $this->request['id'];
				$entry = Model::getEntry($entryid);
				$view->assign('title', $entry['title']);
				$view->assign('content', $entry['content']);
				break;
				
			case 'default':
			default:
				$entries = Model::getOverview();
				$view->setTemplate('default');
				$view->assign('entries', $entries);
		}
		$this->view->setTemplate('theblog');
		$this->view->assign('blog_title', 'Der Titel des Blogs');
		$this->view->assign('blog_footer', 'Ein Blog von und mit MVC');
		$this->view->assign('blog_content', $view->loadTemplate());
		return $this->view->loadTemplate();
	}
}
?>