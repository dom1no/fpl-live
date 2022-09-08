<script type="text/javascript">
    const tabHasPrefix = '#tab-';

    const hash = location.hash;
    if (hash && hash.startsWith(tabHasPrefix)) {
        const tabHash = hash.replace(tabHasPrefix, '');
        $(`.nav-persistent a[href="#${tabHash}"]`).tab('show');
    }

    $('.nav-persistent a').on('shown.bs.tab', e => {
        window.location.hash = tabHasPrefix + e.target.hash.replace('#', '');
    });
</script>
