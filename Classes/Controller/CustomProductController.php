<?php

declare(strict_types=1);

namespace Pixelant\PxaProductManager\Controller;

use Psr\Http\Message\ResponseInterface;
use Pixelant\PxaProductManager\Domain\Collection\CanCreateCollection;
use Pixelant\PxaProductManager\Domain\Model\Category;
use Pixelant\PxaProductManager\Domain\Model\DTO\ProductDemand;
use Pixelant\PxaProductManager\Domain\Repository\ProductRepository;
use Pixelant\PxaProductManager\Service\Resource\ResourceConverter;

class CustomProductController extends AbstractController
{
    use CanCreateCollection;

    /**
     * @var ProductRepository
     */
    protected ProductRepository $productRepository;

    /**
     * @var ResourceConverter
     */
    protected ResourceConverter $resourceConverter;

    /**
     * @param ProductRepository $productRepository
     */
    public function injectProductRepository(ProductRepository $productRepository): void
    {
        $this->productRepository = $productRepository;
    }

    /**
     * @param ResourceConverter $resourceConverter
     */
    public function injectResourceConverter(ResourceConverter $resourceConverter): void
    {
        $this->resourceConverter = $resourceConverter;
    }

    /**
     * Selection of products.
     */
    public function listAction(): ResponseInterface
    {
        switch ($this->settings['customProductsList']['mode']) {
            case 'products':
                $products = $this->findRecordsByList(
                    $this->settings['customProductsList']['products'],
                    $this->productRepository
                );

                break;
            default:
                $products = $this->getProductsByDemand();

                break;
        }

        $this->view->assignMultiple(compact('products'));
        return $this->htmlResponse();
    }

    /**
     * Get products based on demand.
     *
     * @return Category[]
     */
    protected function getProductsByDemand(): array
    {
        /** @var ProductDemand $demand */
        $demand = $this->createProductsDemand($this->settings);

        return $this->productRepository->findDemanded($demand);
    }
}
