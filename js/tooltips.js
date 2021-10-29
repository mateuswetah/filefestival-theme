tippy('[data-tippy-content]', {
    duration: 100,
    arrow: false,
    maxWidth: 450,
    placement: 'auto',
    theme: 'light-border',
    allowHTML: true,
    content: (reference) => {
        console.log(reference);
        return reference.innerHTML;
    }
});