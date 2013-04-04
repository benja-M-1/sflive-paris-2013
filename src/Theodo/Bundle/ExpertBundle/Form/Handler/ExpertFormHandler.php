<?php

namespace Theodo\Bundle\ExpertBundle\Form\Handler;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\RouterInterface;

/**
 * ExpertFormHandler
 * 
 * @author Benjamin Grandfond <benjaming@theodo.fr>
 */
class ExpertFormHandler
{
    /**
     * @var \Symfony\Component\Routing\RouterInterface
     */
    protected $router;

    /**
     * @var \Doctrine\ORM\EntityManager
     */
    protected $manager;

    /**
     * @param RouterInterface $router
     * @param EntityManager   $manager
     */
    public function __construct(RouterInterface $router, EntityManager $manager)
    {
        $this->router = $router;
        $this->manager = $manager;
    }

    public function handle(FormInterface $form, Request $request)
    {
        $form->bind($request);

        if ($form->isValid()) {
            $this->manager->persist($form->getData());
            $this->manager->flush();

            return new RedirectResponse($this->router->generate('theodoexpertbundle_expert_list'));
        }

        return $form;
    }
}
