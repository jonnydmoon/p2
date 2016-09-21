<?php  
	require('logic.php');
	extract($output); // Turn everything in output into a local variable.
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Password Generator</title>
	
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700%7COswald%7CCutive+Mono" rel="stylesheet">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
	<link rel="stylesheet" href="stylesheet.css" type="text/css">
	<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-T8Gy5hrqNKT+hzMclPo118YTQO6cYprQmhrYwIiQ/3axmI1hQomh7Ud2hPOy8SP1" crossorigin="anonymous">
	<link rel="icon" href="favicon.ico" />
</head>

<body>
	<div class="container-fluid header">
		<div class="container">
			<header class="row">
				<div class="col-sm-12">
					<div class="logo">
						<div class="logo-title">XKCD PASSWORD GENERATOR</div>
						<div class="logo-subTitle">INSPIRED BY THE XKCD WEBCOMIC</div>
					</div>
				</div>

			</header>
		</div>
	</div>
	<div class="container-fluid">
		<main class="container main-content">
			<div class="row main-row">
				<div class="col-sm-12">
					
					<? if($errors && $errors.length): ?>
						<div class="alert alert-danger" role="alert"> <strong>Error</strong> <?= implode('<br /><strong>Error</strong> ', $errors) ?></div>
					<? endif ?>

					<div class='password-holder'>
						<h1 class="password"><?= $password ?></h1>
					</div>
					
					<form method="GET" action="?">
						<div class="form-group">
							<select name="numberOfWords" class="form-control">
								<option value="1" <?= $numberOfWords === 1 ? 'selected' : '' ?>>1 word</option>
								<option value="2" <?= $numberOfWords === 2 ? 'selected' : '' ?>>2 words</option>
								<option value="3" <?= $numberOfWords === 3 ? 'selected' : '' ?>>3 words</option>
								<option value="4" <?= $numberOfWords === 4 ? 'selected' : '' ?>>4 words</option>
								<option value="5" <?= $numberOfWords === 5 ? 'selected' : '' ?>>5 words</option>
								<option value="6" <?= $numberOfWords === 6 ? 'selected' : '' ?>>6 words</option>
								<option value="7" <?= $numberOfWords === 7 ? 'selected' : '' ?>>7 words</option>
								<option value="8" <?= $numberOfWords === 8 ? 'selected' : '' ?>>8 words</option>
								<option value="9" <?= $numberOfWords === 9 ? 'selected' : '' ?>>9 words</option>
							</select>

							<select name="delimiter" class="form-control">
								<option value="hyphen" <?= $delimiter === 'hyphen' ? 'selected' : '' ?>>hyphenate-words</option>
								<option value="nospace" <?= $delimiter === 'nospace' ? 'selected' : '' ?>>nospaces</option>
								<option value="space" <?= $delimiter === 'space' ? 'selected' : '' ?>>space words</option>
							</select>

							<select name="textTransform" class="form-control">
								<option value="camel" <?= $textTransform === 'camel' ? 'selected' : '' ?>>camelCase</option>
								<option value="upper" <?= $textTransform === 'upper' ? 'selected' : '' ?>>UPPERCASE</option>
								<option value="lower" <?= $textTransform === 'lower' ? 'selected' : '' ?>>lowercase</option>
								<option value="title" <?= $textTransform === 'title' ? 'selected' : '' ?>>Title Case</option>
								<option value="sentence" <?= $textTransform === 'sentence' ? 'selected' : '' ?>>Sentence Case</option>
							</select>
						</div>
						<div class="checkbox">
							<label>
							  <input name="includeNumber" type="checkbox" <?= $includeNumber === 'on' ? 'checked' : '' ?>> Add a number
							</label>
						</div>
						<div class="checkbox">
							<label>
							  <input name="includeSymbol" type="checkbox" <?= $includeSymbol === 'on' ? 'checked' : '' ?>> Add a symbol
							</label>
						</div>

						<button type="submit" class="btn btn-success">Generate New Password</button>
					</form>
				</div>


				<div class="row">
					<div class="col-sm-8 col-sm-offset-2 comic-column">
						<a href="http://xkcd.com/936/" target="xkcd">
							<img src="images/password_strength.png" alt="A webcomic describing how to make a strong password." class="img-responsive u-marginTop comic" />
							xkcd webcomic: password strength
						</a>
					</div>
				</div>
			</div>

			<footer>
				<div class='copyright'>
					&copy; <script>document.write(new Date().getFullYear())</script> Jonny Moon. 
				</div>
			</footer>
		</main>
	</div>
</body>
</html>