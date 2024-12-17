<?php
/**
 * @copyright Copyright (c) 2024 Magebit (https://magebit.com)
 * @author    Magebit <info@magebit.com>
 * @license   GNU General Public License ("GPL") v3.0
 */

declare(strict_types=1);

namespace Magebit\PageListWidget\Block\Widget;

use Exception;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magento\Widget\Block\BlockInterface;
use Magento\Cms\Model\ResourceModel\Page\CollectionFactory;
use Magento\Cms\Model\ResourceModel\Page\Collection;
use Psr\Log\LoggerInterface;

/**
 * PageList widget block for displaying a list of CMS pages
 *
 * @package Magebit\PageListWidget\Block\Widget
 */
class PageList extends Template implements BlockInterface
{
    /**
     * @var string
     */
    protected $_template = "widget/page_list.phtml";

    /**
     * PageList constructor.
     *
     * @param Context $context
     * @param CollectionFactory $pageCollectionFactory
     * @param LoggerInterface $logger
     * @param array $data
     */
    public function __construct(
        private readonly Context $context,
        private readonly CollectionFactory $pageCollectionFactory,
        private readonly LoggerInterface $logger,
        array $data = []
    ) {
        parent::__construct($this->context, $data);
    }

    /**
     * Get the title of the PageList widget.
     *
     * @return string|null
     */
    public function getTitle(): ?string
    {
        return $this->getData('title');
    }

    /**
     * Get the collection of active pages based on display mode and selected pages.
     *
     * @return Collection
     */
    public function getPages(): Collection
    {
        try {
            $collection = $this->pageCollectionFactory->create();
            $collection->addFieldToFilter('is_active', 1)
                ->addStoreFilter($this->_storeManager->getStore()->getId());

            $displayMode = $this->getData('display_mode');
            $selectedPages = $this->getSelectedPages();

            if ($displayMode === 'specific_pages' && !empty($selectedPages)) {
                $collection->addFieldToFilter('identifier', ['in' => $selectedPages]);
            }

            return $collection;
        } catch (Exception $exception) {
            $this->logger->error('Error in getting pages: ' . $exception->getMessage());
            return $this->pageCollectionFactory->create();
        }
    }

    /**
     * Get an array of selected pages (if any).
     *
     * @return array
     */
    private function getSelectedPages(): array
    {
        $selectedPages = $this->getData('selected_pages');

        if (is_string($selectedPages) && !empty($selectedPages)) {
            return array_filter(array_map('trim', explode(',', $selectedPages)));
        }

        return [];
    }
}
