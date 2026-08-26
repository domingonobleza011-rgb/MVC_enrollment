/**
 * Shared "review before you submit" confirmation step for the public
 * enrollment forms (grade7.php – grade12.php).
 *
 * On submit, instead of posting immediately, this builds a read-only
 * summary of everything the student is about to send (skipping hidden
 * fields, empty optional fields, and anything currently hidden by the
 * form's own show/hide logic — e.g. the 4Ps ID field when "4Ps
 * Beneficiary" is set to "No") and shows it in a SweetAlert2 dialog.
 * The student can go back and fix something, or confirm and the form
 * submits for real.
 *
 * Usage: just include this file after SweetAlert2 on any page that has
 * a <form id="enrollForm">. No other wiring needed.
 */
(function () {
    'use strict';

    function ready(fn) {
        if (document.readyState !== 'loading') fn();
        else document.addEventListener('DOMContentLoaded', fn);
    }

    function fieldLabel(el) {
        var container = el.closest('div');
        if (container) {
            var label = container.querySelector('label');
            if (label) {
                return label.textContent.replace(/\s+/g, ' ').trim().replace(/:$/, '');
            }
        }
        return el.placeholder || el.name || '';
    }

    function fieldValue(el) {
        if (el.tagName === 'SELECT') {
            if (el.selectedIndex < 0) return '';
            var opt = el.options[el.selectedIndex];
            return opt ? opt.text.trim() : '';
        }
        return (el.value || '').trim();
    }

    function isVisible(el) {
        // offsetParent is null for display:none elements (and their children),
        // which is exactly the "currently hidden by conditional JS" case we
        // want to skip (e.g. the IP Group field when "Is IP Member" = No).
        return el.offsetParent !== null;
    }

    function buildSummaryHtml(form) {
        var rows = [];
        var skipTypes = ['hidden', 'file', 'submit', 'button', 'reset'];
        var fields = form.querySelectorAll('input, select, textarea');

        fields.forEach(function (el) {
            if (!el.name) return;
            if (skipTypes.indexOf(el.type) !== -1) return;
            if (!isVisible(el)) return;

            var label = fieldLabel(el);
            var value = fieldValue(el);
            if (!value) return; // skip empty optional fields — nothing to confirm

            rows.push(
                '<tr>' +
                '<td style="padding:4px 10px 4px 0;color:#5a6478;white-space:nowrap;vertical-align:top;font-size:.82rem;">' + label + '</td>' +
                '<td style="padding:4px 0;font-weight:600;color:#1a1e2e;font-size:.85rem;">' + value.replace(/</g, '&lt;') + '</td>' +
                '</tr>'
            );
        });

        var fileInput = form.querySelector('input[type="file"][name="documents"]');
        var fileCount = (fileInput && fileInput.files) ? fileInput.files.length : 0;
        var fileRow =
            '<tr><td style="padding:8px 10px 4px 0;color:#5a6478;white-space:nowrap;vertical-align:top;font-size:.82rem;">Documents</td>' +
            '<td style="padding:8px 0 4px;font-weight:600;color:' + (fileCount ? '#1a1e2e' : '#c0392b') + ';font-size:.85rem;">' +
            (fileCount ? (fileCount + ' file(s) attached') : 'No files attached') + '</td></tr>';

        return (
            '<div style="text-align:left;max-height:50vh;overflow-y:auto;padding:0 4px;">' +
            '<table style="width:100%;border-collapse:collapse;">' + rows.join('') + fileRow + '</table>' +
            '</div>'
        );
    }

    ready(function () {
        var form = document.getElementById('enrollForm');
        if (!form || typeof Swal === 'undefined') return;

        var confirmed = false;

        form.addEventListener('submit', function (e) {
            if (confirmed) return; // second, programmatic submit — let it through
            e.preventDefault();

            var summaryHtml = buildSummaryHtml(form);

            Swal.fire({
                title: 'Review Your Enrollment',
                html:
                    '<p style="color:#5a6478;font-size:.88rem;margin-bottom:14px;">' +
                    'Please double-check the details below before submitting. You can go back and edit anything that\'s wrong.' +
                    '</p>' + summaryHtml,
                width: 640,
                icon: undefined,
                showCancelButton: true,
                confirmButtonText: 'Looks good, submit',
                cancelButtonText: 'Go back and edit',
                confirmButtonColor: '#0b2b5c',
                cancelButtonColor: '#6c757d',
                reverseButtons: true
            }).then(function (result) {
                if (result.isConfirmed) {
                    confirmed = true;
                    form.requestSubmit ? form.requestSubmit() : form.submit();
                }
            });
        });
    });
})();
