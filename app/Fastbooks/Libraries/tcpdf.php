<?php namespace App\Fastbooks\Libraries;

/**
 * Class General
 * @package App\Fastbooks\Libraries
 */

class pdf {




    function test(){
		PDF::SetTitle('Hello World');

		PDF::AddPage();

		PDF::Write(0, 'Hello World');

		PDF::Output('hello_world.pdf');

	}

}