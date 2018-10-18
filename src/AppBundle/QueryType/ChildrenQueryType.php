<?php

namespace AppBundle\QueryType;

use eZ\Publish\Core\QueryType\QueryType;
use eZ\Publish\API\Repository\Values\Content\Query;
use eZ\Publish\API\Repository\Values\Content\LocationQuery;

class ChildrenQueryType implements QueryType
{
    public function getQuery(array $parameters = [])
    {
        /** @var \eZ\Publish\API\Repository\Values\Content\Location $location */
        $location = $parameters['parent_location'];
        $options = [];

        $criteria = [
            new Query\Criterion\Visibility(Query\Criterion\Visibility::VISIBLE),
            new Query\Criterion\ParentLocationId($location->id),
        ];

        $options['filter'] = new Query\Criterion\LogicalAnd($criteria);

        if (isset($parameters['limit'])) {
            $options['limit'] = $parameters['limit'];
        }

        $options['sortClauses'] = $location->getSortClauses();

        return new LocationQuery($options);
    }

    public static function getName()
    {
        return 'AppBundle:Children';
    }

    public function getSupportedParameters()
    {
        return [
            'parent_location',
            'limit',
        ];
    }
}