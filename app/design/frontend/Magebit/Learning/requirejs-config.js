/**
 * @copyright Copyright (c) 2024 Magebit (https://magebit.com)
 * @author    Magebit <info@magebit.com>
 * @license   GNU General Public License ("GPL") v3.0
 */

var config = {
    map: {
        '*': {
            'Magento_Catalog/css/styles': 'Magebit_Learning/css/styles',
            qtyCounter: 'Magento_Catalog/js/qty-counter'
        }
    },
    paths: {
        'Magebit_Learning/css/styles': 'Magebit_Learning/css/styles',
        qtyCounter: 'Magento_Catalog/js/qty-counter'
    },
    shim: {
        'Magebit_Learning/js/view/product/view': {
            deps: ['Magebit_Learning/css/styles']
        }
    }
};

require.config(config);
