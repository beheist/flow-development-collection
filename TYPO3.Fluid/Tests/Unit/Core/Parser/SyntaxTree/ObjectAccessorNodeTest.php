<?php
namespace TYPO3\Fluid\Tests\Unit\Core\Parser\SyntaxTree;

/*                                                                        *
 * This script belongs to the Flow framework.                             *
 *                                                                        *
 * It is free software; you can redistribute it and/or modify it under    *
 * the terms of the MIT license.                                          *
 *                                                                        */

/**
 * Testcase for ObjectAccessorNode
 */
class ObjectAccessorNodeTest extends \TYPO3\Flow\Tests\UnitTestCase
{
    /**
     * @test
     */
    public function evaluateGetsPropertyPathFromVariableContainer()
    {
        $node = new \TYPO3\Fluid\Core\Parser\SyntaxTree\ObjectAccessorNode('foo.bar');
        $renderingContext = $this->getMock(\TYPO3\Fluid\Core\Rendering\RenderingContextInterface::class);
        $variableContainer = new \TYPO3\Fluid\Core\ViewHelper\TemplateVariableContainer(array(
            'foo' => array(
                'bar' => 'some value'
            )
        ));
        $renderingContext->expects($this->any())->method('getTemplateVariableContainer')->will($this->returnValue($variableContainer));

        $value = $node->evaluate($renderingContext);

        $this->assertEquals('some value', $value);
    }

    /**
     * @test
     */
    public function evaluateCallsObjectAccessOnSubjectWithTemplateObjectAccessInterface()
    {
        $node = new \TYPO3\Fluid\Core\Parser\SyntaxTree\ObjectAccessorNode('foo.bar');
        $renderingContext = $this->getMock(\TYPO3\Fluid\Core\Rendering\RenderingContextInterface::class);
        $templateObjectAcessValue = $this->getMock(\TYPO3\Fluid\Core\Parser\SyntaxTree\TemplateObjectAccessInterface::class);
        $variableContainer = new \TYPO3\Fluid\Core\ViewHelper\TemplateVariableContainer(array(
            'foo' => array(
                'bar' => $templateObjectAcessValue
            )
        ));
        $renderingContext->expects($this->any())->method('getTemplateVariableContainer')->will($this->returnValue($variableContainer));

        $templateObjectAcessValue->expects($this->once())->method('objectAccess')->will($this->returnValue('special value'));

        $value = $node->evaluate($renderingContext);

        $this->assertEquals('special value', $value);
    }
}
