<?php
	// Arrayconverters to data objects with better structure.
	// ======================================================
class DataConverter{

	 function arrToRes($arr){
		return (object) [
			'name' => $arr[0],
			'email' => $arr[1],
			'openhours' => $arr[2],
			'deposit' => $arr[3],
			'price' => $arr[4],
			'size' => $arr[5],
			'summary' => $arr[6]
		];
	}

	 function arrToSitting($arr){
		$s = (object)[ // Init a sitting object.
			'date' => $arr[0],
			'appetiser' => $arr[1],
			'main' => $arr[2],
			'desert' => $arr[3],
			'prelDay' => $arr[4],
			'payDay' => $arr[5]
		];
		return $s;
	}

	 function arrToParty($arr){
		return (object) [ // Init a party object.
			'id' => $arr[0],
			'name' => $arr[1],
			'type' => $arr[2],
			'date' => $arr[3],
			'interest' => $arr[4],
			'prel' => $arr[5],
			'payed' => $arr[6],
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
}
?>