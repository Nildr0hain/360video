<?php

	// config
	define('NUM_BLOGPOSTS', 10);
	define('NUM_COMMENTS', 17);
	define('NUM_AUTHORS', 3);

	// require autoloader
	require_once 'vendor/autoload.php';

	// create new faker instance
	$faker = Faker\Factory::create();

	// generate fake comments
	$comments = [];
	$numcomments = array_fill(1, NUM_BLOGPOSTS, 0);
	for ($i = 1; $i <= NUM_COMMENTS; $i++) {
		$randomBlogpost = $faker->randomNumber(1, NUM_BLOGPOSTS);
		$comments[$i] = [
			'blogpost_id' => $randomBlogpost,
			'content' => '<p>' . implode('</p><p>', $faker->paragraphs($faker->randomNumber(3,6))) . '</p>',
			'date' => $faker->dateTimeThisMonth()->format('Y-m-d H:i:s'),
			'author' => $faker->name,
			'email' => $faker->email
		];
		$numcomments[$randomBlogpost]++;
	}

	// generate fake blogposts
	$blogposts = [];
	for ($i = 1; $i <= NUM_BLOGPOSTS; $i++) {
		$blogposts[$i] = [
			'title' => $faker->sentence($faker->randomNumber(4, 10)),
			'content' => '<p>' . implode('</p><p>', $faker->paragraphs($faker->randomNumber(3,6))) . '</p>',
			'date' => $faker->dateTimeThisMonth()->format('Y-m-d H:i:s'),
			'author_id' => $faker->randomNumber(1, NUM_AUTHORS),
			'numcomments' => $numcomments[$i]
		];
	}

	// authors (fixed)
	$authors = unserialize('a:3:{i:1;a:6:{s:9:"firstname";s:6:"Bramus";s:8:"lastname";s:9:"Van Damme";s:5:"email";s:25:"bramus.vandamme@kahosl.be";s:7:"website";s:19:"http://www.bram.us/";s:8:"location";s:14:"Vinkt, Belgium";s:8:"password";s:34:"$1$ikr/pd3F$ioj.iteh09cuxcj/6LClx/";}i:2;a:6:{s:9:"firstname";s:4:"Davy";s:8:"lastname";s:8:"De Winne";s:5:"email";s:22:"davy.dewinne@kahosl.be";s:7:"website";s:26:"http://www.davydewinne.be/";s:8:"location";s:21:"Schellebelle, Belgium";s:8:"password";s:34:"$1$Tmppgmf6$treNaN/WSBGJ3OuzrLOd.0";}i:3;a:6:{s:9:"firstname";s:5:"Kevin";s:8:"lastname";s:9:"Picalausa";s:5:"email";s:25:"kevin.picalausa@kahosl.be";s:7:"website";N;s:8:"location";s:13:"Gent, Belgium";s:8:"password";s:34:"$1$6s4sG.Ol$XNxeu/0kVxhkHQvNBHLpP0";}}');


	// export
	echo '<?php ' . PHP_EOL . PHP_EOL;

	echo '$blogposts = ';
	var_export($blogposts);
	echo ';' . PHP_EOL . PHP_EOL . PHP_EOL;

	echo '$comments = ';
	var_export($comments);
	echo ';' . PHP_EOL . PHP_EOL . PHP_EOL;

	echo '$authors = ';
	var_export($authors);
	echo ';' . PHP_EOL . PHP_EOL . PHP_EOL;