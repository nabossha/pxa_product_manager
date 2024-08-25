<?php

declare(strict_types=1);

namespace Pixelant\PxaProductManager\UserFunction\Solr;

use InvalidArgumentException;
use Pixelant\PxaProductManager\Domain\Model\AttributeValue;
use Pixelant\PxaProductManager\Domain\Repository\AttributeValueRepository;
use TYPO3\CMS\Extbase\Persistence\Generic\Mapper\DataMapper;
use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;

abstract class AbstractValue
{
    /**
     * @var ContentObjectRenderer
     */
    protected ContentObjectRenderer $cObj;

    /**
     * @var DataMapper
     */
    public DataMapper $dataMapper;

    /**
     * @var AttributeValueRepository
     */
    protected AttributeValueRepository $repository;

    /**
     * @param DataMapper $dataMapper
     */
    public function injectDataMapper(DataMapper $dataMapper): void
    {
        $this->dataMapper = $dataMapper;
    }

    /**
     * @param AttributeValueRepository $repository
     */
    public function injectAttributeValueRepository(AttributeValueRepository $repository): void
    {
        $this->repository = $repository;
    }

    /**
     * Return mapped AttributeValue.
     *
     * @param array $params
     * @return AttributeValue|null
     * @throws InvalidArgumentException
     */
    public function initValue(array $params): ?AttributeValue
    {
        if (empty($params['identifier'])) {
            throw new InvalidArgumentException('Identifier could not be empty', 1503304897705);
        }

        $identifier = $params['identifier'];
        $productUid = $this->cObj->data['_LOCALIZED_UID'] ?? $this->cObj->data['uid'];

        $row = $this->repository->findRawByProductAndAttributeIdentifier(
            (int)$productUid,
            $identifier
        );

        if (!empty($row)) {
            /** @var AttributeValue $obj */
            $obj = $this->dataMapper->map(
                AttributeValue::class,
                [$row]
            )[0];

            if ($obj instanceof AttributeValue) {
                return $obj;
            }
        }

        return null;
    }

    public function setContentObjectRenderer(ContentObjectRenderer $cObj): void
    {
        $this->cObj = $cObj;
    }
}
