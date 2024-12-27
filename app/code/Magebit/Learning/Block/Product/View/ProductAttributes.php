<?php
/**
 * @copyright Copyright (c) 2024 Magebit (https://magebit.com)
 * @author    Magebit <info@magebit.com>
 * @license   GNU General Public License ("GPL") v3.0
 *
 * Product Attributes block for product view
 */

declare(strict_types=1);

namespace Magebit\Learning\Block\Product\View;

use Magento\Catalog\Model\Product;
use Magento\Framework\View\Element\Template;
use Magento\Framework\Registry;
use Magento\Framework\View\Element\Template\Context;
use Magento\Catalog\Model\ResourceModel\Eav\Attribute;

/**
 * Class ProductAttributes
 *
 * Block class for displaying product attributes on product view page
 */
class ProductAttributes extends Template
{
    /**
     * Primary attributes to display
     *
     * @var array
     */
    private array $primaryAttributes = ['dimensions', 'color', 'material'];

    /**
     * Fallback attributes to display if primary ones are not available
     *
     * @var array
     */
    private array $fallbackAttributes = ['size', 'weight', 'manufacturer', 'brand'];

    /**
     * Maximum number of attributes to display
     *
     * @var int
     */
    private int $maxAttributes = 3;

    /**
     * @param Context $context
     * @param Registry $registry
     * @param array $data
     */
    public function __construct(
        Context $context,
        private readonly Registry $registry,
        array $data = []
    ) {
        parent::__construct($context, $data);
    }

    /**
     * Get current product
     *
     * @return Product|null
     */
    public function getProduct(): ?Product
    {
        return $this->registry->registry('current_product');
    }

    /**
     * Get filtered product attributes
     *
     * @return array
     */
    public function getFilteredAttributes(): array
    {
        $product = $this->getProduct();
        if (!$product) {
            return [];
        }

        $attributes = $product->getAttributes();
        $filteredAttributes = [];

        // First, try to get primary attributes
        foreach ($this->primaryAttributes as $code) {
            if (isset($attributes[$code]) && $this->isValidAttribute($attributes[$code], $product)) {
                $filteredAttributes[$code] = $attributes[$code];
            }
        }

        // If we don't have enough primary attributes, add fallback attributes
        if (count($filteredAttributes) < $this->maxAttributes) {
            foreach ($this->fallbackAttributes as $code) {
                if (count($filteredAttributes) >= $this->maxAttributes) {
                    break;
                }

                if (isset($attributes[$code]) &&
                    !isset($filteredAttributes[$code]) &&
                    $this->isValidAttribute($attributes[$code], $product)
                ) {
                    $filteredAttributes[$code] = $attributes[$code];
                }
            }
        }

        // If we still don't have enough attributes, try to get any visible attributes
        if (count($filteredAttributes) < $this->maxAttributes) {
            foreach ($attributes as $code => $attribute) {
                if (count($filteredAttributes) >= $this->maxAttributes) {
                    break;
                }

                if (!isset($filteredAttributes[$code]) &&
                    $this->isValidAttribute($attribute, $product)
                ) {
                    $filteredAttributes[$code] = $attribute;
                }
            }
        }

        return $filteredAttributes;
    }

    /**
     * Check if attribute is valid for display
     *
     * @param Attribute $attribute
     * @param Product $product
     * @return bool
     */
    private function isValidAttribute(Attribute $attribute, Product $product): bool
    {
        return $attribute->getIsVisible() &&
            $attribute->getIsUserDefined() &&
            $attribute->getFrontend()->getValue($product) !== null &&
            $attribute->getFrontend()->getValue($product) !== '';
    }

    /**
     * Get attribute display value
     *
     * @param Attribute $attribute
     * @param Product $product
     * @return string
     */
    public function getAttributeValue(Attribute $attribute, Product $product): string
    {
        return (string)$attribute->getFrontend()->getValue($product);
    }
}
