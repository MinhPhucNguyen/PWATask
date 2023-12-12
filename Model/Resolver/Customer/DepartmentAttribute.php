<?php
/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2023 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 *
 */

namespace Tigren\PwaTask\Model\Resolver\Customer;

use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;

class DepartmentAttribute implements ResolverInterface
{

    protected $customerRepositoryInterface;

    public function __construct(
        CustomerRepositoryInterface $customerRepositoryInterface
    )
    {
        $this->customerRepositoryInterface = $customerRepositoryInterface;
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

        $customerModel = $value['model'];
        $customerId = $customerModel->getId();
        $customerData = $this->customerRepositoryInterface->getById($customerId);

        if ($customerData->getCustomAttribute('department')) {
            return $customerData->getCustomAttribute('department')->getValue();
        } else {
            return null;
        }
    }
}
