import './bootstrap';

window.debounceSubmit = (function () {
    let timeout;
    return function (form) {
        clearTimeout(timeout);
        timeout = setTimeout(() => {
            form.submit();
        }, 600);
    };
})();
