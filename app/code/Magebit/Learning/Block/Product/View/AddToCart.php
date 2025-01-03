<?php
/**
 * @copyright Copyright (c) 2024 Magebit
 * @author    Magebit
 * @license   GNU General Public License ("GPL") v3.0
 *
 * Add to Cart block for product view
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
use Magento\Framework\Url\EncoderInterface;
use Magento\Framework\Json\EncoderInterface as JsonEncoderInterface;
use Magento\Customer\Model\Session;
use Magento\Framework\Locale\FormatInterface;
use Magento\Framework\Pricing\PriceCurrencyInterface;
use Magento\Framework\Stdlib\StringUtils;
use Magento\InventorySalesApi\Api\GetProductSalableQtyInterface;

/**
 * Class AddToCart
 *
 * Block class for Add to Cart functionality on the product view page.
 */
class AddToCart extends ProductViewBlock
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
        private readonly GetProductSalableQtyInterface $getProductSalableQty,
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
            (array)$this->getProductSalableQty,
            $data
        );
    }

    /**
     * Get the Add to Cart URL for the product.
     *
     * @param Product $product
     * @param array $additional
     * @return string
     */
    public function getAddToCartUrl($product, $additional = []): string
    {
        return $this->getUrl('checkout/cart/add', ['product' => $product->getId()]);
    }

    /**
     * Get the stock quantity for the product using MSI.
     *
     * @return float
     */
    public function getStockQuantity(): float
    {
        $product = $this->getProduct();

        if (!$product) {
            return 0.0;
        }

        $sku = $product->getSku();
        $stockId = 1;

        try {
            return $this->getProductSalableQty->execute($sku, $stockId);
        } catch (Exception $e) {
            $this->_logger->error(__('Error fetching salable quantity: %1', $e->getMessage()));
            return 0.0;
        }
    }
}
