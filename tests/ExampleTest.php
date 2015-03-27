<?php

use Laracasts\TestDummy\Factory;
class ExampleTest extends TestCase {

	/**
	 * A basic functional test example.
	 *
	 * @return void
	 */
	public function testBasicExample()
	{
		$thread = Factory::create('App\Thread');
        dd($thread->toArray());
	}

}
