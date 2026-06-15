/**
 * Landolsi Widerrufsbutton — footer button injection (§ 356a BGB).
 *
 * Adds the legally required "Vertrag widerrufen" button to the footer service menu.
 * Theme-independent fallback: the plugin also ships Smarty footer extensions, but custom
 * themes (e.g. CleanTheme) register plugin templates at a lower priority, so the server-side
 * append may not apply there. This script guarantees the button is present on every page.
 *
 * Duplicate-safe: if the button already exists (server-side append worked), it does nothing.
 */
(function () {
    'use strict';

    function buildButton() {
        var a = document.createElement('a');
        a.className = 'btn is--primary landolsi-widerruf--footer-btn';
        a.href = (window.location.origin || '') + '/widerruf';
        a.title = 'Vertrag widerrufen';
        a.textContent = 'Vertrag widerrufen';
        return a;
    }

    function injectButton() {
        if (document.querySelector('.landolsi-widerruf--footer-btn')) {
            return; // already present (server-side append worked) — avoid duplicate
        }

        var serviceList = document.querySelector('.footer--column.column--menu .navigation--list');
        if (serviceList) {
            var li = document.createElement('li');
            li.className = 'navigation--entry landolsi-widerruf--footer-entry';
            li.setAttribute('role', 'menuitem');
            li.appendChild(buildButton());
            serviceList.appendChild(li);
            return;
        }

        // Fallback: any footer container
        var footer = document.querySelector('.footer-main') || document.querySelector('footer');
        if (footer) {
            var wrap = document.createElement('div');
            wrap.className = 'landolsi-widerruf--footer-entry landolsi-widerruf--footer-fallback';
            wrap.appendChild(buildButton());
            footer.appendChild(wrap);
        }
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', injectButton);
    } else {
        injectButton();
    }
})();
