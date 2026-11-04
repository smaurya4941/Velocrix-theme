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
  var els = d.querySelectorAll('.stat-card,.about-media,.prog-col,.fac,.steps li,.blog-feat,.blog-item,.sec-head,.card,.plan,.photo-card,.coach,.vm-card,.imp-photo,.imp-stats>div,.cc,.talk-card,.connect-card,.pcard');
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
})();
