<?php
/**
 * @package     Mywalks.Site
 * @subpackage  com_mywalks
 *
 * @copyright   Copyright (C) 2005 - 2019 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * 
 * 
 * At this stage the com_mywalks component works. One menu item is needed to link to the list of walks. There is snag: in the list of walks the links to individual walks like like this:
 * /site-root/my-walks.html?view=mywalk&id=1
 * 
 * (where the site-root my or may not be a subfolder tree). Time for a custom SEF router? And take a break to read Supporting SEF URLs in your component . I have another Joomla package that uses SEF urls of the form [domain]/XXX/YY/page-title.html where XXX is an organisation branch code and YY is a language code. Some branches use multiple languages. Non-standard! Yes, but that is what the organisation asked for.
 * 
 * For the mywalks component I want to use individual walk urls like this:
 * 
 * /site-root/mywalks/walk-n/walk-title.html
 * Where n is the individual walk id and the walk-title is automatically generated from the actual title. Neither walk-title nor .html are actually needed. The former is for friendliness and the latter because I am old fashioned.
 * 
 * There are no menu items for individual walks. They are not wanted and there is no way to generate them. A custom router is required, consisting of two files: Router.php and MywalksNomenuRules.php.
 */

namespace LBC\Component\BaseComponent\Site\Service;

defined('_JEXEC') or die;

use Joomla\CMS\Application\SiteApplication;
use Joomla\CMS\Categories\CategoryFactoryInterface;
use Joomla\CMS\Component\ComponentHelper;
use Joomla\CMS\Component\Router\RouterView;
use Joomla\CMS\Component\Router\RouterViewConfiguration;
use Joomla\CMS\Component\Router\Rules\MenuRules;
//use Joomla\CMS\Component\Router\Rules\NomenuRules;
use LBC\Component\BaseComponent\Site\Service\BaseComponentNomenuRules as NomenuRules;
use Joomla\CMS\Component\Router\Rules\StandardRules;
use Joomla\CMS\Menu\AbstractMenu;
use Joomla\Database\DatabaseInterface;

/**
 * Routing class of com_mywalks
 *
 * @since  3.3
 */
class Router extends RouterView
{
    protected $noIDs = false;

    /**
     * The category factory
     *
     * @var CategoryFactoryInterface
     *
     * @since  4.0.0
     */
    private $categoryFactory;

    /**
     * The db
     *
     * @var DatabaseInterface
     *
     * @since  4.0.0
     */
    private $db;

    /**
     * Mywalks Component router constructor
     *
     * @param   SiteApplication           $app              The application object
     * @param   AbstractMenu              $menu             The menu object to work with
     * @param   CategoryFactoryInterface  $categoryFactory  The category object
     * @param   DatabaseInterface         $db               The database object
     */
    public function __construct(SiteApplication $app, AbstractMenu $menu,
            CategoryFactoryInterface $categoryFactory, DatabaseInterface $db)
    {
        $this->categoryFactory = $categoryFactory;
        $this->db              = $db;

        $params = ComponentHelper::getParams('com_basecomponent');
        $this->noIDs = (bool) $params->get('sef_ids');

        $mywalks = new RouterViewConfiguration('baseitemlist');
        $mywalks->setKey('id');
        $this->registerView($mywalks);

        $mywalk = new RouterViewConfiguration('baseitem');
        $mywalk->setKey('id');
        $this->registerView($mywalk);

        parent::__construct($app, $menu);

        $this->attachRule(new MenuRules($this));
        $this->attachRule(new StandardRules($this));
        $this->attachRule(new NomenuRules($this));
    }
}