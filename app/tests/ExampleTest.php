<?php

class ExampleTest extends TestCase {

	/**
	 * A basic functional test example.
	 *
	 * @return void
	 */
	public function testGetBaseURL()
	{
		$crawler = $this->client->request('GET', '/');

		$this->assertTrue($this->client->getResponse()->isOk());
	}

	public function testGetISBN()
	{
		$crawler = $this->client->request('GET', '/book/isbn');

		$this->assertTrue($this->client->getResponse()->isOk());
	}



}
