<?php
/**
 * Webiny Framework (http://www.webiny.com/framework)
 *
 * @copyright Copyright Webiny LTD
 */

namespace Webiny\Component\Annotations\Tests;

use Webiny\Component\Annotations\Annotations;

class AnnotationsTest extends \PHPUnit_Framework_TestCase
{

    public function setUp()
    {
        Annotations::setConfig(__DIR__ . '/ExampleConfig.yaml');
    }

    public function testGetClassAnnotations()
    {
        $annotations = Annotations::getClassAnnotations('\Webiny\Component\Annotations\Tests\TestClass');

        $this->assertSame('SomeProperty that has a string value.', $annotations->prop);
        $this->assertSame('AuthorName', $annotations->get('author.name'));
        $this->assertSame('http://www.webiny.com', $annotations->author->website->url);
        $this->assertSame('My website', $annotations->get('author.website.desc'));
    }

    public function testGetPropertyAnnotations()
    {
        $annotations = Annotations::getPropertyAnnotations('\Webiny\Component\Annotations\Tests\TestClass', 'someVar');

        $this->assertSame("SomeVarAnnotation", $annotations->var);
        $this->assertNotNull($annotations->public);
        $this->assertNull($annotations->private);

    }

    public function testGetPropertyAnnotations2()
    {
        $annotations = Annotations::getPropertyAnnotations('\Webiny\Component\Annotations\Tests\TestClass',
                                                           '$_anotherVar'
        );

        $this->assertSame("ADMIN", $annotations->access->role);
        $this->assertSame("3", $annotations->access->level);
        $this->assertSame("SomeName", $annotations->get("name"));
    }

    public function testGetMethodAnnotations()
    {
        $annotations = Annotations::getMethodAnnotations('\Webiny\Component\Annotations\Tests\TestClass', 'someMethod');

        $this->assertNotNull($annotations->post);
        $this->assertNotNull($annotations->get);
        $this->assertNull($annotations->delete);
        $this->assertSame("10", $annotations->cache->ttl);
        $this->assertSame("true", $annotations->cache->store);
        $this->assertSame("cacheKey", $annotations->cache->key);
        $this->assertContains("json", $annotations->accept);
        $this->assertNotContains("csv", $annotations->accept);
    }
}