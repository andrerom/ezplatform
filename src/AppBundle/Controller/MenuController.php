<?php
/**
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
namespace AppBundle\Controller;

use eZ\Publish\API\Repository\LocationService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Templating\EngineInterface;
use eZ\Publish\API\Repository\SearchService;
use AppBundle\QueryType\ChildrenQueryType;

class MenuController
{
    /** @var \Symfony\Bundle\TwigBundle\TwigEngine */
    protected $templating;

    /** @var \eZ\Publish\API\Repository\SearchService */
    protected $searchService;

    /** @var \eZ\Publish\API\Repository\LocationService */
    protected $locationService;

    /** @var \AppBundle\QueryType\ChildrenQueryType */
    protected $menuQueryType;

    /** @var int */
    protected $topMenuParentLocationId;

    /** @var array */
    protected $topMenuContentTypeIdentifier;

    public function __construct(
        EngineInterface $templating,
        SearchService $searchService,
        LocationService $locationService,
        ChildrenQueryType $menuQueryType,
        int $topMenuParentLocationId,
        $topMenuContentTypeIdentifier
    ) {
        $this->templating = $templating;
        $this->searchService = $searchService;
        $this->locationService = $locationService;
        $this->menuQueryType = $menuQueryType;
        $this->topMenuParentLocationId = $topMenuParentLocationId;
        $this->topMenuContentTypeIdentifier = $topMenuContentTypeIdentifier;
    }

    public function getChildNodesAction(string $template, string $pathString = null) : Response
    {
        $query = $this->menuQueryType->getQuery([
            'parent_location' => $this->locationService->loadLocation($this->topMenuParentLocationId),
            'included_content_type_identifier' => $this->topMenuContentTypeIdentifier,
        ]);

        $locationSearchResults = $this->searchService->findLocations($query);

        $menuItems = [];
        foreach ($locationSearchResults->searchHits as $hit) {
            $menuItems[] = $hit->valueObject;
        }

        $pathArray = $pathString ? explode("/", $pathString) : [];

        $response = new Response();
        $response->setVary('X-User-Hash');

        return $this->templating->renderResponse(
            $template, [
                'menuItems' => $menuItems,
                'pathArray' => $pathArray,
            ], $response
        );
    }
}
