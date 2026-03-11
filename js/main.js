/* EnGuillem V2 — main.js */

(function () {
    'use strict';

    // ── Mobile nav toggle ──────────────────────────────────
    const toggle = document.getElementById('nav-toggle');
    const nav    = document.getElementById('site-nav');

    if (toggle && nav) {
        toggle.addEventListener('click', () => {
            const open = nav.classList.toggle('open');
            toggle.setAttribute('aria-expanded', open);
        });

        // Cierra al hacer click fuera
        document.addEventListener('click', (e) => {
            if (!nav.contains(e.target) && !toggle.contains(e.target)) {
                nav.classList.remove('open');
                toggle.setAttribute('aria-expanded', false);
            }
        });
    }

    // ── Header: sombra al hacer scroll ────────────────────
    const header = document.getElementById('site-header');
    if (header) {
        window.addEventListener('scroll', () => {
            header.style.boxShadow = window.scrollY > 10
                ? '0 1px 20px rgba(0,0,0,0.5)'
                : 'none';
        }, { passive: true });
    }

    // ── Barra de progreso de lectura ───────────────────────
    const progress = document.getElementById('read-progress');
    if (progress) {
        window.addEventListener('scroll', () => {
            const scrollTop  = window.scrollY;
            const docHeight  = document.documentElement.scrollHeight - window.innerHeight;
            const pct        = docHeight > 0 ? (scrollTop / docHeight) * 100 : 0;
            progress.style.width = pct.toFixed(1) + '%';
        }, { passive: true });
    }

    // ── TOC automático ────────────────────────────────────
    const content  = document.getElementById('entry-content');
    const tocNav   = document.getElementById('toc-nav');
    const tocWidget = document.getElementById('toc-widget');

    if (content && tocNav) {
        const headings = content.querySelectorAll('h2, h3');
        if (headings.length >= 2) {
            tocWidget.style.display = '';
            headings.forEach((h, i) => {
                if (!h.id) h.id = 'heading-' + i;
                const a = document.createElement('a');
                a.href = '#' + h.id;
                a.textContent = h.textContent;
                a.className = h.tagName === 'H3' ? 'toc-h3' : '';
                a.addEventListener('click', (e) => {
                    e.preventDefault();
                    h.scrollIntoView({ behavior: 'smooth', block: 'start' });
                });
                tocNav.appendChild(a);
            });

            // Resalta el heading activo al hacer scroll
            const tocLinks = tocNav.querySelectorAll('a');
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        tocLinks.forEach(l => l.classList.remove('toc-active'));
                        const active = tocNav.querySelector('a[href="#' + entry.target.id + '"]');
                        if (active) active.classList.add('toc-active');
                    }
                });
            }, { rootMargin: '-20% 0px -70% 0px' });

            headings.forEach(h => observer.observe(h));
        }
    }

    // ── Copy button en bloques de código ──────────────────
    document.querySelectorAll('.entry-content pre').forEach(pre => {
        const btn = document.createElement('button');
        btn.className = 'copy-btn';
        btn.innerHTML = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="9" y="9" width="13" height="13" rx="2"/><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"/></svg>';
        btn.title = 'Copiar código';
        pre.style.position = 'relative';
        pre.appendChild(btn);

        btn.addEventListener('click', () => {
            const code = pre.querySelector('code') ? pre.querySelector('code').innerText : pre.innerText;
            navigator.clipboard.writeText(code).then(() => {
                btn.innerHTML = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>';
                btn.classList.add('copied');
                setTimeout(() => {
                    btn.innerHTML = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="9" y="9" width="13" height="13" rx="2"/><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"/></svg>';
                    btn.classList.remove('copied');
                }, 2000);
            });
        });
    });

    // ── Responsive single: colapsa sidebar en móvil ────────
    function handleSingleLayout() {
        const wrap = document.querySelector('.single-wrap');
        if (!wrap) return;
        if (window.innerWidth <= 900) {
            wrap.style.gridTemplateColumns = '1fr';
        } else {
            wrap.style.gridTemplateColumns = '1fr 300px';
        }
    }
    handleSingleLayout();
    window.addEventListener('resize', handleSingleLayout, { passive: true });

})();
