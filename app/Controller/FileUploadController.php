<?php

class FileUploadController extends AppController {
	public function index() {

		if ($this->request->isPost()) {

			if (isset($this->request->data['FileUpload']['data'])) {

				$file = $this->request->data['FileUpload']['data'];	

				if (!file_exists($file['tmp_name'])) {
					$this->setFlash('File not found');
				} else {
					// mime
					$finfo = finfo_open( FILEINFO_MIME_TYPE );
					$mtype = finfo_file( $finfo, $file['tmp_name'] );
					finfo_close( $finfo );
					$mimes = array('application/vnd.ms-excel','text/plain','text/csv');

					// extension
					$ary_ext=array('csv'); //array of allowed extensions
					$ext = substr(strtolower(strrchr($file['name'], '.')), 1); //get the extension
					
					// mime type check
					if(!in_array($mtype,$mimes)) {
						$this->setFlash('MIME type not allowed');
					} else if(!in_array($ext, $ary_ext)) { 
						$this->setFlash('Invalid file extension');
					} else {
						$dest_file = DS . WWW_ROOT . 'files' . DS .'uploaded' . DS;
						$filename = $dest_file . time() . $file['name'];
						move_uploaded_file($file['tmp_name'], $filename);
						// $file = fopen($filename,"r");
						// fclose($file);
						$this->migrateUser($filename);
						$this->setFlash('Uploaded');
					}
				}
			}
		}

		$this->set('title', __('File Upload Answer'));

		$file_uploads = $this->FileUpload->find('all');
		$this->set(compact('file_uploads'));	
	}

	private function migrateUser($csvFile) {
		$splFileObject = new SplFileObject($csvFile, 'rb');
		$splFileObject->setFlags(
			\ SplFileObject :: SKIP_EMPTY |
			\ SplFileObject :: READ_AHEAD
		);

		$line = explode("\r", $splFileObject);

		// var_dump($line);
		// exit;

		foreach ($line as $row => $val) {

			if ($row == 0) {
				continue;
			}
			
			$user = explode(",", $val);
			$new_user = Array(
				'name' => $user[0],
				'email' => $user[1],
				'created' => date("Y-m-d H:i:s"),
				'modified' => date("Y-m-d H:i:s")
			);

			// print_r($new_user);
			$this->FileUpload->clear();
			$this->FileUpload->save($new_user);
		}
	}
}