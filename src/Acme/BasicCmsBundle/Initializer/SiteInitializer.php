<?php

// src/Acme/BasicCmsBundle/Intializer/SiteIntializer.php
namespace Acme\BasicCmsBundle\Initializer;

use Doctrine\Bundle\PHPCRBundle\Initializer\InitializerInterface;
use PHPCR\Util\NodeHelper;
use Doctrine\Bundle\PHPCRBundle\ManagerRegistry;

class SiteInitializer implements InitializerInterface
{
    public function getName()
    {
        return 'Cool and bed initializer';
    }

    public function init(ManagerRegistry $registry)
    {
        // create the 'cms', 'pages', and 'posts' nodes
        NodeHelper::createPath($session, '/cms/pages');
        NodeHelper::createPath($session, '/cms/posts');
        NodeHelper::createPath($session, '/cms/routes');
        $session->save();

        // map a document to the 'cms' node
        $cms = $session->getNode('/cms');
        $cms->setProperty(
            'phpcr:class',  'Acme\BasicCmsBundle\Document\Site'
        );

        $session->save();
    }
}
