<?php

namespace Acme\BasicCmsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DefaultController extends Controller
{
    /**
     * @Template()
     */
    public function pageAction($contentDocument)
    {
        return array(
            'page'  => $contentDocument,
        );
    }

    public function makeHomepageAction($id)
    {
        $dm = $this->get('doctrine_phpcr')->getManager();

        $site = $dm->find(null, '/cms');
        if (!$site) {
            throw $this->createNotFoundException('Could not find /cms document!');
        }

        $page = $dm->find(null, $id);

        $site->setHomepage($page);
        $dm->persist($page);
        $dm->flush();

        return $this->redirect($this->generateUrl('admin_acme_basiccms_page_edit', array(
            'id' => $page->getId()
        )));
    }

    /**
     * @Route("/")
     */
    public function indexAction()
    {
        $dm = $this->get('doctrine_phpcr')->getManager();
        $site = $dm->find('Acme\BasicCmsBundle\Document\Site', '/cms');
        $homepage = $site->getHomepage();

        if (!$homepage) {
            throw $this->createNotFoundException('No homepage configured');
        }

        return $this->forward('AcmeBasicCmsBundle:Default:page', array(
            'contentDocument' => $homepage
        ));
    }
}
