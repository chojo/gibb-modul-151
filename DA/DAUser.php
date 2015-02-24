<?php

namespace DA;

class DAUser extends DA_Base {
	
	function find($id) {
		$sql = 'SELECT * FROM User WHERE Id = :Id';
		$stmt = self::getConnection ()->prepare ( $sql );
		$stmt->bindValue ( ":Id", $id );
		$stmt->execute ();
		
		$people = array ();
		$result = $stmt->fetch ( \PDO::FETCH_ASSOC );
		
		$user = self::assignValues ( new \BE\BEUser (), $result );
		
		return $user;
	}
	
	function findAll() {
		$sql = 'SELECT * FROM User';
		$stmt = self::getConnection ()->prepare ( $sql );
		$stmt->execute ();
		
		$people = array ();
		while ( $result = $stmt->fetch ( \PDO::FETCH_ASSOC ) ) {
			
			$user = self::assignValues ( new \BE\BEUser (), $result );
			$people [] = $user;
		}
		return $people;
	}
	
	function save(\BE\BEUser $user) {
		
	}
	
	
	
}

