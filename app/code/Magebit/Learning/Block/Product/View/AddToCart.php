<?php
/**
 * @copyright Copyright (c) 2024 Magebit (https://magebit.com)
 * @author    Magebit
 * @license   GNU General Public License ("GPL") v3.0
 */

namespace Magebit\Learning\Block\Product\View;

use Magento\Catalog\Model\Product;
use Magento\CatalogInventory\Api\StockRegistryInterface;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magento\Framework\Registry;

class AddToCart extends Template
{
    /**
     * Constructor
     *
     * @param Context $context
     * @param StockRegistryInterface $stockRegistry
     * @param Registry $registry
     * @param array $data
     */
    public function __construct(
        private readonly Context $context,
        private readonly StockRegistryInterface $stockRegistry,
        private readonly Registry $registry,
        array $data = []
    ) {
        parent::__construct($this->context, $data);
    }

    /**
     * Get current product
     *
     * @return Product|null
     */
    public function getProduct()
    {
        return $this->registry->registry('product');
    }

    /**
     * Get add to cart URL
     *
     * @param Product|null $product
     * @return string
     */
    public function getAddToCartUrl($product = null)
    {
        $product = $product ?: $this->getProduct();
        return $this->getUrl('checkout/cart/add', ['product' => $product->getId()]);
    }

    /**
     * Get stock quantity
     *
     * @param Product|null $product
     * @return float
     */
    public function getStockQuantity($product = null)
    {
        $product = $product ?: $this->getProduct();
        if (!$product) {
            return 0;
        }

        $stockItem = $this->stockRegistry->getStockItem($product->getId());
        return $stockItem ? $stockItem->getQty() : 0;
    }
}
