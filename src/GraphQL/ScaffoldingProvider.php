<?php


namespace gorriecoe\Link\GraphQL;

use gorriecoe\Link\Models\Link;
use SilverStripe\GraphQL\Scaffolding\Interfaces\ScaffoldingProvider as ScaffoldingProviderInterface;
use SilverStripe\GraphQL\Scaffolding\Scaffolders\SchemaScaffolder;

if (!interface_exists(ScaffoldingProviderInterface::class)) {
    return;
}

class ScaffoldingProvider implements ScaffoldingProviderInterface
{
    public function provideGraphQLScaffolding(SchemaScaffolder $scaffolder)
    {
        $sng = Link::singleton();
        $type = $scaffolder->type($sng->ClassName);

        $type->addAllFields()
            ->addFields($sng->gqlFields())
            ->operation(SchemaScaffolder::READ)
            ->setName('readLinks')
            ->setUsePagination(false)
            ->end()
            ->operation(SchemaScaffolder::READ_ONE)
            ->setName('readOneLink')
            ->end()
            ->operation(SchemaScaffolder::CREATE)
            ->setName('createLink')
            ->end()
            ->operation(SchemaScaffolder::UPDATE)
            ->setName('updateLink')
            ->end()
            ->operation(SchemaScaffolder::DELETE)
            ->setName('deleteLink')
            ->end()
            ->end();
        foreach ($sng->gqlNestedQueries() as $query => $paginated) {
            $type->nestedQuery($query)
                ->setUsePagination($paginated)
                ->end();
        }
        return $scaffolder;
    }


}
