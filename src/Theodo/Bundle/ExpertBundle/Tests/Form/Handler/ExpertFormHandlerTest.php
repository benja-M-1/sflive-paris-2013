<?php

namespace Theodo\Bundle\ExpertBundle\Tests\Form\Handler;

use Theodo\Bundle\ExpertBundle\Form\Handler\ExpertFormHandler;

/**
 * ExpertFormHandlerTest
 * 
 * @author Benjamin Grandfond <benjaming@theodo.fr>
 */
class ExpertFormHandlerTest extends \PHPUnit_Framework_TestCase
{
    protected $handler;

    protected $router;

    protected $em;

    public function setUp()
    {
        $this->router  = $this->getMock('Symfony\Component\Routing\RouterInterface');
        $this->em      = $this->getMockBuilder('Doctrine\ORM\EntityManager')
            ->disableOriginalConstructor()
            ->getMock()
        ;
        $this->handler = new ExpertFormHandler($this->router, $this->em);
    }

    public function testShouldHandleAnUnsuccessfulFormSubmission()
    {
        $form    = $this->getFormMock();
        $request = new \Symfony\Component\HttpFoundation\Request();

        $this->assertEquals($form, $this->handler->handle($form, $request));
    }

    public function testShouldHandleASuccessfulFormSubmission()
    {
        $form = $this->getFormMock();
        $request = new \Symfony\Component\HttpFoundation\Request();

        $form->expects($this->once())
            ->method('isValid')
            ->will($this->returnValue(true))
        ;

        $form->expects($this->once())
            ->method('bind')
            ->with($this->identicalTo($request))
        ;

        $expert = new \Theodo\Bundle\ExpertBundle\Entity\Expert();
        $form->expects($this->once())
            ->method('getData')
            ->will($this->returnValue($expert))
        ;

        $this->router->expects($this->once())
            ->method('generate')
            ->with($this->equalTo('theodoexpertbundle_expert_list'))
            ->will($this->returnValue('/experts'))
        ;

        $this->em->expects($this->once())
            ->method('persist')
            ->with($this->isInstanceOf('Theodo\Bundle\ExpertBundle\Entity\Expert'))
        ;

        $this->em->expects($this->once())
            ->method('flush')
        ;

        $response = $this->handler->handle($form, $request);

        $this->assertInstanceOf('Symfony\Component\HttpFoundation\RedirectResponse', $response);
        $this->assertEquals('/experts', $response->getTargetUrl());
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    public function getFormMock()
    {
        $form = $this
            ->getMockBuilder('Symfony\Component\Form\Test\FormInterface')
            ->disableOriginalConstructor()
            ->getMock();

        return $form;
    }
}
