<?php
/*
 * Classe forceDownload
 * @author Maurizio Tarchini (modificato da Stefano Bianchini)
 * @link http://www.mtxweb.ch/php_learn/?p=1137
 * 
 * wrapper per lo scaricamento degli allegati / immagini dei progetti di architeka
 * 
 * Esempio d'uso:
 * $download = new forceDownload($_GET['file']);
 * $download->_allowedExtensions = "pdf,txt";
 * $download->_allowedPath = "files/download";
 * $download->DownloadWithFilter();
 * 
 */ 
class forceDownload
{
	public $_allowedPath;
	public $_allowedFiles;
	public $_allowedExtensions;
	protected $fileName;
 
		public function __construct($fileName)
		{
			$this->fileName = $fileName;
		}	
 
		private function DownloadThisFile($file)
		{
 
			header("Cache-Control: public");
			header("Content-type: application/octet-stream");  
			header("Content-Length: " . filesize($file));  
			header("Content-Disposition: attachment; filename= " . basename($file));
 			
			readfile($file);
		}
 
		public function DownloadWithFilter()
		{
			$control = 0;
			$file = basename($this->fileName);
			$path = dirname($this->fileName);
 
			if(!file_exists($this->fileName))
			{
				die("Il file richiesto non esiste nella posizione");
			}
 
			if(isset($this->_allowedFiles))
			{
				$control = 1;
 
				$files = explode("," , $this->_allowedFiles);
 
				if(!in_array($file, $files))
				{
					die("Nome file non presente nella lista!");
				}
			}
 
			if(isset($this->_allowedExtensions))
			{
				$control = 1;
 
				$ext = explode("," , $this->_allowedExtensions);
 
				//$fileNameExtension = end(explode(".", $file));
				$fileNameExtension = explode(".", $file);
				$fileNameExtension = $fileNameExtension[count($fileNameExtension)-1];
				
 
				if(!in_array($fileNameExtension, $ext))
				{
					die("Estensione non abilitata per il download");
				}
			}
 
			if(isset($this->_allowedPath))
			{
				$control = 1;
 
				$paths = explode("," , $this->_allowedPath);
 
				if(!in_array($path,$paths))
				{
					die("Il file si trova in una cartella non abilitata al download");
				}
			}
 
			if(!$control)
			{
				die("Devi mettere almeno un controllo");
			}
 
			$this->DownloadThisFile($this->fileName);
 
		}
 
}
 
?>