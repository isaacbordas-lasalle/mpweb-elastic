<?php namespace App\Utils;


class Log
{
	public static function line($text)
	{
		echo LogAnsi::log($text, "green+bold");
	}

	public static function input($object, $title='Input')
	{
		$text = json_encode($object, JSON_PRETTY_PRINT);
		echo LogAnsi::log("$title:", "cyan+bold");
		echo LogAnsi::log($text, "cyan");
	}

	public static function output($object, $title='Output')
	{
		$text = json_encode($object, JSON_PRETTY_PRINT);
		echo LogAnsi::log("$title:", "yellow+bold");
		echo LogAnsi::log($text, "yellow");
	}

	public static function error($text)
	{
		echo LogAnsi::log("Error", "red+bold");
		echo LogAnsi::log($text, "red");
	}
}