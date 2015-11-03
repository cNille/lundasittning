<?php
	// Arrayconverters to data objects with better structure.
	// ======================================================
class DataConverter{

	 function arrToRes($arr){
		return (object) [
			'name' => $arr[0],
			'email' => $arr[1],
			'telephone' => $arr[2],
			'homepage' => $arr[3],
			'openhours' => $arr[4],
			'address' => $arr[5],
			'deposit' => $arr[6],
			'price' => $arr[7],
			'size' => $arr[8],
			'summary' => $arr[9]
		];
	}

	 function arrToSitting($arr){
		$s = (object)[ // Init a sitting object.
			'id' => $arr[0],
			'date' => $arr[1],
			'appetiser' => $arr[2],
			'main' => $arr[3],
			'desert' => $arr[4],
			'prelDay' => $arr[5],
			'payDay' => $arr[6],
		];
		return $s;
	}

	 function arrToParty($arr){
		return (object) [ // Init a party object.
			'id' => $arr[0],
			'name' => $arr[1],
			'type' => $arr[2],
			'sittId' => $arr[3],
			'interest' => $arr[4],
			'message' => $arr[5],
			'key' => $arr[6],
			'interestOnly' => ($arr[5] == 0 && $arr[6] == 0)
		];
	}

	 function arrarrParty($arr){
		$parties = array();
		foreach ($arr as $key => $p) {
			$party = $this->arrToParty($p);
			$parties[] = $party;
		}
		return $parties;
	}

	function arrarrSitting($arr){
		$sittings = array();
		foreach ($arr as $key => $s) {
			$sitt = $this->arrToSitting($s);
			$sittings[] = $sitt;
		}
		return $sittings;
	}
	
	 function arrToUser($arr){
		$s = (object)[ // Init a sitting object.
			'id' => $arr[0],
			'fbid' => $arr[1],
			'name' => $arr[2],
			'email' => $arr[3],
			'telephone' => $arr[4],
			'other' => $arr[5],
			'active' => $arr[6]
		];
		return $s;
	}

	 function arrToGuest($arr){
		$g = (object)[
			'id' => $arr[0],
			'name' => $arr[1],
			'payed' => $arr[2]
		];
		return $g;
	}

	function arrarrGuest($arr){
		$guests = array();
		foreach ($arr as $key => $g) {
			$guest = $this->arrToGuest($g);
			$guests[] = $guest;
		}
		return $guests;
	}
}
?>
