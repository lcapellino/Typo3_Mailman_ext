<?php
namespace Htwg\MailmanExt;

class GiExtUtil{
	const PYTHON_SCRIPTS_DIR = __DIR__. '/python_scripts/';
	
	static function exec($python_script){
		$output = shell_exec(self::PYTHON_SCRIPTS_DIR .$python_script . " 2>&1");
		return $output;
	}

}
