<?php

namespace Fogs\TaggingBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/tags")
 */
class DefaultController extends Controller
{
	
	/**
	 * Search for tags
	 *
	 * @Route("/{query}", name="tags_search", defaults={"query" = ""})
	 * @Method("GET")
	 */
	
    public function searchAction($query)
    {
    	$tags = $this->get('fpn_tag.tag_manager')->findTags($query);
    	$tags = array_map(function ($value) {
    		return $value['name'];
    	}, $tags);
    	return new JsonResponse($tags);
    }
    
}
