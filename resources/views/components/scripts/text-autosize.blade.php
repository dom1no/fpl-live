@once
    @push('js')
        <script type="text/javascript">
            $(document).ready(function () {
                $('.text-autosize-container').each((i, el) => {
                    resizeByWidth($(el));
                });
            });

            function resizeByWidth(el) {
                let containerWidth = el.outerWidth();

                let elements = el.find('.text-autosize-element');
                if (elements.length === 0) {
                    elements = el.children();
                }

                let overflowElements = elements.toArray().filter(el => el.scrollWidth > el.clientWidth)
                let scrollWidth = el.get(0).scrollWidth;
                console.log(containerWidth, scrollWidth, overflowElements, el.text());

                if (scrollWidth > containerWidth || overflowElements.length > 0) {
                    let fontsize = el.css('font-size');
                    console.log(parseFloat(fontsize) - 1, parseFloat(fontsize))
                    el.css('fontSize', parseFloat(fontsize) - 1);
                    resizeByWidth(el);
                }
            }
        </script>
    @endpush
@endonce
