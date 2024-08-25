<?php

declare(strict_types=1);

namespace Pixelant\PxaProductManager\Service\Resource;

use Pixelant\PxaProductManager\Domain\Resource\ResourceInterface;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use Psr\Container\ContainerInterface;

class ResourceConverter
{
    private ContainerInterface $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * Convert entity to array using resource.
     *
     * @param AbstractEntity $entity
     * @param string|null $resource
     * @return array
     */
    public function convert(AbstractEntity $entity, string $resource = null): array
    {
        $resource ??= $this->translateEntityNameToResourceName($entity);
        /** @var ResourceInterface $resourceInstance */
        $resourceInstance = $this->container->get($resource);
        $resourceInstance->setEntity($entity);

        return $resourceInstance->toArray();
    }

    /**
     * Convert many entities.
     *
     * @param AbstractEntity[] $entities
     * @param string $resource
     * @return array
     */
    public function convertMany(array $entities, string $resource = null): array
    {
        return array_map(fn (AbstractEntity $entity) => $this->convert($entity, $resource), $entities);
    }

    /**
     * Translate entity to its corresponding resource.
     *
     * @param AbstractEntity $entity
     * @return string
     */
    protected function translateEntityNameToResourceName(AbstractEntity $entity): string
    {
        $entityName = get_class($entity);
        $resource = str_replace('\\Model\\', '\\Resource\\', $entityName);

        // If entity was extended, but no resource exist, fallback to original
        if (!class_exists($resource)) {
            [$lastPart] = explode('\\', strrev($entityName), 2);

            $resource = 'Pixelant\\PxaProductManager\\Domain\\Resource\\' . strrev($lastPart);
        }

        return $resource;
    }
}