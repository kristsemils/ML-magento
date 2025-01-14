<?php
/**
 * @copyright Copyright (c) 2024 Magebit
 * @author    Magebit
 * @license   GNU General Public License ("GPL") v3.0
 */

namespace Magebit\Faq\Ui\Component\Form\Button;

use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;
use Magento\Framework\UrlInterface;

class Back implements ButtonProviderInterface
{
    /**
     * Constructor
     *
     * @param UrlInterface $urlBuilder
     */
    public function __construct(
        private readonly UrlInterface $urlBuilder,
    ) {
    }

    /**
     * Get button configuration for the "Back" button
     *
     * @return array
     */
    public function getButtonData(): array
    {
        return [
            'label' => __('Back'),
            'on_click' => sprintf("location.href = '%s';", $this->getBackUrl()),
            'class' => 'back',
            'sort_order' => 20,
        ];
    }

    /**
     * Generate the URL to go back
     *
     * @return string
     */
    public function getBackUrl(): string
    {
        return $this->urlBuilder->getUrl('*/*/index');
    }
}
