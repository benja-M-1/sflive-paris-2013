<?php

namespace Theodo\Bundle\ExpertBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration as Extra;
use Theodo\Bundle\ExpertBundle\Entity\Expert;

/**
 * ExpertController
 * 
 * @author Benjamin Grandfond <benjaming@theodo.fr>
 */
class ExpertController extends Controller
{
    /**
     * @Extra\Route("/experts", name="theodoexpertbundle_expert_list")
     * @Extra\Template()
     */
    public function listAction()
    {
        $experts = $this->getDoctrine()
            ->getRepository('TheodoBundleExpertBundle:Expert')
            ->findAll()
        ;

        $expert  = new Expert();
        $builder = $this->createFormBuilder($expert);
        $form = $builder
            ->add('firstName')
            ->add('lastName')
            ->add('username')
            ->getForm();
        ;

        if ($this->getRequest()->isMethod('post')) {
            $form->bind($this->getRequest());

            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();

                $em->persist($form->getData());
                $em->flush();

                return $this->redirect($this->generateUrl('theodoexpertbundle_expert_list'));
            }
        }

        return array(
            'experts' => $experts,
            'form'    => $form->createView()
        );
    }
}