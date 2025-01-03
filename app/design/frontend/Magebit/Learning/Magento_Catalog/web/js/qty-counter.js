/**
 * @copyright Copyright (c) 2024 Magebit, Ltd. (https://magebit.com/)
 * @author    Magebit <info@magebit.com>
 * @license   MIT
 */

'use strict';

define([
    'ko',
    'uiComponent'
], function (ko, Component) {
    'use strict';

    return Component.extend({
        defaults: {
            maxQty: 0,
            initialQty: 1
        },

        initialize: function (config) {
            this._super();
            this.maxQty = config.maxQty || this.maxQty;
            this.qty = ko.observable(this.initialQty);
        },

        decrease: function() {
            let updateQty = parseInt(this.qty(), 10);
            if (updateQty > 1) {
                this.qty(updateQty - 1);
            }
        },

        increase: function() {
            let updateQty = parseInt(this.qty(), 10);
            if (updateQty < this.maxQty) {
                this.qty(updateQty + 1);
            }
        },

        validateQty: function() {
            let currentQty = parseInt(this.qty(), 10);
            if (currentQty < 1) {
                this.qty(1);
            } else if (currentQty > this.maxQty) {
                this.qty(this.maxQty);
            }
        }
    });
});
