<?php
require_once __DIR__ . '/../vendor/autoload.php';

use PHPUnit\Framework\TestCase;

echo getcwd();

final class TwigStaticTest extends TestCase {
	public function testCreateStaticFilterIsDefined() {
		$this->assertTrue(
			function_exists('create_static_filter')
		);
	}

    public function testCreateStaticFilterReturnsFunction() {
        $this->assertTrue(
            is_callable(create_static_filter('', ''))
        );
    }

    public function testCantFindAssetDir() {
        // If the $asset_dir doesn't exist the returned function
        // just returns the string passed to it
        $static_filter = create_static_filter('nope/doesnt/exist', '/');
        $expected = 'test';
        $actual = $static_filter('test');
        $this->assertEquals($expected, $actual);
    }

    public function testCantFindFile() {
        // If the file isn't found the url is returned as is
        $static_filter = create_static_filter('test/fixture/assets/', '/assets/');
        $expected = '/assets/test';
        $actual = $static_filter('test');
        $this->assertEquals($expected, $actual);
    }

    public function testHashFile() {
        $static_filter = create_static_filter('test/fixture/assets/', '/assets/');
        $expected = '/assets/testfile?v=3aa83314';
        $actual = $static_filter('testfile');
        $this->assertEquals($expected, $actual);
    }
}
