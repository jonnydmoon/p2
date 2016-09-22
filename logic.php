<?
/*
	Page: logic.php
	Handles the logic for the password generator. 
*/
 
$output = handleRequest(); // All variables accessible to the html will be contained within $output.


/*
	Function: handleRequest()
	Description: 
	Main controller function. Validates input, and returns a new password.
*/
function handleRequest(){
	$output = validateInput($_REQUEST); // Validate and set defaults for all input.

	$words = getWords($output['numberOfWords']);

	$words = transformTextCasing($words, $output['textTransform']);

	$password = handleDelimiter($words, $output['delimiter']);
	
	if($output['includeNumber'] === 'on'){
		$password = handleIncludeNumber($password);
	}
	
	if($output['includeSymbol'] === 'on'){
		$password = handleIncludeSymbol($password);
	}

	$output['password'] = $password;

	return $output;
}

/*
	Function: validateInput(associativeArray)
	Description: 
	Takes an associative array and validates input. Unexpected values are ignored.
	If an input value is not valid, an error is added to the errors field.
	No matter what, by the end of the function, output will contain valid fields.
*/
function validateInput($input){
	// Set valid values for inputs.
	$numberOfWords = 3;
	$includeNumber = null; 
	$includeSymbol = null;
	$delimiter = 'hyphen';
	$textTransform = 'lower';
	extract($input, EXTR_IF_EXISTS); // Allow for a POST or a GET. Only extract the variables above.

	$output = []; // Output are variables that will be available to the html page.
	$output['errors'] = [];

	if(!is_numeric($numberOfWords) || $numberOfWords < 1 || $numberOfWords > 9){
		$output['errors'][] = "Invalid number of words. Defaulting to 3 words.";
		$numberOfWords = 3;
	}

	if($includeNumber && $includeNumber !== 'on' && $includeNumber !== 'off'){
		$output['errors'][] = "Invalid value for includeNumber. Defaulting to 'off'.";
		$includeNumber = null;
	}

	if($includeSymbol !== null && $includeSymbol !== 'on' && $includeSymbol !== 'off'){
		$output['errors'][] = "Invalid value for includeSymbol. Defaulting to 'off'.";
		$includeSymbol = null;
	}

	if($delimiter !== 'hyphen' && $delimiter !== 'nospace' && $delimiter !== 'space'){
		$output['errors'][] = "Invalid value for delimiter. Defaulting to 'hyphen'.";
		$delimiter = 'hyphen';
	}

	if(!in_array($textTransform, ['camel', 'lower', 'upper', 'title', 'sentence'])){
		$output['errors'][] = "Invalid value for textTransform. Defaulting to 'lower'.";
		$textTransform = 'lower';
	}

	// By this point, all these variables are now valid.
	$output['numberOfWords'] = +$numberOfWords;
	$output['includeNumber'] = $includeNumber;
	$output['includeSymbol'] = $includeSymbol;
	$output['delimiter'] = $delimiter;
	$output['textTransform'] = $textTransform;
	return $output;
}


// Returns a random number of words as an array.
function getWords($numberOfWords){
	$words = file('words.csv', FILE_IGNORE_NEW_LINES);
	shuffle($words);
	return array_slice($words, 0, $numberOfWords);
}


// Returns an array of words that has been transformed according to the transform type.
function transformTextCasing($words, $type){
	switch($type){
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
	return $words;
}


// Returns a password string from an array of words joined together by a delimiter.
function handleDelimiter($words, $type){
	switch($type){
		case 'hyphen':
			$password = implode('-', $words);
			break;
		case 'space':
			$password = implode(' ', $words);
			break;
		case 'nospace':
			$password = implode('', $words);
			break;
	}
	return $password;
}


// Adds a number to the end of a string.
function handleIncludeNumber($password){
	$numbers = [0,1,2,3,4,5,6,7,8,9];
	shuffle($numbers);
	$password .= $numbers[0];
	return $password;
}


// Adds a symbol to the end of a string.
function handleIncludeSymbol($password){
	$symbols = ['!','@','#','$','%','&','*','?','+'];
	shuffle($symbols);
	$password .= $symbols[0];
	return $password;
}