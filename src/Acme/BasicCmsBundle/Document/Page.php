<?php
// src/Acme/BasicCmsBundle/Document/Page.php
namespace Acme\BasicCmsBundle\Document;

use Doctrine\ODM\PHPCR\Mapping\Annotations as PHPCR;
use Symfony\Cmf\Component\Routing\RouteReferrersReadInterface;
use Knp\Menu\NodeInterface;

/**
 * @PHPCR\Document(referenceable=true)
 */
class Page implements RouteReferrersReadInterface, NodeInterface
{
    use ContentTrait;

    /**
     * @PHPCR\Children()
     */
    protected $children;

    /**
     * @PHPCR\String()
     */
    protected $menuClass = '';

    public function getName()
    {
        return $this->title;
    }

    public function getRouteTitle()
    {
        return sprintf('%s.html', $this->getTitle());
    }

    public function getChildren()
    {
        return $this->children;
    }

    public function getOptions()
    {
        return array(
            'label' => $this->title,
            'content' => $this,

            'attributes'         => array(
                'class' => 'image-rollover menu-item',
            ),
            'childrenAttributes' => array(),
            'displayChildren'    => true,
            'linkAttributes'     => array(
                'class' => $this->menuClass,
            ),
            'labelAttributes'    => array(),
        );
    }

    public function getMenuClass() 
    {
        return $this->menuClass;
    }
    
    public function setMenuClass($menuClass)
    {
        $this->menuClass = $menuClass;
    }
    
}
