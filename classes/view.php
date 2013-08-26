<?php
class View{

	// path for the template
	private $path = 'templates';
	// name of the default template
	private $template = 'overview';

	/**
	 * Contains are vars that are used for the template
	 * empty at first!
	 */
	private $_ = array();

	/**
	 * assigns vars to keys
	 *
	 * @param String $key key
	 * @param String $value var
	 */
	public function assign($key, $value){
		$this->_[$key] = $value;
	}


	/**
	 * sets the name of the template
	 *
	 * @param String $template name of the template
	 */
	public function setTemplate($template = 'default'){
		$this->template = $template;
	}


	/**
	 * load the tempalte file and return it
	 *
	 * @param string $tpl name of the template
	 * @return string output of the template (sourcecode)
	 */
	public function loadTemplate(){
		$tpl = $this->template;
		// Pfad zum Template erstellen & überprüfen ob das Template existiert.
		$file = $this->path . DIRECTORY_SEPARATOR . $tpl . '.php';
		$exists = file_exists($file);

		if ($exists){
			// Der Output des Scripts wird n einen Buffer gespeichert, d.h.
			// nicht gleich ausgegeben.
			ob_start();

			// Das Template-File wird eingebunden und dessen Ausgabe in
			// $output gespeichert.
			include $file;
			$output = ob_get_contents();
			ob_end_clean();
				
			// Output zurückgeben.
			return $output;
		}
		else {
			// Template-File existiert nicht-> Fehlermeldung.
			return 'could not find template';
		}
	}
}
?>
