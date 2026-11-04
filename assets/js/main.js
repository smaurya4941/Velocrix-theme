/* Velocrix theme: small vanilla JS (no libraries) */
(function () {
  'use strict';
  document.documentElement.classList.add('js');

  // Mobile menu
  var t = document.querySelector('.nav-toggle'), n = document.getElementById('nav');
  if (t && n) {
    t.addEventListener('click', function () {
      var o = n.classList.toggle('open');
      t.setAttribute('aria-expanded', o ? 'true' : 'false');
    });
  }

  // Reveal on scroll
  var els = document.querySelectorAll('.card,.photo-card,.plan,.step,.sec-head,.stats>div,.coach');
  els.forEach(function (e) { e.classList.add('reveal'); });
  if ('IntersectionObserver' in window) {
    var io = new IntersectionObserver(function (items) {
      items.forEach(function (i) { if (i.isIntersecting) { i.target.classList.add('in'); io.unobserve(i.target); } });
    }, { threshold: 0.12 });
    els.forEach(function (e) { io.observe(e); });
  } else { els.forEach(function (e) { e.classList.add('in'); }); }

  // Count-up numbers
  var cs = document.querySelectorAll('[data-count]');
  if ('IntersectionObserver' in window && cs.length) {
    var co = new IntersectionObserver(function (items) {
      items.forEach(function (i) {
        if (!i.isIntersecting) return;
        var el = i.target, end = parseInt(el.dataset.count, 10), cur = 0, step = Math.max(1, Math.ceil(end / 30));
        var id = setInterval(function () { cur += step; if (cur >= end) { cur = end; clearInterval(id); } el.textContent = cur; }, 40);
        co.unobserve(el);
      });
    }, { threshold: 0.6 });
    cs.forEach(function (c) { c.textContent = '0'; co.observe(c); });
  }
})();
