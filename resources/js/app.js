import './bootstrap';

const setSpotlight = (card, x, y) => {
    card.style.setProperty('--mouse-x', `${x}px`);
    card.style.setProperty('--mouse-y', `${y}px`);
};

const registerSpotlight = () => {
    document.querySelectorAll('.card-spotlight').forEach((card) => {
        if (card.dataset.spotlightReady === 'true') {
            return;
        }

        card.dataset.spotlightReady = 'true';

        card.addEventListener('pointermove', (event) => {
            const rect = card.getBoundingClientRect();
            setSpotlight(card, event.clientX - rect.left, event.clientY - rect.top);
        });

        card.addEventListener('pointerleave', () => {
            setSpotlight(card, card.offsetWidth / 2, card.offsetHeight / 2);
        });
    });
};

const registerNavDropdowns = () => {
    const navItems = Array.from(document.querySelectorAll('[data-nav-item]'));
    if (!navItems.length) {
        return;
    }

    const closeItem = (item) => {
        const dropdown = item.querySelector('[data-nav-dropdown]');
        const trigger = item.querySelector('[data-nav-trigger]');
        const chevron = item.querySelector('[data-nav-chevron]');

        dropdown?.classList.remove('is-open');
        trigger?.setAttribute('aria-expanded', 'false');
        chevron?.classList.remove('rotate-180');
    };

    const closeAll = () => navItems.forEach((item) => closeItem(item));

    navItems.forEach((item) => {
        const trigger = item.querySelector('[data-nav-trigger]');
        const dropdown = item.querySelector('[data-nav-dropdown]');
        const chevron = item.querySelector('[data-nav-chevron]');

        if (!trigger || !dropdown) {
            return;
        }

        trigger.addEventListener('click', (event) => {
            event.preventDefault();
            const isOpen = dropdown.classList.contains('is-open');
            closeAll();

            if (!isOpen) {
                dropdown.classList.add('is-open');
                trigger.setAttribute('aria-expanded', 'true');
                chevron?.classList.add('rotate-180');
            }
        });
    });

    document.addEventListener('click', (event) => {
        if (!(event.target instanceof Element)) {
            return;
        }

        const parentItem = event.target.closest('[data-nav-item]');
        if (!parentItem) {
            closeAll();
        }
    });

    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape') {
            closeAll();
        }
    });
};

const registerNewsCarousel = () => {
    document.querySelectorAll('[data-news-carousel]').forEach((carousel) => {
        const track = carousel.querySelector('[data-news-track]');
        const slides = track ? Array.from(track.children) : [];

        if (!track || slides.length === 0) {
            return;
        }

        let index = 0;
        const total = slides.length;

        const update = () => {
            track.style.transform = `translateX(-${index * 100}%)`;
            carousel.querySelectorAll('[data-news-counter]').forEach((counter) => {
                counter.textContent = `${String(index + 1).padStart(2, '0')}/${String(total).padStart(2, '0')}`;
            });
        };

        update();

        const prev = carousel.querySelector('[data-news-prev]');
        const next = carousel.querySelector('[data-news-next]');

        prev?.addEventListener('click', () => {
            index = (index - 1 + total) % total;
            update();
        });

        next?.addEventListener('click', () => {
            index = (index + 1) % total;
            update();
        });
    });
};

const registerDropzones = () => {
    document.querySelectorAll('[data-dropzone]').forEach((dropzone) => {
        const fileInput = dropzone.querySelector('[data-dropzone-file]');
        const hiddenInput = dropzone.querySelector('[data-dropzone-input]');
        const preview = dropzone.querySelector('[data-dropzone-preview]');
        const placeholder = dropzone.querySelector('[data-dropzone-placeholder]');
        const button = dropzone.querySelector('[data-dropzone-button]');

        const updatePreview = (url) => {
            if (!preview) {
                const img = document.createElement('img');
                img.className = 'h-32 w-full rounded-2xl object-cover';
                img.dataset.dropzonePreview = '';
                dropzone.insertBefore(img, button);
            }

            const target = dropzone.querySelector('[data-dropzone-preview]');
            if (target) {
                target.src = url;
                target.classList.remove('hidden');
            }
            placeholder?.classList.add('hidden');
        };

        const handleFiles = (files) => {
            if (!files || !files.length) {
                return;
            }

            const file = files[0];
            if (fileInput) {
                const dataTransfer = new DataTransfer();
                dataTransfer.items.add(file);
                fileInput.files = dataTransfer.files;
            }

            const reader = new FileReader();
            reader.onload = (event) => {
                if (event.target?.result) {
                    updatePreview(event.target.result.toString());
                }
            };
            reader.readAsDataURL(file);

            hiddenInput?.setAttribute('value', '');
        };

        dropzone.addEventListener('dragover', (event) => {
            event.preventDefault();
            dropzone.classList.add('ring', 'ring-emerald-300/40');
        });

        dropzone.addEventListener('dragleave', (event) => {
            if (!dropzone.contains(event.relatedTarget)) {
                dropzone.classList.remove('ring', 'ring-emerald-300/40');
            }
        });

        dropzone.addEventListener('drop', (event) => {
            event.preventDefault();
            dropzone.classList.remove('ring', 'ring-emerald-300/40');
            handleFiles(event.dataTransfer?.files);
        });

        button?.addEventListener('click', () => fileInput?.click());
        fileInput?.addEventListener('change', (event) => handleFiles(event.target?.files));
    });
};

const registerRepeaters = (scope = document) => {
    const cloneTemplate = (template, replacements) => {
        if (!template) {
            return null;
        }

        let html = template.innerHTML;
        Object.entries(replacements).forEach(([placeholder, value]) => {
            const safe = placeholder.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
            html = html.replace(new RegExp(safe, 'g'), String(value));
        });

        const wrapper = document.createElement('div');
        wrapper.innerHTML = html.trim();
        return wrapper.firstElementChild;
    };

    const initWrapper = (wrapper) => {
        if (wrapper.dataset.repeaterInitialized === 'true') {
            return;
        }

        const container = wrapper.querySelector('[data-repeater]');
        if (!container) {
            return;
        }

        const type = container.dataset.repeater;
        const template = wrapper.querySelector(`[data-repeater-template="${type}"]`);
        let nextIndex = Number(container.getAttribute('data-repeater-next-index') ?? container.querySelectorAll('[data-repeater-item]').length);

        const toggleEmptyState = () => {
            const hasItems = container.querySelectorAll('[data-repeater-item]').length > 0;
            container.querySelectorAll('[data-repeater-empty]').forEach((el) => el.classList.toggle('hidden', hasItems));
        };

        const attachRemove = (scopeEl) => {
            scopeEl.querySelectorAll('[data-repeater-remove]').forEach((button) => {
                if (button.dataset.repeaterBound === 'true') {
                    return;
                }
                button.dataset.repeaterBound = 'true';
                button.addEventListener('click', () => {
                    const item = button.closest('[data-repeater-item]');
                    item?.remove();
                    toggleEmptyState();
                });
            });
        };

        wrapper.querySelectorAll(`[data-repeater-add="${type}"]`).forEach((button) => {
            if (button.dataset.repeaterBound === 'true') {
                return;
            }

            button.dataset.repeaterBound = 'true';
            button.addEventListener('click', () => {
                const parentIndex = container.dataset.parentIndex ?? nextIndex;
                const replacements = {
                    '__INDEX__': nextIndex,
                    '__PARENT_INDEX__': parentIndex,
                    '__ASSET_INDEX__': nextIndex,
                };
                const fragment = cloneTemplate(template, replacements);
                if (!fragment) {
                    return;
                }
                container.appendChild(fragment);
                nextIndex += 1;
                attachRemove(fragment);
                toggleEmptyState();
                registerRepeaters(fragment);
            });
        });

        attachRemove(container);
        toggleEmptyState();
        wrapper.dataset.repeaterInitialized = 'true';
    };

    scope.querySelectorAll('[data-repeater-wrapper]').forEach(initWrapper);
};

const registerTimelineProgress = () => {
    const containers = document.querySelectorAll('[data-timeline-container]');
    if (!containers.length) {
        return;
    }

    const updateForContainer = (container) => {
        const line = container.parentElement?.querySelector('.timeline-line-progress');
        const steps = container.querySelectorAll('[data-timeline-step]');
        if (!line || !steps.length) {
            return;
        }

        const completedSteps = Array.from(steps).filter((step) => step.dataset.timelineStatus === 'completed');
        const target = completedSteps[completedSteps.length - 1] ?? steps[0];
        const containerRect = container.getBoundingClientRect();
        const targetRect = target.getBoundingClientRect();
        const height = Math.min(
            Math.max(targetRect.bottom - containerRect.top, 0),
            container.scrollHeight
        );

        line.style.height = `${height}px`;
    };

    const resizeObserver = new ResizeObserver((entries) => {
        entries.forEach((entry) => updateForContainer(entry.target));
    });

    containers.forEach((container) => {
        updateForContainer(container);
        resizeObserver.observe(container);
    });

    window.addEventListener('scroll', () => {
        containers.forEach(updateForContainer);
    });
};

const initWorkspaceUi = () => {
    registerSpotlight();
    registerNavDropdowns();
    registerNewsCarousel();
    registerDropzones();
    registerRepeaters();
    registerTimelineProgress();
};

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initWorkspaceUi);
} else {
    initWorkspaceUi();
}
