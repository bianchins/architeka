<?php
final class template {

	public $data = array();

	private $registry = null;

	private $session = null;

	public function __construct($registry) {
		$this->registry=$registry;
		$this->session = $registry->get('session');
	}

	public function load($templatefilename) {
		if (file_exists($templatefilename)) {
			extract($this->data);

			ob_start();
			include($templatefilename);
			$content = ob_get_contents();

			ob_end_clean();

			return $content;
		} else {
			exit('Error: Could not load template ' . $templatefilename . '!');
		}

	}

	public function render($content) {

		echo $content;

	}

}


?>