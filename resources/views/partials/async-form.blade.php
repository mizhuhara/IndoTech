{{-- ========================================================================= --}}
{{-- ASSET: GENERIC ASYNC FORM SAVE --}}
{{-- Add data-async to a form to save it via fetch (no page reload). --}}
{{-- Optional: data-async-reset, data-async-reload, data-async-follow, data-async-redirect="url" --}}
{{-- ========================================================================= --}}

<style>
    .form-error { margin-top: .25rem; font-size: .75rem; color: #e11d48; }
</style>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const escapeHtml = (value) => String(value)
            .replaceAll('&', '&amp;')
            .replaceAll('<', '&lt;')
            .replaceAll('>', '&gt;')
            .replaceAll('"', '&quot;')
            .replaceAll("'", '&#039;');

        const notify = (type, title, message) => {
            const toastApi = window.showSplashToast ?? window.showToast;

            if (typeof toastApi === 'function') {
                toastApi({ type, title, message: escapeHtml(message) });

                return;
            }

            let box = document.getElementById('async-toast-box');

            if (!box) {
                box = document.createElement('div');
                box.id = 'async-toast-box';
                box.style.cssText = 'position:fixed;top:1rem;right:1rem;z-index:9999;display:flex;flex-direction:column;gap:.5rem;max-width:22rem;';
                document.body.appendChild(box);
            }

            const toast = document.createElement('div');
            const color = type === 'error' ? '#e11d48' : '#059669';
            toast.style.cssText = `background:#fff;border-left:4px solid ${color};box-shadow:0 8px 24px rgba(15,23,42,.15);border-radius:.5rem;padding:.75rem 1rem;font-size:.875rem;color:#0f172a;`;

            const heading = document.createElement('strong');
            heading.textContent = title;

            const body = document.createElement('p');
            body.style.margin = '.25rem 0 0';
            body.textContent = message;

            toast.append(heading, body);
            box.appendChild(toast);
            setTimeout(() => toast.remove(), 4500);
        };

        const findSubmitBtn = (form) => form.querySelector('button[type="submit"]')
            ?? (form.id ? document.querySelector(`button[type="submit"][form="${form.id}"]`) : null);

        const clearFieldErrors = (form) => {
            form.querySelectorAll('[data-async-error]').forEach((el) => el.remove());
            form.querySelectorAll('[data-async-invalid]').forEach((el) => {
                el.classList.remove('border-rose-400', 'ring-2', 'ring-rose-100');
                delete el.dataset.asyncInvalid;
            });
        };

        const showFieldErrors = (form, errors) => {
            clearFieldErrors(form);

            let firstInvalid = null;

            Object.entries(errors).forEach(([name, messages]) => {
                const base = name.split('.')[0];
                const field = Array.from(form.elements).find((el) => (
                    el.name === name || el.name === base || el.name === `${base}[]`
                ));

                if (!field) return;

                const message = document.createElement('p');
                message.className = 'form-error';
                message.dataset.asyncError = 'true';
                message.textContent = messages[0] || 'Nilai tidak valid.';
                field.insertAdjacentElement('afterend', message);

                field.classList.add('border-rose-400', 'ring-2', 'ring-rose-100');
                field.dataset.asyncInvalid = 'true';

                firstInvalid = firstInvalid ?? field;
            });

            firstInvalid?.focus();
        };

        const saveForm = async (form) => {
            const submitBtn = findSubmitBtn(form);
            if (!submitBtn || submitBtn.disabled) return;

            const originalBtnHtml = submitBtn.innerHTML;
            const tokenInput = form.querySelector('input[name="_token"]');

            submitBtn.disabled = true;
            submitBtn.innerHTML = 'Menyimpan...';

            try {
                const response = await fetch(form.action, {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': tokenInput ? tokenInput.value : '',
                    },
                    body: new FormData(form),
                });

                if (!(response.headers.get('content-type') || '').includes('application/json')) {
                    window.location.href = @json(route('login'));

                    return;
                }

                const payload = await response.json().catch(() => ({}));

                if (!response.ok) {
                    const firstError = payload.errors ? Object.values(payload.errors)[0] : null;

                    if (payload.errors) showFieldErrors(form, payload.errors);

                    notify('error', 'Gagal menyimpan', firstError ? firstError[0] : (payload.message || `Terjadi kesalahan (${response.status}).`));

                    return;
                }

                clearFieldErrors(form);

                notify('success', 'Berhasil', payload.message || 'Data berhasil disimpan.');

                if (form.hasAttribute('data-async-reset')) form.reset();

                if (form.hasAttribute('data-async-follow') && payload.redirect) {
                    setTimeout(() => { window.location.href = payload.redirect; }, 600);
                } else if (form.hasAttribute('data-async-reload')) {
                    setTimeout(() => window.location.reload(), 700);
                }

                if (form.dataset.asyncRedirect) window.location.href = form.dataset.asyncRedirect;
            } catch (error) {
                notify('error', 'Koneksi gagal', 'Tidak dapat menghubungi server. Coba lagi.');
            } finally {
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalBtnHtml;
            }
        };

        window.saveFormAsync = saveForm;

        document.querySelectorAll('form[data-async]').forEach((form) => {
            form.addEventListener('input', () => clearFieldErrors(form));
            form.addEventListener('change', () => clearFieldErrors(form));

            form.addEventListener('submit', (event) => {
                if (event.defaultPrevented) return;

                event.preventDefault();
                saveForm(form);
            });
        });
    });
</script>
