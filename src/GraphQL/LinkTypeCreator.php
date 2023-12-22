<?php

namespace gorriecoe\Link\GraphQL;

use GraphQL\Type\Definition\Type;
use SilverStripe\GraphQL\TypeCreator;
use SilverStripe\GraphQL\Pagination\Connection;

if (!class_exists(TypeCreator::class)) {
    return;
}

/**
 * LinkTypeCreator
 *
 * @package silverstripe-link
 */
class LinkTypeCreator extends TypeCreator
{
    public function attributes()
    {
        return [
            'name' => 'link'
        ];
    }

    public function fields()
    {
        return [
            'ID' => [
                'type' => Type::nonNull(Type::id())
            ],
            'ClassName' => [
                'type' => Type::string()
            ],
            'Title' => [
                'type' => Type::string()
            ],
            'Type' => [
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
            ],
            'Layout' => [
                'type' => Type::string()
            ],
        ];
    }
}
