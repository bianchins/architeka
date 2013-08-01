<?php
final class User {
	private $user_id;
	private $username;
	private $permission;
	private $db;
	private $request;
	private $session;
	private $client_of;
	private $firstname;
	private $lastname;
	private $email;
	private $birthdate;
	private $phone;
	private $notify_on_entry;
	private $title;
	private $project_limit;
	private $datiFatturazione;
	private $isCollaborator;

	public function __construct($registry) {
		$this->db = $registry->get('db');
		$this->request = $registry->get('request');
		$this->session = $registry->get('session');

		if (isset($this->session->data['user_id'])) {
			$user_query = $this->db->query("SELECT * FROM tab_user WHERE user_id = '" . (int)$this->session->data['user_id'] . "'");

			if ($user_query->num_rows) {
				$this->user_id = $user_query->row['user_id'];
				$this->username = $user_query->row['username'];
				$this->permission = $user_query->row['permission'];
				$this->client_of = $user_query->row['client_of'];
				$this->firstname = $user_query->row['firstname'];
				$this->lastname = $user_query->row['lastname'];
				$this->email = $user_query->row['email'];
				$this->birthdate = $user_query->row['birthdate'];
				$this->phone = $user_query->row['phone'];
				$this->photo = $user_query->row['photo'];
				$this->notify_on_entry = $user_query->row['notify_on_entry'];
				$this->title = $user_query->row['title'];
				$this->isCollaborator = $user_query->row['isCollaborator'];

				//Qui carico anche la scadenza della subscription e il limite massimo di progetti che ha 
				$subscription_query = $this->db->query("SELECT * FROM tab_subscription WHERE subscription_user_id = '" . (int)$this->user_id . "'");
				if ($subscription_query->num_rows) {
					$this->project_limit=$subscription_query->row['subscription_project_limit'];
					$this->datiFatturazione['piva']=$subscription_query->row['subscription_piva'];
					$this->datiFatturazione['intestatario_fattura']=$subscription_query->row['subscription_intestatario_fattura'];
					$this->datiFatturazione['cod_fisc']=$subscription_query->row['subscription_codfisc'];
				}
				else 
					$this->project_limit = DEFAULT_PROJECT_LIMIT;
				
				if($this->request->server['REMOTE_ADDR']!=$user_query->row['ip']) {
				
					$this->db->query("UPDATE tab_user SET ip = '" . $this->db->escape($this->request->server['REMOTE_ADDR']) . "' WHERE user_id = '" . (int)$this->session->data['user_id'] . "'");

				}
				//$user_group_query = $this->db->query("SELECT permission FROM tab_user_group WHERE user_group_id = '" . (int)$user_query->row['user_group_id'] . "'");


			} else {
				$this->logout();
			}
		}
	}

	/*
	 * Elimino l'utente selezionato
	 */
	public function delete($user_id) {
		$this->db->query("DELETE FROM tab_user WHERE user_id = '" . $this->db->escape($user_id) . "'");
		$this->db->query("DELETE FROM tab_user_project WHERE corr_user_id = '" . $this->db->escape($user_id) . "'");
	}
	
	/*
	 * Inserisco un nuovo utente cliente, controllando se l'username esiste gia'
	 */
	public function insert($client_of, $firstname, $lastname, $username, $password, $phone, $email, $birthdate, $photo, $title, $isCollaborator=0) {
		//controllo se username esiste gia'	
		$username_query = $this->db->query("SELECT user_id FROM tab_user WHERE username = '" . $this->db->escape($username) . "'");
		
		$professionista_query = $this->db->query("SELECT title, firstname, lastname FROM tab_user WHERE user_id='".$client_of."'");
		
			if ($username_query->num_rows) {
				unset($username_query);
				return false;	
			} else {
				$insert_query = $this->db->query("INSERT INTO tab_user(username,firstname,lastname,client_of,password,phone,email,birthdate,photo,title,isCollaborator) VALUES('".$this->db->escape($username)."','".$this->db->escape($firstname)."','".$this->db->escape($lastname)."','".$this->db->escape($client_of)."','".md5($password)."','".$this->db->escape($phone)."','".$this->db->escape($email)."','".$this->db->escape($birthdate)."','".$photo."', '".$this->db->escape($title)."','".$isCollaborator."')");
				$professionista='';
				if($professionista_query->num_rows) {
					$riga=$professionista_query->row;				
					$professionista = $riga['title'].' '.$riga['firstname'].' '.$riga['lastname'];
				}
				if($insert_query) { 										
					$m = new Mail();
					$m->setTo($email);
					$m->setSender('Architeka');
					$m->setFrom('no-reply@architeka.it');
					if($professionista!='') {
						$m->setSubject('Benvenuto in Architeka! Sei stato registrato da '.$professionista);
						$m->setText('Ciao '.$firstname.' '.$lastname.', '.$m->newline.'benvenuto in architeka! Sei stato registrato da '.$professionista.'. Puoi collegarti al sito '.SITE_URL.' e seguire subito i tuoi progetti, utilizzando:'.$m->newline.'utente: '.$username.$m->newline.'password: '.$password.$m->newline.$m->newline.$m->newline.'Architeka is a product of Simplenetworks s.r.l');
					}
					else {
						$m->setSubject('Benvenuto in Architeka!');
						$m->setText('Ciao '.$firstname.' '.$lastname.', '.$m->newline.'benvenuto in architeka! Puoi collegarti al sito '.SITE_URL.' e seguire subito i tuoi progetti, utilizzando:'.$m->newline.'utente: '.$username.$m->newline.'password: '.$password.$m->newline.$m->newline.$m->newline.'Architeka is a product of Simplenetworks s.r.l');
					}
					$m->send();
					return $this->db->getLastId();
				}
				else return false;
			}
	}

	/*
	 * Inserisco un nuovo utente professionista, controllando se l'username esiste gia'
	 */
	public function insertArchitect($firstname, $lastname, $username, $password, $phone, $email, $birthdate, $photo, $title, $subscription_expire, $subscription_piva, $subscription_codfisc, $subscription_intestatario_fattura, $subscription_numfattura) {
		//controllo se username esiste gia'	
		$username_query = $this->db->query("SELECT user_id FROM tab_user WHERE username = '" . $this->db->escape($username) . "'");
	
			if ($username_query->num_rows) {
				unset($username_query);
				return false;	
			} else {
				$insert_query = $this->db->query("INSERT INTO tab_user(username,firstname,lastname,client_of,password,phone,email,birthdate,photo,title) VALUES('".$this->db->escape($username)."','".$this->db->escape($firstname)."','".$this->db->escape($lastname)."','0','".md5($password)."','".$this->db->escape($phone)."','".$this->db->escape($email)."','".$this->db->escape($birthdate)."','".$photo."', '".$this->db->escape($title)."')");
				if($insert_query) { 										
					$last_id=$this->db->getLastId();
					//Inserisco nella tabella abbonamenti
					$subs_query = $this->db->query("INSERT INTO tab_subscription(subscription_expire ,subscription_type, subscription_user_id, subscription_project_limit,subscription_piva,subscription_codfisc,subscription_intestatario_fattura ,subscription_numfattura ,subscription_datafattura) VALUES('".$subscription_expire."','0','".$last_id."','".DEFAULT_PROJECT_LIMIT."','".$this->db->escape($subscription_piva)."','".$this->db->escape($subscription_codfisc)."','".$this->db->escape($subscription_intestatario_fattura)."','".$this->db->escape($subscription_numfattura)."','0000-00-00')");
					
					$m = new Mail();
					$m->setTo($email);
					$m->setSender('Architeka');
					$m->setFrom('no-reply@architeka.it');
					$m->setSubject('Benvenuto in Architeka!');
					$m->setText('Ciao '.$firstname.' '.$lastname.', '.$m->newline.'benvenuto in architeka! Puoi collegarti al sito '.SITE_URL.' e seguire subito i tuoi progetti, utilizzando:'.$m->newline.'utente: '.$username.$m->newline.'password: '.$password.$m->newline.$m->newline.$m->newline.'Architeka is a product of Simplenetworks s.r.l');
					$m->send();
					
					return  $last_id;
				}
				else return false;
			}
	}
	
	/*
	 * Aggiorno l'utente
	 */
	public function update($user_id, $firstname, $lastname, $newpassword, $oldpassword, $phone, $email, $birthdate,$notify_on_entry,$photo,$title) {
		if($newpassword!="") {
			$user_query = $this->db->query("SELECT user_id,username FROM tab_user WHERE user_id = '" . $this->db->escape($user_id) . "' AND password = '" . $this->db->escape(md5($oldpassword)) . "'");
	
			if ($user_query->num_rows) {
				//Vecchia password verificata, procedo con l'update
				unset($user_query);
				if($photo!="")
					$update_query = $this->db->query("UPDATE tab_user SET firstname='" . $this->db->escape($firstname) . "', lastname='" . $this->db->escape($lastname) . "', email='" . $this->db->escape($email) . "', birthdate='" . $this->db->escape($birthdate) . "', phone='" . $this->db->escape($phone) . "', password='" . $this->db->escape(md5($newpassword)) . "', notify_on_entry='".$this->db->escape($notify_on_entry)."', photo='".$photo."', title='".$this->db->escape($title)."' WHERE user_id='" . $this->db->escape($user_id) . "'");
				else
					$update_query = $this->db->query("UPDATE tab_user SET firstname='" . $this->db->escape($firstname) . "', lastname='" . $this->db->escape($lastname) . "', email='" . $this->db->escape($email) . "', birthdate='" . $this->db->escape($birthdate) . "', phone='" . $this->db->escape($phone) . "', password='" . $this->db->escape(md5($newpassword)) . "', notify_on_entry='".$this->db->escape($notify_on_entry)."', title='".$this->db->escape($title)."' WHERE user_id='" . $this->db->escape($user_id) . "'");
				if($update_query) return true;
				else return false;
			}
		}
		else {
			if($photo!="")
				$update_query = $this->db->query("UPDATE tab_user SET firstname='" . $this->db->escape($firstname) . "', lastname='" . $this->db->escape($lastname) . "', email='" . $this->db->escape($email) . "', birthdate='" . $this->db->escape($birthdate) . "', phone='" . $this->db->escape($phone) . "', notify_on_entry='".$this->db->escape($notify_on_entry)."', photo='".$photo."', title='".$this->db->escape($title)."' WHERE user_id='" . $this->db->escape($user_id) . "'");
			else
				$update_query = $this->db->query("UPDATE tab_user SET firstname='" . $this->db->escape($firstname) . "', lastname='" . $this->db->escape($lastname) . "', email='" . $this->db->escape($email) . "', birthdate='" . $this->db->escape($birthdate) . "', phone='" . $this->db->escape($phone) . "', notify_on_entry='".$this->db->escape($notify_on_entry)."', title='".$this->db->escape($title)."' WHERE user_id='" . $this->db->escape($user_id) . "'");
			if($update_query) return true;
			else return false;			
		}
	}
	
	/*
	 * Aggiorno l'utente
	 */
	public function updateCustomer($user_id, $firstname, $lastname, $email, $birthdate, $title, $indirizzo, $cap, $comune, $provincia, $phone) {			
		$check_query = $this->db->query("SELECT user_id FROM tab_user WHERE user_id='".$this->db->escape($user_id)."' AND client_of='".$this->user_id."'");
		//Controllo che il cliente sia del professionista che lo sta modificando
		if ($check_query->num_rows) {		
			$update_query = $this->db->query("UPDATE tab_user SET firstname='" . $this->db->escape($firstname) . "', lastname='" . $this->db->escape($lastname) . "', email='" . $this->db->escape($email) . "', birthdate='" . $this->db->escape($birthdate) . "', phone='" . $this->db->escape($phone) . "', title='".$this->db->escape($title)."', indirizzo='".$this->db->escape($indirizzo)."', cap='".$this->db->escape($cap)."', comune='".$this->db->escape($comune)."', provincia='".$this->db->escape($provincia)."' WHERE user_id='" . $this->db->escape($user_id) . "'");
			if($update_query) return true;
			else return false;
		}
		return false;
	}
	
	/**
	 * 
	 * Ottengo le informazioni su uno specifico utente
	 * @param int $user_id
	 */
	public function getSpecificUser($user_id) {
		$user_query = $this->db->query("SELECT * FROM tab_user WHERE user_id='".$this->db->escape($user_id)."'");

		if ($user_query->num_rows) {
			return $user_query->row;
		}		
	}
	
	/**
	 * Aggiorno le informazioni di fatturazione
	 * @param unknown_type $user_id
	 * @param unknown_type $piva
	 * @param unknown_type $intestatario_fattura
	 * @param unknown_type $cod_fisc
	 */
	public function updateBillInformation($user_id,$piva,$intestatario_fattura,$cod_fisc) {
		$update_query = $this->db->query("UPDATE tab_subscription SET subscription_piva='" . $this->db->escape($piva) . "', subscription_intestatario_fattura='" . $this->db->escape($intestatario_fattura) . "', subscription_codfisc='" . $this->db->escape($cod_fisc) . "' WHERE subscription_user_id='" . $this->db->escape($user_id) . "'");
		if($update_query) return true;
		else return false;	
	}
	
	/*
	 * Funzione di login
	 */
	public function login($username, $password) {
		
		$user_query = $this->db->query("SELECT user_id,username,client_of FROM tab_user WHERE username = '" . $this->db->escape($username) . "' AND password = '" . $this->db->escape(md5($password)) . "'");

		if ($user_query->num_rows) {
			/**
			 * Codice controllo data di scadenza abbonamento
			 * Commentato: il professionista paga per progetto, non ha limiti di tempo
				
			if ($user_query->row['client_of']==0) {
				
				$subscription_query = $this->db->query("SELECT subscription_expire FROM tab_subscription WHERE subscription_user_id = '" . $user_query->row['user_id'] . "'");

				//Se non trovo corrispondenza sulla tabella abbonamenti per ora me ne frego...
				if ($subscription_query->num_rows) {
					//Qui controllo se il professionista ha pagato la licenza
					
					$interval = strtotime(date("Y-m-d")) - strtotime($subscription_query->row['subscription_expire']);
					if($interval>0) {
						//E' scaduta la licenza
						return false;
					}
				}				
			}
			*/
			$this->session->data['user_id'] = $user_query->row['user_id'];

			$this->user_id = $user_query->row['user_id'];
			$this->username = $user_query->row['username'];


			return true;
		} else {
			return false;
		}
	}

	public function logout() {
		unset($this->session->data['user_id']);

		$this->user_id = '';
		$this->username = '';
		
		session_destroy();
		
	}
	
	public function emailExist($email) {		
		$user_query = $this->db->query("SELECT user_id FROM tab_user WHERE email = '" . $this->db->escape($email) . "'");
		if ($user_query->num_rows) {
			return true;
		} else {
			return false;
		}
	}
	
	public function getClients() {
		$user_query = $this->db->query("SELECT * FROM tab_user WHERE client_of='".$this->user_id."' AND isCollaborator=0");

		if ($user_query->num_rows) {
			return $user_query->rows;
		}
	}

	public function getCollaborators() {
		$user_query = $this->db->query("SELECT * FROM tab_user WHERE client_of='".$this->user_id."' AND isCollaborator=1");

		if ($user_query->num_rows) {
			return $user_query->rows;
		}
	}
	
	public function regeneratePassword($email) {
		$newpassword=$this->generatePassword(8,4);
		$update_query = $this->db->query("UPDATE tab_user SET password='".md5($newpassword)."' WHERE email='".$this->db->escape($email)."'");
		if($update_query) return $newpassword;
		else return false;
	}

	public function getPermission() {
		return $this->permission;
	}
	
	public function clientOf() {
		return $this->client_of;
	}

	public function isCollaborator() {
		return $this->isCollaborator;
	}
	
	public function isLogged() {
		return $this->user_id;
	}

	public function getId() {
		return $this->user_id;
	}

	public function getUserName() {
		return $this->username;
	}
	
	public function getFirstname() {
		return $this->firstname;
	}
	
	public function getLastname() {
		return $this->lastname;
	}
	
	public function getBirthdate() {
		return $this->birthdate;
	}
	
	public function getEmail() {
		return $this->email;
	}
	
	public function getPhone() {
		return $this->phone;
	}
	
	public function getProjectLimit() {
		return $this->project_limit;
	}
	
	public function getTitle() {
		return $this->title;
	}
	
	public function getPhoto() {
		return $this->photo;
	}
	
	public function getNotifyOnEntry() {
		return $this->notify_on_entry;
	}
	
	private function generatePassword($length=9, $strength=0) {
	$vowels = 'aeuy';
	$consonants = 'bdghjmnpqrstvz';
	if ($strength & 1) {
		$consonants .= 'BDGHJLMNPQRSTVWXZ';
	}
	if ($strength & 2) {
		$vowels .= "AEUY";
	}
	if ($strength & 4) {
		$consonants .= '23456789';
	}
	if ($strength & 8) {
		$consonants .= '@#$%';
	}
 
	$password = '';
	$alt = time() % 2;
	for ($i = 0; $i < $length; $i++) {
		if ($alt == 1) {
			$password .= $consonants[(rand() % strlen($consonants))];
			$alt = 0;
		} else {
			$password .= $vowels[(rand() % strlen($vowels))];
			$alt = 1;
		}
	}
	return $password;
	}
	
	public function check_email_mx($email) { 
		$pattern = "/^[\w-]+(\.[\w-]+)*@";
    	$pattern .= "([0-9a-z][0-9a-z-]*[0-9a-z]\.)+([a-z]{2,4})$/i";
		if( (preg_match($pattern,$email)) ) { 
		return true;
	}
	return false;
}
	public function getDatiFatturazione($key) {
		return $this->datiFatturazione[$key];
	}	
}
?>