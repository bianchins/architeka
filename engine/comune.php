<?php
/**
 *
 * @author Stefano Bianchini
 *
 */
class comune {

	private $registry;

	public function __construct($registry) {
		$this->registry=$registry;
		$this->db=$registry->get('db');

	}
	
	public function loadList() {
	$entry_query = $this->db->query("SELECT istat_num, denominazione, sigla FROM tab_comuni JOIN tab_province ON tab_comuni.codice_provincia=tab_province.codice_provincia ORDER BY denominazione ASC");
		if ($entry_query->num_rows) {
			return $entry_query->rows;
		}
		else {
			return NULL;
		}
	}
	
}
?>