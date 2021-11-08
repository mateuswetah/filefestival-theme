function buildTooltips(event) {

    if (event && event.detail && event.detail.isLoading === false) {
        setTimeout( function() {
            tippy('[data-tippy-content]', {
                duration: 100,
                arrow: false,
                maxWidth: 450,
                placement: 'auto',
                theme: 'light-border',
                allowHTML: true,
                content: function(reference) {
                    return reference.innerHTML ? reference.innerHTML : '';
                }
            });
        }, 750);
    }
}

document.addEventListener('tainacan-items-list-is-loading-items', buildTooltips);