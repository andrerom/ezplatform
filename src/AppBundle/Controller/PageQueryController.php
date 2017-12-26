<?php
namespace AppBundle\Controller;

use eZ\Publish\API\Repository\LocationService;
use eZ\Publish\API\Repository\SearchService;
use eZ\Publish\API\Repository\Values\Content\LocationQuery;
use eZ\Publish\API\Repository\Values\Content\Query\Criterion;
use eZ\Publish\Core\MVC\Symfony\Controller\Content\QueryController;
use eZ\Publish\Core\MVC\Symfony\View\ContentView;
use eZ\Publish\Core\QueryType\ContentViewQueryTypeMapper;

/**
 * Extends Query controller by also querying for menu items.
 */
class PageQueryController extends QueryController
{
    /** @var \eZ\Publish\API\Repository\SearchService */
    private $ownSearchService;

    /** @var \eZ\Publish\Core\QueryType\ContentViewQueryTypeMapper */
    private $locationService;

    /** @var int */
    private $rootLocationId;

    public function __construct(
        ContentViewQueryTypeMapper $contentViewQueryTypeMapper,
        SearchService $searchService,
        LocationService $locationService,
        $contentTreeRootLocationId
    ) {
        $this->ownSearchService = $searchService;
        $this->locationService = $locationService;
        $this->rootLocationId = $contentTreeRootLocationId;
        parent::__construct($contentViewQueryTypeMapper, $searchService);
    }


    public function menuLocationQueryAction(ContentView $view) {

        if ($view->hasParameter('query')) {
            $this->locationQueryAction($view);
        }

        //$queryOptions = $view->getParameter('menu_query');
        $rootLocation = $this->locationService->loadLocation($this->rootLocationId);

        $query = new LocationQuery([
            'filter' => new Criterion\LogicalAnd([
                new Criterion\Visibility(Criterion\Visibility::VISIBLE),
                new Criterion\ParentLocationId($rootLocation->id)
            ]),
            'sortClauses' => $rootLocation->getSortClauses(),
        ]);

        $searchResults = $this->ownSearchService->findLocations($query);
        $view->addParameters(['root_location' => $rootLocation]);
        $view->addParameters(['menu_items' => $searchResults]);

        return $view;
    }
}
