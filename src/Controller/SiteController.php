<?php
/**
 * User: boshurik
 * Date: 24.09.17
 * Time: 13:34
 */

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class SiteController extends Controller
{
    /**
     * @Route(path="/{_locale}", name="locale_index")
     * @Route(path="/", name="index")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        return $this->render('site/index.html.twig');
    }

    /**
     * @Route(path="/{_locale}/{page}", name="locale_page")
     * @Route(path="/{page}", name="page")
     *
     * @param string $page
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function pageAction($page)
    {
        return $this->render('site/page.html.twig', [
            'page' => $page,
        ]);
    }
}