document.addEventListener('DOMContentLoaded', function () {
    const formWrapper = document.getElementById('prescription-form');
    if (!formWrapper) return;

    const addBtns = [
        document.getElementById('add-prescription-btn'),
        document.getElementById('add-prescription-empty-btn'),
    ].filter(Boolean);

    const cancelBtn = document.getElementById('cancel-prescription-btn');

    function showForm() {
        formWrapper.style.display = 'block';
        const title = document.getElementById('prescription-title');
        if (title) title.focus();
    }

    function hideForm() {
        formWrapper.style.display = 'none';
    }

    addBtns.forEach(btn => btn.addEventListener('click', showForm));
    if (cancelBtn) cancelBtn.addEventListener('click', hideForm);
});