<?php
/**
 * @copyright Copyright (c) 2024 Magebit, Ltd. (https://magebit.com/)
 * @author    Magebit
 * @license   GNU General Public License ("GPL") v3.0
 */


namespace Magebit\Faq\Model\Question\Source;

use Magento\Framework\Data\OptionSourceInterface;

class Status implements OptionSourceInterface
{
    const STATUS_ENABLED = 1;
    const STATUS_DISABLED = 0;

    /**
     * Get available status options
     *
     * @return array
     */
    public function toOptionArray()
    {
        return [
            ['value' => self::STATUS_ENABLED, 'label' => __('Enabled')],
            ['value' => self::STATUS_DISABLED, 'label' => __('Disabled')]
        ];
    }

    /**
     * Get status options as key-value pairs
     *
     * @return array
     */
    public function getOptionsArray()
    {
        return [
            self::STATUS_ENABLED => __('Enabled'),
            self::STATUS_DISABLED => __('Disabled')
        ];
    }
}
