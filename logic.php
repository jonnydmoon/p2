<?
$output = handleRequest();

function handleRequest(){
	$output = validateInput($_REQUEST);

	$words = ['and', 'that', 'horse', 'pick', 'chapped', 'tongue', 'red', 'orange', 'yes', 'man', 'babe'];

	shuffle($words);

	$words = array_slice($words, 0, $output['numberOfWords']);

	
	switch($output['textTransform']){
		case 'camel':
			$words = array_map(function($word){ return ucfirst($word); }, $words);
			$words[0] = lcfirst($words[0]);
			break;
		case 'upper':
			$words = array_map(function($word){ return strtoupper($word); }, $words);
			break;
		case 'lower':
			$words = array_map(function($word){ return strtolower($word); }, $words);
			break;
		case 'title':
			$words = array_map(function($word){ return ucfirst($word); }, $words);
			break;
		case 'sentence':
			$words[0] = ucfirst($words[0]);
			break;
	}


	switch($output['delimiter']){
		case 'hyphen':
			$output['password'] = implode('-', $words);
			break;
		case 'space':
			$output['password'] = implode(' ', $words);
			break;
		case 'nospace':
			$output['password'] = implode('', $words);
			break;
	}




	$numbers = [0,1,2,3,4,5,6,7,8,9];
	$symbols = ['!','@','#','$','%','&','*','?','+'];

	if($output['includeNumber'] === 'on'){
		shuffle($numbers);
		$output['password'] .= $numbers[0];
	}

	if($output['includeSymbol'] === 'on'){
		shuffle($symbols);
		$output['password'] .= $symbols[0];
	}

	return $output;
}

function validateInput($input){
	$numberOfWords = 3;
	$includeNumber = null; 
	$includeSymbol = null;
	$delimiter = 'hyphen';
	$textTransform = 'lower';
	extract($input, EXTR_IF_EXISTS); // Allow for a POST or a GET. Only extract the variables above.

	$output = [];
	$output['errorMessage'] = [];

	if(!is_numeric($numberOfWords) || $numberOfWords < 1 || $numberOfWords > 9){
		$output['errorMessage'][] = "Invalid number of words. Defaulting to 3 words";
		$numberOfWords = 3;
	}

	if($includeNumber && $includeNumber !== 'on' && $includeNumber !== 'off'){
		$output['errorMessage'][] = "Invalid value for includeNumber. Defaulting to 'off'.";
		$includeNumber = null;
	}

	if($includeSymbol !== null && $includeSymbol !== 'on' && $includeSymbol !== 'off'){
		$output['errorMessage'][] = "Invalid value for includeSymbol. Defaulting to 'off'.";
		$includeSymbol = null;
	}

	if($delimiter !== 'hyphen' && $delimiter !== 'nospace' && $delimiter !== 'space'){
		$output['errorMessage'][] = "Invalid value for delimiter. Defaulting to 'hyphen'.";
		$delimiter = 'hyphen';
	}

	if(!in_array($textTransform, ['camel', 'lower', 'upper', 'title', 'sentence'])){
		$output['errorMessage'][] = "Invalid value for textTransform. Defaulting to 'lower'.";
		$textTransform = 'lower';
	}

	$output['numberOfWords'] = +$numberOfWords;
	$output['includeNumber'] = $includeNumber;
	$output['includeSymbol'] = $includeSymbol;
	$output['delimiter'] = $delimiter;
	$output['textTransform'] = $textTransform;

	return $output;
}