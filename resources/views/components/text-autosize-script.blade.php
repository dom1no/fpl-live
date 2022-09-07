@once
    @push('js')
        <script type="text/javascript">
            $(document).ready(function () {
                $('.text-autosize-container').each((i, el) => {
                    resizeByWidth($(el));
                });
            });

            function resizeByWidth(el) {
                let containerWidth = el.width();
                let elementWidth = el.find('.text-autosize-element').toArray().reduce((n, el) => n + $(el).width(), 0)
                console.log(containerWidth, elementWidth);

                if (elementWidth > containerWidth) {
                    let fontsize = el.css('font-size');
                    el.css('fontSize', parseFloat(fontsize) - 1);
                    resizeByWidth(el);
                }
            }
        </script>
    @endpush
@endonce
