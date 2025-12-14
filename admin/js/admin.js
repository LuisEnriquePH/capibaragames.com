/**
 * Admin Panel JavaScript Utilities
 * Handles confirmation modals, autosave, and other admin UX features
 */

// ========================================
// CONFIRMATION MODAL
// ========================================

class ConfirmModal {
    constructor() {
        this.createModal();
        this.attachEvents();
    }

    createModal() {
        const modalHTML = `
            <div id="confirm-modal" class="modal-overlay" style="display: none;">
                <div class="modal modal--confirm">
                    <div class="modal__header">
                        <h3 class="modal__title" id="modal-title">Confirmación</h3>
                    </div>
                    <div class="modal__body">
                        <p id="modal-message">¿Estás seguro?</p>
                    </div>
                    <div class="modal__footer">
                        <button class="btn btn--secondary" id="modal-cancel">Cancelar</button>
                        <button class="btn btn--primary" id="modal-confirm">Confirmar</button>
                    </div>
                </div>
            </div>
        `;
        document.body.insertAdjacentHTML('beforeend', modalHTML);

        this.modal = document.getElementById('confirm-modal');
        this.title = document.getElementById('modal-title');
        this.message = document.getElementById('modal-message');
        this.confirmBtn = document.getElementById('modal-confirm');
        this.cancelBtn = document.getElementById('modal-cancel');
    }

    attachEvents() {
        this.cancelBtn.addEventListener('click', () => this.hide());
        this.modal.addEventListener('click', (e) => {
            if (e.target === this.modal) this.hide();
        });

        // ESC key to close
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && this.modal.style.display === 'flex') {
                this.hide();
            }
        });
    }

    show(options) {
        const { title, message, confirmText, onConfirm, isDanger } = options;

        this.title.textContent = title || 'Confirmación';
        this.message.textContent = message || '¿Estás seguro?';
        this.confirmBtn.textContent = confirmText || 'Confirmar';

        // Apply danger styling for destructive actions
        if (isDanger) {
            this.confirmBtn.className = 'btn btn--danger';
            this.modal.querySelector('.modal').classList.add('modal--danger');
        } else {
            this.confirmBtn.className = 'btn btn--primary';
            this.modal.querySelector('.modal').classList.remove('modal--danger');
        }

        // Remove old listener and add new one
        const newConfirmBtn = this.confirmBtn.cloneNode(true);
        this.confirmBtn.parentNode.replaceChild(newConfirmBtn, this.confirmBtn);
        this.confirmBtn = newConfirmBtn;

        this.confirmBtn.addEventListener('click', () => {
            if (onConfirm) onConfirm();
            this.hide();
        });

        this.modal.style.display = 'flex';
        this.confirmBtn.focus();
    }

    hide() {
        this.modal.style.display = 'none';
    }
}

// Initialize modal globally
const confirmModal = new ConfirmModal();

// ========================================
// DELETE CONFIRMATION
// ========================================

function confirmDelete(itemName, deleteUrl) {
    confirmModal.show({
        title: '¿Borrar elemento?',
        message: `¿Estás seguro de que quieres borrar "${itemName}"? Esta acción no se puede deshacer.`,
        confirmText: 'Sí, borrar',
        isDanger: true,
        onConfirm: () => {
            window.location.href = deleteUrl;
        }
    });
}

// Attach to delete links
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('[data-delete-confirm]').forEach(link => {
        link.addEventListener('click', (e) => {
            e.preventDefault();
            const itemName = link.dataset.itemName || 'este elemento';
            const deleteUrl = link.href;
            confirmDelete(itemName, deleteUrl);
        });
    });
});

// ========================================
// AUTOSAVE FUNCTIONALITY
// ========================================

class AutoSave {
    constructor(formId, storageKey, interval = 30000) {
        this.form = document.getElementById(formId);
        if (!this.form) return;

        this.storageKey = storageKey;
        this.interval = interval;
        this.timer = null;

        this.init();
    }

    init() {
        // Restore draft on load
        this.restoreDraft();

        // Save on input
        this.form.addEventListener('input', () => {
            clearTimeout(this.timer);
            this.timer = setTimeout(() => this.save(), this.interval);
        });

        // Clear draft on successful submit
        this.form.addEventListener('submit', () => {
            this.clearDraft();
        });
    }

    save() {
        const formData = new FormData(this.form);
        const data = {};
        formData.forEach((value, key) => {
            if (key !== 'csrf_token') {  // Don't save CSRF token
                data[key] = value;
            }
        });
        data.timestamp = Date.now();

        localStorage.setItem(this.storageKey, JSON.stringify(data));
        console.log('Draft saved:', new Date(data.timestamp).toLocaleTimeString());
    }

    restoreDraft() {
        const draft = localStorage.getItem(this.storageKey);
        if (!draft) return;

        const data = JSON.parse(draft);
        const timeSince = Math.floor((Date.now() - data.timestamp) / 1000 / 60);

        if (confirm(`Se encontró un borrador guardado hace ${timeSince} minutos. ¿Deseas restaurarlo?`)) {
            Object.keys(data).forEach(key => {
                if (key !== 'timestamp') {
                    const field = this.form.querySelector(`[name="${key}"]`);
                    if (field) {
                        field.value = data[key];
                        // Trigger change event for any listeners (like EasyMDE)
                        field.dispatchEvent(new Event('change'));
                    }
                }
            });
        } else {
            this.clearDraft();
        }
    }

    clearDraft() {
        localStorage.removeItem(this.storageKey);
    }
}

// ========================================
// HELPER FUNCTIONS
// ========================================

// Search table rows
function filterTable(searchInput, tableId) {
    const filter = searchInput.value.toLowerCase();
    const table = document.getElementById(tableId);
    const rows = table.querySelectorAll('tbody tr');

    rows.forEach(row => {
        const text = row.textContent.toLowerCase();
        row.style.display = text.includes(filter) ? '' : 'none';
    });
}

// Select all checkboxes
function selectAll(checkbox, targetsClass) {
    const checkboxes = document.querySelectorAll('.' + targetsClass);
    checkboxes.forEach(cb => cb.checked = checkbox.checked);
}

console.log('Admin utilities loaded successfully');
