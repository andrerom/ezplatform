<?php
namespace AppBundle\QueryType;

use eZ\Publish\API\Repository\Values\Content\LocationQuery;
use eZ\Publish\API\Repository\Values\Content\Query\Criterion;
use eZ\Publish\Core\QueryType\QueryType;

/**
 * Class LocationChildrenQueryType
 *
 * For the time being only works from Twig template as it expects Location object
 * on parameter "parent" to avid loading it again when it is typically present.
 *
 * Use of types other then scalars as param is supported as of 1.7.1 (EZP-26777).
 *
 * For use when parent is not present or from config, there might be a feature
 * coming in 1.8 to allow Query types to transform optional params, like parentId
 * to the corresponding actual param which expects a object.
 *
 * It might look like the following, implementing RepositoryParamPass:
 * public function parameterPass(Repository $repository, array $params)
 * {
 *     if (isset($params['parentId'])) {
 *        $params['parent'] = $repository->getLocationService()->loadLocation($params['parentId']);
 *        unset($params['parentId']);
 *     }
 *
 *     return $params;
 * }
 *
 * @package AppBundle\QueryType
 */
class LocationChildrenQueryType implements QueryType
{
    public function getQuery(array $parameters = [])
    {
        /**
         * @var \eZ\Publish\API\Repository\Values\Content\Location $parent
         */
        $parent = $parameters['parent'];

        return new LocationQuery([
            'filter' => new Criterion\LogicalAnd([
                new Criterion\Visibility(Criterion\Visibility::VISIBLE),
                new Criterion\ParentLocationId($parent->id)
            ]),
            'sortClauses' => $parent->getSortClauses(),
        ]);
    }

    public function getSupportedParameters()
    {
        return ['parent'];
    }

    public static function getName()
    {
        return 'AppBundle:LocationChildren';
    }
}
