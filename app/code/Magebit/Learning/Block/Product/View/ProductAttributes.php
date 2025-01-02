<?php
/**
 * @copyright Copyright (c) 2024 Magebit
 * @author    Magebit
 * @license   GNU General Public License ("GPL") v3.0
 *
 * Product Attributes block for product view
 */

declare(strict_types=1);

namespace Magebit\Learning\Block\Product\View;

use Exception;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Catalog\Block\Product\Context;
use Magento\Catalog\Block\Product\View as ProductViewBlock;
use Magento\Catalog\Helper\Product as ProductHelper;
use Magento\Catalog\Model\Product;
use Magento\Catalog\Model\ProductTypes\ConfigInterface;
use Magento\Customer\Model\Session;
use Magento\Framework\Json\EncoderInterface as JsonEncoderInterface;
use Magento\Framework\Locale\FormatInterface;
use Magento\Framework\Pricing\PriceCurrencyInterface;
use Magento\Framework\Stdlib\StringUtils;
use Magento\Framework\Url\EncoderInterface;
use Magento\Catalog\Helper\Output as CatalogHelper;

/**
 * Class ProductAttributes
 *
 * Block class for displaying product attributes on the product view page.
 */
class ProductAttributes extends ProductViewBlock
{
    /**
     * @param Context $context
     * @param EncoderInterface $urlEncoder
     * @param JsonEncoderInterface $jsonEncoder
     * @param StringUtils $string
     * @param ProductHelper $productHelper
     * @param ConfigInterface $productTypeConfig
     * @param FormatInterface $localeFormat
     * @param Session $customerSession
     * @param ProductRepositoryInterface $productRepository
     * @param PriceCurrencyInterface $priceCurrency
     * @param CatalogHelper $catalogHelper
     * @param array $data
     */
    public function __construct(
        private readonly Context $context,
        EncoderInterface $urlEncoder,
        JsonEncoderInterface $jsonEncoder,
        StringUtils $string,
        ProductHelper $productHelper,
        ConfigInterface $productTypeConfig,
        FormatInterface $localeFormat,
        Session $customerSession,
        ProductRepositoryInterface $productRepository,
        PriceCurrencyInterface $priceCurrency,
        private readonly CatalogHelper $catalogHelper,
        array $data = []
    ) {
        parent::__construct(
            $this->context,
            $urlEncoder,
            $jsonEncoder,
            $string,
            $productHelper,
            $productTypeConfig,
            $localeFormat,
            $customerSession,
            $productRepository,
            $priceCurrency,
            $data
        );
    }

    /**
     * Get the product attributes to display
     *
     * @return array
     */
    public function getDisplayAttributes(): array
    {
        $product = $this->getProduct();
        if (!$product instanceof Product) {
            return [];
        }

        $attributes = $product->getAttributes();
        $displayAttributes = ['dimensions', 'color', 'material'];
        $result = [];

        foreach ($displayAttributes as $code) {
            if (isset($attributes[$code])) {
                $attribute = $attributes[$code];
                $result[] = [
                    'label' => $attribute->getStoreLabel(),
                    'value' => $attribute->getFrontend()->getValue($product)
                ];
            }
        }

        return $result;
    }

    /**
     * Get the product's short description
     *
     * @return string|null
     */
    public function getShortDescription(): ?string
    {
        $product = $this->getProduct();
        if (!$product instanceof Product) {
            return null;
        }

        try {
            return $this->catalogHelper->productAttribute(
                $product,
                $product->getData('short_description'),
                'short_description'
            );
        } catch (Exception $e) {
            $this->_logger->error(__('Error fetching short description: %1', $e->getMessage()));
            return null;
        }
    }
}

