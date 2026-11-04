/* Velocrix theme: small vanilla JS (no libraries) */
(function () {
  'use strict';
  var d = document;
  d.documentElement.classList.add('js');

  // Mobile menu
  var t = d.querySelector('.nav-toggle'), n = d.getElementById('nav');
  if (t && n) {
    t.addEventListener('click', function () {
      var o = n.classList.toggle('open');
      t.setAttribute('aria-expanded', o ? 'true' : 'false');
    });
  }

  // Dropdown parents ("#") should not jump to top; click keeps the menu open via focus
  d.querySelectorAll('.nav-list .menu-item-has-children > a[href="#"]').forEach(function (a) {
    a.addEventListener('click', function (e) { e.preventDefault(); });
  });

  // Header turns solid after scrolling
  var h = d.querySelector('.site-header');
  var lastY = window.scrollY;
  function onScroll() {
    if (!h) return;
    var y = window.scrollY;
    h.classList.toggle('scrolled', y > 60);
    // Hide header when scrolling down, show it when scrolling up (always shown near top / while menu is open)
    var menuOpen = n && n.classList.contains('open');
    if (y < 120 || menuOpen || y < lastY - 4) h.classList.remove('nav-hidden');
    else if (y > lastY + 4) h.classList.add('nav-hidden');
    lastY = y;
  }
  onScroll();
  window.addEventListener('scroll', onScroll, { passive: true });

  // Pricing tabs
  d.querySelectorAll(".p-tabs").forEach(function (tabs) {
    var btns = tabs.querySelectorAll(".p-tab"), panels = d.querySelectorAll(".p-panel");
    function show(i) {
      btns.forEach(function (b, k) { b.classList.toggle("is-active", k === i); b.setAttribute("aria-selected", k === i ? "true" : "false"); });
      panels.forEach(function (p, k) { p.classList.toggle("is-active", k === i); if (k === i) p.querySelectorAll(".reveal").forEach(function (r) { r.classList.add("in"); }); });
    }
    btns.forEach(function (b, i) { b.addEventListener("click", function () { show(i); }); });
    show(0);
  });

  // Accordion (one open at a time)
  d.querySelectorAll('.acc').forEach(function (acc) {
    acc.addEventListener('click', function (e) {
      var btn = e.target.closest('.acc-head');
      if (!btn) return;
      var item = btn.parentElement, wasOpen = item.classList.contains('is-open');
      acc.querySelectorAll('.acc-item').forEach(function (i) {
        i.classList.remove('is-open');
        i.querySelector('.acc-head').setAttribute('aria-expanded', 'false');
      });
      if (!wasOpen) { item.classList.add('is-open'); btn.setAttribute('aria-expanded', 'true'); }
    });
  });

  // Reveal on scroll
  var els = d.querySelectorAll('.stat-card,.about-media,.prog-col,.fac,.steps li,.blog-feat,.blog-item,.sec-head,.card,.plan,.photo-card,.coach,.vm-card,.imp-photo,.imp-stats>div,.cc,.talk-card,.connect-card,.pcard,.post-row,.recent,.profile-photo');
  els.forEach(function (e) { e.classList.add('reveal'); });
  if ('IntersectionObserver' in window) {
    var io = new IntersectionObserver(function (items) {
      items.forEach(function (i) { if (i.isIntersecting) { i.target.classList.add('in'); io.unobserve(i.target); } });
    }, { threshold: 0.1 });
    els.forEach(function (e) { io.observe(e); });
  } else { els.forEach(function (e) { e.classList.add('in'); }); }

  // Count-up numbers
  var cs = d.querySelectorAll('[data-count]');
  if ('IntersectionObserver' in window && cs.length) {
    var co = new IntersectionObserver(function (items) {
      items.forEach(function (i) {
        if (!i.isIntersecting) return;
        var el = i.target, end = parseInt(el.dataset.count, 10), t0 = null, dur = 1600;
        function tick(t) {
          if (t0 === null) t0 = t;
          var p = Math.min(1, (t - t0) / dur), e = 1 - Math.pow(1 - p, 3);
          el.textContent = Math.max(1, Math.round(end * e));
          if (p < 1) requestAnimationFrame(tick); else el.textContent = end;
        }
        el.textContent = '1';
        requestAnimationFrame(tick);
        co.unobserve(el);
      });
    }, { threshold: 0.3 });
    cs.forEach(function (c) { c.textContent = '1'; co.observe(c); });
  }

  // Registration form: photo preview, live validation, submit only after both consents
  var rf = d.querySelector('.reg-form');
  if (rf) {
    var btn = d.getElementById('reg-submit'),
        agree = rf.querySelector('[name=agree]'), decl = rf.querySelector('[name=declare]'),
        photo = rf.querySelector('#photo'), drop = rf.querySelector('.photo-drop'), prev = rf.querySelector('.pd-prev');

    function consentOk() { return agree.checked && decl.checked; }
    function syncBtn() { btn.disabled = !consentOk(); }
    agree.addEventListener('change', syncBtn);
    decl.addEventListener('change', syncBtn);
    syncBtn();

    if (photo) {
      photo.addEventListener('change', function () {
        var f = photo.files && photo.files[0];
        if (!f) { drop.classList.remove('has-img'); prev.hidden = true; return; }
        if (!/^image\/(jpeg|png)$/.test(f.type) || f.size > 2 * 1024 * 1024) {
          alert('Please choose a JPG or PNG photo up to 2 MB.');
          photo.value = ''; drop.classList.remove('has-img'); prev.hidden = true; return;
        }
        var r = new FileReader();
        r.onload = function (e) { prev.src = e.target.result; prev.hidden = false; drop.classList.add('has-img'); };
        r.readAsDataURL(f);
      });
    }

    rf.addEventListener('submit', function (e) {
      var bad = null;
      rf.querySelectorAll('[required]').forEach(function (el) {
        var ok = true;
        if (el.type === 'radio') { ok = !!rf.querySelector('[name="' + el.name + '"]:checked'); }
        else if (el.type === 'checkbox') { ok = el.checked; }
        else { ok = el.value.trim() !== ''; }
        if (el.type === 'tel' && ok) ok = el.value.replace(/\D/g, '').length >= 10;
        el.classList.toggle('is-bad', !ok && el.type !== 'radio' && el.type !== 'checkbox');
        if (!ok && !bad) bad = el;
      });
      if (bad) { e.preventDefault(); bad.scrollIntoView({ behavior: 'smooth', block: 'center' }); if (bad.focus) bad.focus({ preventScroll: true }); }
    });
    rf.addEventListener('input', function (e) { e.target.classList.remove('is-bad'); });
  }
})();

/* Gallery lightbox */
(function () {
  var items = document.querySelectorAll('.g-item');
  if (!items.length) return;
  items.forEach(function (a) {
    a.addEventListener('click', function (e) {
      e.preventDefault();
      var o = document.createElement('div');
      o.className = 'vx-lb';
      o.innerHTML = '<img alt=""><button type="button" aria-label="Close">&times;</button>';
      o.firstChild.src = a.href;
      function close() { o.remove(); document.removeEventListener('keydown', k); }
      function k(ev) { if (ev.key === 'Escape') close(); }
      o.addEventListener('click', close);
      document.addEventListener('keydown', k);
      document.body.appendChild(o);
    });
  });
})();

/* Keep the header visible for keyboard users */
(function () {
  var h = document.querySelector('.site-header');
  if (h) h.addEventListener('focusin', function (e) { if (e.target.closest && e.target.closest('.nav-list, .brand, .nav-cta')) h.classList.remove('nav-hidden'); });
})();

/* Rules & terms dialog (registration) */
(function () {
  var dlg = document.getElementById('terms-dialog');
  if (!dlg) return;
  var last = null;
  document.querySelectorAll('[data-terms-open]').forEach(function (b) {
    b.addEventListener('click', function (e) {
      e.preventDefault(); last = b;
      if (typeof dlg.showModal === 'function') dlg.showModal(); else dlg.setAttribute('open', '');
      document.documentElement.classList.add('modal-open');
    });
  });
  function close() { if (dlg.close) dlg.close(); else dlg.removeAttribute('open'); }
  dlg.querySelectorAll('[data-terms-close]').forEach(function (b) { b.addEventListener('click', close); });
  dlg.addEventListener('click', function (e) { if (e.target === dlg) close(); });
  dlg.addEventListener('close', function () { document.documentElement.classList.remove('modal-open'); if (last) last.focus(); });
})();
