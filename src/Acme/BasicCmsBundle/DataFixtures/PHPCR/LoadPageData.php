<?php

// src/Acme/BasicCmsBundle/DataFixtures/PHPCR/LoadPageData.php
namespace Acme\BasicCmsBundle\DataFixtures\PHPCR;

use Acme\BasicCmsBundle\Document\Page;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use PHPCR\Util\NodeHelper;

class LoadPageData implements FixtureInterface
{
    public function load(ObjectManager $dm)
    {
        $parent = $dm->find(null, '/cms/pages');

        $rootPage = new Page();
        $rootPage->setTitle('main');
        $rootPage->setParent($parent);
        $dm->persist($rootPage);

        foreach (array(
            'Dormir', 'Reserver', 'Venir', 'Bouger', 'Visiter', 'Galerie'
        ) as $title) {
            $page = new Page();
            $page->setTitle($title);
            $page->setParent($rootPage);
            $page->setContent(<<<HERE
Welcome to the homepage of this really basic CMS.
HERE
        );
            $page->setMenuClass('menu-' . strtolower($title));
            $dm->persist($page);
        }

        $dm->flush();
    }
}
