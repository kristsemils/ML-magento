<?php
/**
 * @copyright Copyright (c) 2024 Magebit
 * @author    Magebit
 * @license   GNU General Public License ("GPL") v3.0
 */

declare(strict_types=1);

namespace Magebit\Faq\Ui\Component\Listing\Column;

use Magento\Ui\Component\Listing\Columns\Column;

class Update extends Column
{

    /**
     * @var array|string[]
     */
    protected array $status = [
        '0' => 'Disabled',
        '1' => 'Enabled'
    ];

    /**
     * Prepare Data Source
     *
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource): array
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as & $item) {
                $item['status'] = $this->status[$item['status']];
            }
        }
        return $dataSource;
    }
}
