<?php

namespace AntonioKadid\WAPPKitCore\Tests\Programmability;

use AntonioKadid\WAPPKitCore\Programmability\ComponentProcessor;
use PHPUnit\Framework\TestCase;

final class ComponentProcessorTest extends TestCase
{
    private $_processor;

    protected function setUp(): void
    {
        parent::setUp();

        $this->_processor = new ComponentProcessor(function($name) {
            switch($name)
            {
                case 'Powerful':
                    return <<<'EOT'
<?php
namespace RandomNamespace\RandomComponents;

use AntonioKadid\WAPPKitCore\Programmability\ExecutionContext;
use AntonioKadid\WAPPKitCore\Programmability\IComponentImplementation;

class RandomClassName implements IComponentImplementation
{
    public function setData(array $parameters = [], ExecutionContext $context = NULL):void
    {
    }
    
    public function generate(): string
    {
        return 'Hello';
    }
}
EOT;
                default:
                    return null;
            }
        });
    }

    public function testDescribe()
    {
        $result = ComponentProcessor::describe('Powerful');
        $this->assertEquals('#{{Powerful}}', $result);

        $result = ComponentProcessor::describe('Powerful', ['name' => 'The name', 'surname' => 'The surname']);
        $this->assertEquals('#{{Powerful name=The+name&surname=The+surname}}', $result);

        $result = ComponentProcessor::describe('Powerful', [], true);
        $this->assertEquals('<AsyncComponent name="Powerful"></AsyncComponent>', $result);

        $result = ComponentProcessor::describe('Powerful', ['name' => 'The name', 'surname' => 'The surname'], true);
        $this->assertEquals('<AsyncComponent name="Powerful" data-name="The+name" data-surname="The+surname"></AsyncComponent>', $result);
    }

    public function testProcessContent()
    {
        $result = $this->_processor->processContent('Testing: #{{Powerful}} world!');
        $this->assertEquals('Testing: Hello world!', $result);

        $result = $this->_processor->processContent('Testing: #{{Powerful122}} world!');
        $this->assertEquals('Testing: #{{Powerful122}} world!', $result);
    }
}
