<?php
class UpdateOrInsert {
	private $table = null;
	private $primaryKey = null;
	private $keys = array();
	
	private $updateReq = array('Begin' => '', 'End' => '');
	private $insertReq = null;
	
	private $queryReady = array('Update' => false, 'Insert' => false);
	
	private $primaryKeyValues = array();
	
	private $updateDatas = array();
	private $insertDatas = array();
	
	private $params = array('Alias' => '', 'Value' => '');
	
	/* *********************************************************** */
	
	public function __construct($table, $primaryKey) {
		$this->table = $table;
		$this->primaryKey = $primaryKey;
	}
	
	public function setColumnsName(array $names) {
		try {
			if(empty($names)) throw new Exception('Liste du nom des colonnes ne doit pas etre vide.');
		
			$this->keys = $names;
		}
		catch(Exception $e) {
			throw $e;
		}
	}
	
	public function setPrimaryKeyValues(array $tab) {
		try {
			if(empty($tab)) throw new Exception('Liste des valeurs de la clé primaire "' . $this->primaryKey . '" ne doit pas vide.');
			
			$this->primaryKeyValues = explode('-##-', implode('-##-', $tab));
		}
		catch(Exception $e) {
			throw $e;
		}
	}
	
	public function setNewDatas(array $tab) {
		try {
			if(empty($tab)) throw new Exception('Le tableau d\'entré ne doit pas etre vide.');
			else {
				foreach($tab AS $id=>$line) {
					if(!isset($line[$this->primaryKey])) throw new Exception('La ligne ' . $id . ' du tableau d\'entré ne contient pas de valeur pour la clé primaire.');
				}
			}
			
			if(empty($this->keys)) $this->setColumnsName($tab[0]);
			$this->setUpdateAndInsertDatas($tab);
		}
		catch(Exception $e) {
			throw $e;
		}
	}
	
	public function initRequests() {
		try {
			if(empty($this->keys)) throw new Exception('Nom des colonnes de la table "' . $this->table . '" indéfinies.');
			
			$this->updateReq['Begin'] = 'UPDATE ' . $this->table . ' SET ';
			$this->updateReq['End'] = ' WHERE ' . $this->primaryKey . ' IN(';
			$this->insertReq = 'INSERT INTO ' . $this->table . ' (' . implode(',', $this->keys) . ') VALUES ';
			
			$this->setUpdateRequest();
			$this->setInsertRequest();
		}
		catch(Exception $e) {
			throw $e;
		}
	}
	
	private function setUpdateAndInsertDatas(array $src) {
		foreach($src AS $datas) {
			if(in_array($datas[$this->primaryKey], $this->primaryKeyValues)) {
				array_push($this->updateDatas, $datas);
				$this->queryReady['Update'] = true;
			}
			else {
				array_push($this->insertDatas, $datas);
				$this->queryReady['Insert'] = true;
			}
		}
	}
	
	private function setUpdateRequest() {
		$firstIn = true;
		
		foreach($this->keys AS $key) {
			$this->updateReq['Begin'] .= $key . ' = CASE ' . $this->primaryKey;
			
			foreach($this->updateDatas AS $id=>$datas) {
				$this->updateReq['Begin'] .= ' WHEN :pk' . $id  . ' THEN :up' . $key . $id;
				if($firstIn) $this->updateReq['End'] .= ':pk' . $id . ', ';
			}
			$firstIn = false;
			
			$this->updateReq['Begin'] .= ' END, ';
		}
		
		$this->updateReq['Begin'] = rtrim($this->updateReq['Begin'], ', ');
		$this->updateReq['End'] =  rtrim($this->updateReq['End'], ', ') . ')';
	}
	
	private function setInsertRequest() {
		foreach($this->insertDatas AS $id=>$datas) {
			$this->insertReq .= '(';
			foreach($datas AS $field=>$val) $this->insertReq .= ':ins' . $field . $id . ', ';
			$this->insertReq = rtrim($this->insertReq, ', ') . '), ';
		}
		
		$this->insertReq = rtrim($this->insertReq, ', ');
	}
	
	public function getUpdateQuery() {
		if($this->queryReady['Update']) return $this->updateReq['Begin'] . $this->updateReq['End'];
		else return null;
	}
	
	public function getInsertQuery() {
		if($this->queryReady['Insert']) return $this->insertReq;
		else return null;
	}
}
?>