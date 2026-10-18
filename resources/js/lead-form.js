document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('leadForm');
    if (!form) return;

    const submitBtn = document.getElementById('submitBtn');
    const formSuccess = document.getElementById('formSuccess');
    const formError = document.getElementById('formError');

    const urlParams = new URLSearchParams(window.location.search);
    const utms = {
        utm_source: urlParams.get('utm_source'),
        utm_medium: urlParams.get('utm_medium'),
        utm_campaign: urlParams.get('utm_campaign'),
        utm_content: urlParams.get('utm_content'),
        utm_term: urlParams.get('utm_term'),
        page_url: window.location.href
    };

    form.addEventListener('submit', async (e) => {
        e.preventDefault();

        submitBtn.disabled = true;
        submitBtn.textContent = 'Отправка...';
        formSuccess.style.display = 'none';
        formError.style.display = 'none';
        document.querySelectorAll('.error-text').forEach(el => el.style.display = 'none');

        const formData = new FormData(form);
        const data = Object.fromEntries(formData.entries());
        Object.assign(data, utms);

        try {
            const response = await fetch('/api/lead', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify(data)
            });

            const result = await response.json();

            if (response.ok) {
                // Успех (201) — скрываем форму
                form.style.display = 'none';
                formSuccess.textContent = result.message;
                formSuccess.style.display = 'block';
            } else if (response.status === 422) {
                // Ошибки валидации — показываем под полями, форму НЕ скрываем
                const errors = result.errors;
                for (const [field, messages] of Object.entries(errors)) {
                    const errorEl = document.querySelector(`[data-error="${field}"]`);
                    if (errorEl) {
                        errorEl.textContent = messages[0];
                        errorEl.style.display = 'block';
                    }
                }
            } else if (response.status === 429) {
                // Дубль (429) — показываем сообщение, но форму НЕ скрываем
                // Даем клиенту шанс исправить номер
                formError.textContent = result.message;
                formError.style.display = 'block';
            } else {
                throw new Error('Server error');
            }
        } catch (error) {
            formError.textContent = 'Ошибка соединения. Проверьте интернет и попробуйте снова.';
            formError.style.display = 'block';
        } finally {
            submitBtn.disabled = false;
            submitBtn.textContent = 'Отправить заявку';
        }
    });
    form.querySelectorAll('input, textarea').forEach(input => {
        input.addEventListener('input', () => {
            formError.style.display = 'none';
            const fieldName = input.getAttribute('name');
            const errorEl = document.querySelector(`[data-error="${fieldName}"]`);
            if (errorEl) errorEl.style.display = 'none';
        });
    });
});