<?php

class HttpTest extends Tipsy_Test {
	public function setUp() {
		$this->tip = new Tipsy\Tipsy;
	}

	public function testFormGetJson() {
		$http = (new Tipsy\Http())->get('http://localhost:8000/item/1/json', [key => 'value'], [type => 'form'])->complete(function($data) use (&$res) {
			$res = $data;
		});
		$this->assertEquals($res, (object)[id => 1, key => 'value', method => 'get']);
	}

	public function testFormPostJson() {
		$http = (new Tipsy\Http())->post('http://localhost:8000/item/1/json', [key => 'value'])->complete(function($data) use (&$res) {
			$res = $data;
		});
		$this->assertEquals($res, (object)[id => 1, key => 'value', method => 'post']);
	}

	public function testFormGetPlain() {
		$http = (new Tipsy\Http())->get('http://localhost:8000/item/1/plain', [key => 'value'])->complete(function($data) use (&$res) {
			$res = $data;
		});
		$this->assertEquals($res, '1.value.get');
	}

	public function testFormPostPlain() {
		$http = (new Tipsy\Http())->post('http://localhost:8000/item/1/plain', [key => 'value'], [type => 'form'])->complete(function($data) use (&$res) {
			$res = $data;
		});
		$this->assertEquals($res, '1.value.post');
	}

	public function testJsonGetJson() {
		$http = (new Tipsy\Http())->get('http://localhost:8000/item/1/json', [key => 'value'], [type => 'json'])->complete(function($data) use (&$res) {
			$res = $data;
		});
		$this->assertEquals($res, (object)[id => 1, key => 'value', method => 'get']);
	}


	public function testJsonPostJson() {
		$http = (new Tipsy\Http())->post('http://localhost:8000/item/1/json', [key => 'value'], [type => 'json'])->complete(function($data) use (&$res) {
			$res = $data;
		});
		$this->assertEquals($res, (object)[id => 1, key => 'value', method => 'post']);
	}


	public function testJsonGetPlain() {
		$http = (new Tipsy\Http())->get('http://localhost:8000/item/1/plain', [key => 'value'], [type => 'json'])->complete(function($data) use (&$res) {
			$res = $data;
		});
		$this->assertEquals($res, '1.value.get');
	}

	public function testJsonPostPlain() {
		$http = (new Tipsy\Http())->post('http://localhost:8000/item/1/plain', [key => 'value'], [type => 'json'])->complete(function($data) use (&$res) {
			var_dump($data);
			$res = $data;
		});
		$this->assertEquals($res, '1.value.post');
	}


	public function testError() {
		$http = (new Tipsy\Http())->post('http://localhost:8000/404')
			->complete(function($data) use (&$res) {
				$res['complete'] = true;
			})
			->success(function($data) use (&$res) {
				$res['success'] = true;
			})
			->error(function($data) use (&$res) {
				$res['error'] = true;
			});

		$this->assertTrue($res['complete']);
		$this->assertNull($res['success']);
		$this->assertTrue($res['error']);
	}

	public function testSuccess() {
		$http = (new Tipsy\Http())->post('http://localhost:8000/item/1/plain')
			->complete(function($data) use (&$res) {
				$res['complete'] = true;
			})
			->success(function($data) use (&$res) {
				$res['success'] = true;
			})
			->error(function($data) use (&$res) {
				$res['error'] = true;
			});

		$this->assertTrue($res['complete']);
		$this->assertTrue($res['success']);
		$this->assertNull($res['error']);
	}

	public function testKwargsCopy() {
		$http = (new Tipsy\Http())->post('http://localhost:8000/item/1/json', [key => 'value'])
		->complete(function($data) use (&$res) {
			$res = $data;
		});

		$this->assertEquals($res,  (object)[id => 1, key => 'value', method => 'post']);
	}

	public function testKwargs() {
		$http = (new Tipsy\Http())->request([
			url => 'http://localhost:8000/item/1/json',
			method => 'post',
			data => [key => 'value']
		])
		->complete(function($data) use (&$res) {
			$res = $data;
		});

		$this->assertEquals($res, (object)[id => 1, key => 'value', method => 'post']);
	}

	public function testKwargsMethod() {
		$http = (new Tipsy\Http())->get([
			url => 'http://localhost:8000/item/1/json',
			data => [key => 'value']
		])
		->complete(function($data) use (&$res) {
			$res = $data;
		});

		$this->assertEquals($res,  (object)[id => 1, key => 'value', method => 'get']);
	}
}
