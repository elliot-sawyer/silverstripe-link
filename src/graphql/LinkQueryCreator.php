<?php

namespace gorriecoe\Link\GraphQL;

use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use SilverStripe\GraphQL\OperationResolver;
use SilverStripe\GraphQL\QueryCreator;
use gorriecoe\Link\Models\Link;

if (!class_exists(QueryCreator::class)) {
    return;
}
/**
 * LinkQueryCreator
 *
 * @package silverstripe-link
 */
class LinkQueryCreator extends QueryCreator implements OperationResolver
{
    public function attributes()
    {
        return [
            'name' => 'link'
        ];
    }

    public function args()
    {
        return [
            'ID' => [
                'type' => Type::id()
            ]
        ];
    }

    public function type()
    {
        return $this->manager->getType('link');
    }

    public function resolve($object, array $args, $context, ResolveInfo $info)
    {
        $link = Link::singleton();
        if (!$link->canView($context['currentUser'])) {
            throw new \InvalidArgumentException(sprintf(
                '%s view access not permitted',
                Link::class
            ));
        }
        if (isset($args['ID'])) {
            return Link::get_by_id($args['ID']);
        }
    }
}
