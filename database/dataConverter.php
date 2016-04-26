<?php
	// Arrayconverters to data objects with better structure.
	// ======================================================
class DataConverter{

	 function createRestaurantObject($arr){
		return (object) [
			'name' => $arr[0],
			'nickname' => $arr[1],
			'email' => $arr[2],
			'telephone' => $arr[3],
			'homepage' => $arr[4],
			'openhours' => $arr[5],
			'address' => $arr[6],
			'deposit' => $arr[7],
			'price' => $arr[8],
			'size' => $arr[9],
			'summary' => $arr[10],
			'preldate' => $arr[14],
			'paydate' => $arr[15]
		];
	}

	 function createSittingObject($arr){
		$s = (object)[ // Init a sitting object.
			'id' => $arr[0],
			'date' => $arr[1],
			'appetiser' => $arr[2],
			'main' => $arr[3],
			'desert' => $arr[4],
			'prelDay' => $arr[5],
			'payDay' => $arr[6],
			'spotsTaken' => $arr[7],
			'open' => $arr[8]
		];
		return $s;
	}

	 function createPartyObject($arr){
		return (object) [ // Init a party object.
			'id' => $arr[0],
			'name' => $arr[1],
			'type' => $arr[2],
			'sittId' => $arr[3],
			'interest' => $arr[4],
			'message' => $arr[5],
			'key' => $arr[6],
			'interestOnly' => ($arr[5] == 0 && $arr[6] == 0),
			'partyPayed' => $arr[8]
		];
	}

	 function createPartyList($arr){
		$parties = array();
		foreach ($arr as $key => $p) {
			$party = $this->createPartyObject($p);
			$parties[] = $party;
		}
		return $parties;
	}

	function createSittingList($arr){
		$sittings = array();
		foreach ($arr as $key => $s) {
			$sitt = $this->createSittingObject($s);
			$sittings[] = $sitt;
		}
		return $sittings;
	}
	
	 function createUserObject($arr){
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

	 function createGuestObject($arr){
		$g = (object)[
			'id' => $arr[0],
			'name' => $arr[1],
			'payed' => $arr[2]
		];
		return $g;
	}

	function createGuestList($arr){
		$guests = array();
		foreach ($arr as $key => $g) {
			$guest = $this->createGuestObject($g);
			$guests[] = $guest;
		}
		return $guests;
	}
}
?>
