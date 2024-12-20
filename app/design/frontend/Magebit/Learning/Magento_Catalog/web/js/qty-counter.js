/**
 * @copyright Copyright (c) 2024 Magebit (https://magebit.com)
 * @author    Magebit <info@magebit.com>
 * @license   GNU General Public License ("GPL") v3.0
 */
function subtract() {
    document.getElementById("qty").value = Math.max(1, +document.getElementById("qty").value - 1);
}

function add() {
    document.getElementById("qty").value = Math.min(+document.getElementById("qty").max, +document.getElementById("qty").value + 1);
}
