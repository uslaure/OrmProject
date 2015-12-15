<?php

class Log{
		public function Error(){
			$file = fopen('log/error.log', 'a');
			$date = date('F j, Y, g:i a');
			fwrite($file, $string);
			fclose($file);
		}

		public function Access(){
			$file = fopen('log/access.log', 'a');
			$date = date('F j, Y, g:i a');
			fwrite($file, $date);
			fclose($file);
		}
}