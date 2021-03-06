<?php

namespace GroupBundle\Controller;

use GroupBundle\Entity\Group;
use GroupBundle\Entity\Topic;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * @author Wenming Tang <wenming@cshome.com>
 */
class GroupController extends Controller
{
    /**
     * @Route("/group/{slug}", defaults={"page": 1}, name="group_show")
     * @Route("/group/{slug}/p/{page}", requirements={"page": "[1-9]\d*"}, name="group_show_paginated")
     * @Method("GET")
     * @Cache(smaxage="5")
     */
    public function showAction(Group $group, $page)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $topics = $entityManager->getRepository(Topic::class)->findLatestByGroup($group, $page);

        return $this->render('GroupBundle:Group:show.html.twig', [
            'group'  => $group,
            'topics' => $topics
        ]);
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function recommendAction()
    {
        $entityManager = $this->getDoctrine()->getManager();
        $groups = $entityManager->getRepository(Group::class)->findAll();

        return $this->render('GroupBundle:Group:recommend.html.twig', [
            'groups' => $groups
        ]);
    }
}
