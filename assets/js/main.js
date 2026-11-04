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

  // Header turns solid after scrolling
  var h = d.querySelector('.site-header');
  function onScroll() { if (h) h.classList.toggle('scrolled', window.scrollY > 60); }
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
        var el = i.target, end = parseInt(el.dataset.count, 10), cur = 0, step = Math.max(1, Math.ceil(end / 25));
        var id = setInterval(function () { cur += step; if (cur >= end) { cur = end; clearInterval(id); } el.textContent = cur; }, 45);
        co.unobserve(el);
      });
    }, { threshold: 0.6 });
    cs.forEach(function (c) { co.observe(c); });
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
