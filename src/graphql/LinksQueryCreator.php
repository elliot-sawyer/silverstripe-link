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
 * LinksQueryCreator
 *
 * @package silverstripe-link
 */
class LinksQueryCreator extends QueryCreator implements OperationResolver
{
    public function attributes()
    {
        return [
            'name' => 'links'
        ];
    }

    public function args()
    {
        return [
            'ID' => [
                'type' => Type::id()
            ],
            'Type' => [
                'type' => Type::string()
            ],
            'Title' => [
                'type' => Type::string()
            ],
            'URL' => [
                'type' => Type::string()
            ],
            'Email' => [
                'type' => Type::string()
            ],
            'Phone' => [
                'type' => Type::string()
            ],
            'OpenInNewWindow' => [
                'type' => Type::boolean()
            ],
            'LinkURL' => [
                'type' => Type::string()
            ],
            'Template' => [
                'type' => Type::string()
            ]
        ];
    }

    public function type()
    {
        return Type::listOf($this->manager->getType('link'));
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

        $filters = [
            'ID',
            'Title:PartialMatch',
            'Type',
            'URL:PartialMatch',
            'Email:PartialMatch',
            'Phone',
            'OpenInNewWindow',
        ];

        return $this->Filter(Link::get(), $filters,  $args);
    }

    public function Filter($list, array $filters, array $args)
    {
        foreach ($filters as $filter) {
            $modifier = '';
            if(strpos($filter, ':') !== false) {
                list($filter, $modifier) = explode(':', $filter);
                $modifier = ':' . $modifier;
            }
            if (isset($args[$filter])) {
                $list = $list->filter($filter . $modifier, $args[$filter]);
            }
        }
        return $list;
    }
}
