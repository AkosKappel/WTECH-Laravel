@once
    <script>
        document.addEventListener('click', function (event) {
            var button = event.target.closest('[data-copy]');
            if (!button) return;
            var source = document.querySelector(button.dataset.copy);
            var text = source.value !== undefined ? source.value : source.textContent;
            var done = function () {
                var label = button.textContent;
                button.textContent = button.dataset.copied;
                setTimeout(function () { button.textContent = label; }, 1500);
            };
            if (navigator.clipboard && window.isSecureContext) {
                navigator.clipboard.writeText(text.trim()).then(done);
            } else {
                var area = document.createElement('textarea');
                area.value = text.trim(); document.body.appendChild(area); area.select();
                try { document.execCommand('copy'); done(); } catch (e) {}
                area.remove();
            }
        });
    </script>
@endonce
