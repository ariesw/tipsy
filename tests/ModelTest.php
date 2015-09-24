<?php


class TestModelBase extends Tipsy\Model {
	public function test() {
		return 'ONE';
	}
}

class TestModelBaseProtected extends Tipsy\Model {
	protected function test() {
		return 'ONE';
	}
}


class ModelTest extends Tipsy_Test {
	
	public function setUp() {
		$this->tip = new Tipsy\Tipsy;
		$this->useOb = true; // for debug use
		
		$this->tip->config('tests/config.ini');
	}
	
	public function testModelBasic() {

		$this->tip->service('TestModel', [
			'test' => function() {
				return 'YES';
			}
		]);

		$model = $this->tip->service('TestModel');
		$this->assertEquals('YES', $model->test());
	}

	public function testModelBasicFunc() {

		$this->tip->service('TestModel', function() {
			$model = [
				'test' => function() {
					return 'YES';
				}
			];
			return $model;
		});

		$model = $this->tip->service('TestModel');
		$this->assertEquals('YES', $model->test());
	}

	public function testModelCustomExtend() {
		$this->tip->service('TestModelBaseProtected/TestModel', function() {
			$model = [
				'test' => function() {
					return 'TWO';
				}
			];
			return $model;
		});
		
		$model = $this->tip->service('TestModel');
		$this->assertEquals('TWO', $model->test());
	}

	public function testModelCustomExtendCall() {
		$this->tip->service('TestModelBase/TestModel', function() {
			$model = [

			];
			return $model;
		});

		$model = $this->tip->service('TestModel');
		$this->assertEquals('ONE', $model->test());
	}
	
	public function testModelController() {
		$this->tip->service('TestModel', function() {
			$model = [
				'test' => function() {
					return 'YESM';
				}
			];
			return $model;
		});
		
		$this->ob();
		
		$this->tip->router()
			->otherwise(function($TestModel) {
				echo $TestModel->test();
			});
		$this->tip->start();
			
		$res = $this->ob(false);

		$this->assertEquals('YESM', $res);
	}
}