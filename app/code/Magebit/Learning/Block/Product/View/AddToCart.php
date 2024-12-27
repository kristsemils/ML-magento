<?php
/**
 * @copyright Copyright (c) 2024 Magebit (https://magebit.com)
 * @author    Magebit <info@magebit.com>
 * @license   GNU General Public License ("GPL") v3.0
 *
 * Add to Cart block for product view
 */

declare(strict_types=1);

namespace Magebit\Learning\Block\Product\View;

use Magento\Catalog\Model\Product;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magento\Framework\Registry;
use Magento\InventorySalesApi\Api\GetProductSalableQtyInterface;

/**
 * Class AddToCart
 *
 * Block class for Add to Cart functionality on product view page
 */
class AddToCart extends Template
{
    /**
     * @param Context $context
     * @param Registry $registry
     * @param GetProductSalableQtyInterface $getProductSalableQty
     * @param array $data
     */
    public function __construct(
        private readonly Registry $registry,
        private readonly GetProductSalableQtyInterface $getProductSalableQty,
        private readonly Context $context,
        array $data = []
    ) {
        parent::__construct($this->context, $data);
    }

    /**
     * Get current product
     *
     * @return Product|null
     */
    public function getProduct(): ?Product
    {
        return $this->registry->registry('product');
    }

    /**
     * Get Add to Cart URL for the product
     *
     * @param Product $product
     * @return string
     */
    public function getAddToCartUrl(Product $product): string
    {
        return $this->getUrl('checkout/cart/add', ['product' => $product->getId()]);
    }

    /**
     * Get the stock quantity for the product using MSI
     *
     * @return float
     */
    public function getStockQuantity(): float
    {
        $product = $this->getProduct();

        if (!$product) {
            return 0;
        }

        $sku = $product->getSku();
        $stockId = 1;

        try {
            return $this->getProductSalableQty->execute($sku, $stockId);
        } catch (\Exception $e) {
            return 0;
        }
    }
}
