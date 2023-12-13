<?php
/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2023 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 *
 */

namespace Tigren\PwaTask\Model\Resolver\Product;

use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;
use Magento\Catalog\Api\ProductRepositoryInterface;

class ShowOnPwaAttribute implements ResolverInterface
{

    protected $productRepositoryInterface;

    public function __construct(
        ProductRepositoryInterface $productRepositoryInterface
    )
    {
        $this->productRepositoryInterface = $productRepositoryInterface;
    }

    /**
     * @param Field $field
     * @param $context
     * @param ResolveInfo $info
     * @param array|null $value
     * @param array|null $args
     * @return array
     */
    public function resolve(Field $field, $context, ResolveInfo $info, array $value = null, array $args = null)
    {
        if (!isset($value['model'])) {
            throw new LocalizedException(__('"model" value should be specified'));
        }

        /** @var ProductInterface $productModel */
        $productModel = $value['model'];
        $productId = $productModel->getId();
        $productData = $this->productRepositoryInterface->getById($productId);
        return $productData->getCustomAttribute('show_on_pwa')->getValue();
    }
}
