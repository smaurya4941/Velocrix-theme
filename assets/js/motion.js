/* Velocrix motion layer for the classic pages (vanilla, no libraries).
   Styles: assets/css/motion.css. Every effect checks "reduce motion" and
   only enhances markup that already works without JS. */
(function () {
  'use strict';
  var d = document;
  var reduce = window.matchMedia && matchMedia('(prefers-reduced-motion: reduce)').matches;
  var finePointer = window.matchMedia && matchMedia('(hover: hover) and (pointer: fine)').matches;
  var inr = function (n) { return Math.round(n).toLocaleString('en-IN'); };

  /* Count a number inside el from "from" to "to" (Indian digit grouping). */
  function countTo(el, from, to, dur) {
    if (reduce) { el.textContent = inr(to); return; }
    var t0 = null;
    if (el._raf) cancelAnimationFrame(el._raf);
    function tick(t) {
      if (t0 === null) t0 = t;
      var p = Math.min(1, (t - t0) / dur), e = 1 - Math.pow(1 - p, 3);
      el.textContent = inr(from + (to - from) * e);
      if (p < 1) el._raf = requestAnimationFrame(tick);
    }
    el._raf = requestAnimationFrame(tick);
  }
  function onView(els, fn, opts) {
    if (!('IntersectionObserver' in window)) { els.forEach(fn); return; }
    var io = new IntersectionObserver(function (items) {
      items.forEach(function (i) { if (i.isIntersecting) { fn(i.target); io.unobserve(i.target); } });
    }, opts || { threshold: 0.15 });
    els.forEach(function (e) { io.observe(e); });
  }

  /* ---------- 1. Page hero: title rises in word by word ---------- */
  (function () {
    var hero = d.querySelector('.hero-page');
    if (!hero || reduce) return;
    var h1 = hero.querySelector('h1');
    if (!h1 || h1.dataset.split) return;
    h1.dataset.split = '1';
    var tmp = d.createElement('div');
    tmp.innerHTML = h1.innerHTML.replace(/<br\s*\/?>/gi, ' ');
    h1.setAttribute('aria-label', tmp.textContent.replace(/\s+/g, ' ').trim());
    var i = 0;
    function wrapWord(content) {
      var w = d.createElement('span'), inner = d.createElement('span');
      w.className = 'mo-w'; w.setAttribute('aria-hidden', 'true');
      inner.style.setProperty('--i', i++);
      if (typeof content === 'string') inner.textContent = content; else inner.appendChild(content);
      w.appendChild(inner);
      return w;
    }
    Array.prototype.slice.call(h1.childNodes).forEach(function (n) {
      if (n.nodeType === 3) {
        var frag = d.createDocumentFragment();
        n.textContent.split(/(\s+)/).forEach(function (part) {
          if (!part) return;
          if (/^\s+$/.test(part)) frag.appendChild(d.createTextNode(' '));
          else frag.appendChild(wrapWord(part));
        });
        h1.replaceChild(frag, n);
      } else if (n.nodeType === 1 && n.tagName !== 'BR' && !n.classList.contains('dot')) {
        h1.replaceChild(wrapWord(n.cloneNode(true)), n);
      } else if (n.nodeType === 1 && n.classList.contains('dot')) {
        n.setAttribute('aria-hidden', 'true');
      }
    });
    h1.style.setProperty('--n', i);
    h1.classList.add('mo-split');
    hero.classList.add('mo-hero');
    requestAnimationFrame(function () { requestAnimationFrame(function () { hero.classList.add('mo-go'); }); });
  })();

  /* ---------- 2. Plan cards ---------- */
  (function () {
    var cards = Array.prototype.slice.call(d.querySelectorAll('.pcard[data-price]'));
    if (!cards.length) return;

    // arrive one after another (per grid); drop the delay once in, so hover stays snappy
    d.querySelectorAll('.pgrid').forEach(function (g) {
      g.querySelectorAll('.pcard').forEach(function (c, k) {
        c.style.setProperty('--d', k);
        c.addEventListener('transitionend', function (e) { if (e.propertyName === 'opacity' && c.classList.contains('in')) c.classList.add('mo-done'); });
      });
    });

    // price counts up the first time a card is seen
    cards.forEach(function (c) { c._num = c.querySelector('.p-num'); c._shown = +c.dataset.price; });
    if (!reduce) {
      onView(cards, function (c) {
        if (!c._num) return;
        var to = c._shown;
        c._num.textContent = '0';
        setTimeout(function () { countTo(c._num, 0, to, 1100); }, 250 + (+c.style.getPropertyValue('--d') || 0) * 110);
      }, { threshold: 0.35 });
    }

    // spotlight + gentle 3D tilt that follows the mouse
    if (finePointer && !reduce) {
      cards.forEach(function (c) {
        c.classList.add('mo-tilt');
        c.addEventListener('pointermove', function (e) {
          var r = c.getBoundingClientRect(), x = (e.clientX - r.left) / r.width, y = (e.clientY - r.top) / r.height;
          c.classList.add('is-moving');
          c.style.setProperty('--mx', (x * 100).toFixed(1) + '%');
          c.style.setProperty('--my', (y * 100).toFixed(1) + '%');
          c.style.setProperty('--ry', ((x - 0.5) * 7).toFixed(2) + 'deg');
          c.style.setProperty('--rx', ((0.5 - y) * 6).toFixed(2) + 'deg');
        });
        c.addEventListener('pointerleave', function () {
          c.classList.remove('is-moving');
          c.style.setProperty('--rx', '0deg'); c.style.setProperty('--ry', '0deg');
        });
      });
    }

    // "Full price / Per month" switch (only when plans know their months)
    var sw = d.querySelector('.p-view');
    var monthly = cards.filter(function (c) { return +c.dataset.months > 0; });
    if (!sw || monthly.length < 2) return;
    sw.hidden = false;
    var btns = Array.prototype.slice.call(sw.querySelectorAll('button')), pill = sw.querySelector('.p-view-pill');
    function place() {
      var on = btns.filter(function (b) { return b.getAttribute('aria-checked') === 'true'; })[0];
      if (!on || !pill) return;
      pill.style.width = on.offsetWidth + 'px';
      pill.style.transform = 'translateX(' + on.offsetLeft + 'px)';
    }
    monthly.forEach(function (c) { var s = c.querySelector('.p-sub'); c._sub = s ? s.textContent : ''; });
    function setView(view) {
      btns.forEach(function (b) { b.setAttribute('aria-checked', b.dataset.view === view ? 'true' : 'false'); });
      place();
      monthly.forEach(function (c) {
        var m = +c.dataset.months, price = +c.dataset.price, to = view === 'month' ? price / m : price;
        if (c._num) { countTo(c._num, c._shown, to, 600); c._shown = to; }
        var unit = c.querySelector('.p-unit'); if (unit) unit.hidden = view !== 'month';
        var sub = c.querySelector('.p-sub');
        if (sub) sub.textContent = view === 'month'
          ? (m === 1 ? 'Billed monthly' : '₹' + inr(price) + ' billed for ' + m + ' months')
          : c._sub;
      });
    }
    btns.forEach(function (b, k) {
      b.addEventListener('click', function () { setView(b.dataset.view); });
      b.addEventListener('keydown', function (e) {
        if (e.key !== 'ArrowLeft' && e.key !== 'ArrowRight') return;
        e.preventDefault();
        var n = btns[(k + (e.key === 'ArrowRight' ? 1 : btns.length - 1)) % btns.length];
        n.focus(); setView(n.dataset.view);
      });
    });
    place();
    window.addEventListener('resize', place);
    if (d.fonts && d.fonts.ready) d.fonts.ready.then(place);
  })();

  /* ---------- 4. Registration: the same form, shown one step at a time ----------
     Server-side form and checks are unchanged (inc/registration.php). Without JS the
     whole form shows at once like before. main.js still handles photo preview,
     consent-gated submit and the final required-field check. */
  (function () {
    var rf = d.querySelector('.reg-form');
    if (!rf) return;
    var blocks = Array.prototype.slice.call(rf.querySelectorAll('fieldset.reg-block')).filter(function (f) { return f.parentNode === rf; });
    if (blocks.length < 2) return;
    var LABELS = ['Personal', 'Address', 'Playing', 'Confirm'];
    var submit = d.getElementById('reg-submit'), cur = 0, n = blocks.length;

    // progress header
    var head = d.createElement('div');
    head.className = 'mo-steps';
    head.innerHTML = '<div class="mo-steps-bar" aria-hidden="true"><i></i></div><ol></ol>';
    var ol = head.querySelector('ol'), bar = head.querySelector('.mo-steps-bar i');
    blocks.forEach(function (b, i) {
      var li = d.createElement('li'), btn = d.createElement('button');
      btn.type = 'button';
      btn.innerHTML = '<span class="mo-sn">' + (i + 1) + '</span><span class="mo-sl">' + (LABELS[i] || 'Step ' + (i + 1)) + '</span>';
      btn.addEventListener('click', function () { tryGo(i); });
      li.appendChild(btn); ol.appendChild(li);
    });
    rf.insertBefore(head, blocks[0]);

    // Back / Next bar, placed just above the submit button
    var nav = d.createElement('div');
    nav.className = 'mo-step-nav';
    nav.innerHTML = '<button type="button" class="btn btn-ghost mo-back">Back</button><span class="mo-step-count" aria-live="polite"></span><button type="button" class="btn mo-next">Next</button>';
    var err = d.createElement('p');
    err.className = 'mo-step-err'; err.setAttribute('role', 'alert'); err.hidden = true;
    rf.insertBefore(err, submit);
    rf.insertBefore(nav, submit);
    var back = nav.querySelector('.mo-back'), next = nav.querySelector('.mo-next'), countEl = nav.querySelector('.mo-step-count');
    rf.classList.add('mo-stepper');

    function fieldOk(el) {
      var v = (el.value || '').trim();
      if (el.type === 'radio') return !!rf.querySelector('[name="' + el.name + '"]:checked');
      if (el.type === 'checkbox') return el.checked;
      if (el.required && !v) return false;
      if (el.type === 'tel' && v) return v.replace(/\D/g, '').length >= 10;
      if (el.type === 'email' && v) return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(v);
      return true;
    }
    function mark(el, ok) {
      if (el.type === 'radio') { var f = el.closest('.fld'); if (f) f.classList.toggle('is-bad', !ok); return; }
      if (el.type === 'checkbox') { var c = el.closest('.consent'); if (c) c.classList.toggle('is-bad', !ok); return; }
      el.classList.toggle('is-bad', !ok);
      el.classList.toggle('is-ok', ok && !!(el.value || '').trim());
    }
    function shake(el) {
      var t = el.closest('.fld,.consent,label') || el;
      if (reduce) return;
      t.classList.remove('mo-shake'); void t.offsetWidth; t.classList.add('mo-shake');
    }
    // check one step; returns the first bad field (or null)
    function check(i, show) {
      var bad = null, seen = {};
      blocks[i].querySelectorAll('input,select,textarea').forEach(function (el) {
        if (el.type === 'hidden' || el.type === 'file' || (!el.required && el.type !== 'tel' && el.type !== 'email')) return;
        if (el.type === 'radio') { if (seen[el.name]) return; seen[el.name] = 1; }
        var ok = fieldOk(el);
        if (show) { mark(el, ok); if (!ok) shake(el); }
        if (!ok && !bad) bad = el;
      });
      return bad;
    }
    function go(i, focus) {
      var dir = i > cur ? 1 : -1;
      cur = Math.max(0, Math.min(n - 1, i));
      blocks.forEach(function (b, k) {
        b.classList.toggle('mo-hide', k !== cur);
        if (k === cur && !reduce) { b.classList.remove('mo-in-l', 'mo-in-r'); void b.offsetWidth; b.classList.add(dir > 0 ? 'mo-in-r' : 'mo-in-l'); }
      });
      ol.querySelectorAll('button').forEach(function (b, k) {
        b.classList.toggle('is-done', k < cur);
        if (k === cur) b.setAttribute('aria-current', 'step'); else b.removeAttribute('aria-current');
      });
      bar.style.width = (n > 1 ? (cur / (n - 1)) * 100 : 100) + '%';
      back.hidden = cur === 0;
      next.textContent = cur < n - 1 ? 'Next: ' + (LABELS[cur + 1] || 'Step ' + (cur + 2)) : '';
      rf.classList.toggle('mo-last', cur === n - 1);
      countEl.textContent = 'Step ' + (cur + 1) + ' of ' + n;
      err.hidden = true;
      var top = head.getBoundingClientRect().top;
      if (top < 0 || top > innerHeight * 0.6) scrollTo({ top: scrollY + top - 120, behavior: reduce ? 'auto' : 'smooth' });
      if (focus) { var f = blocks[cur].querySelector('input:not([type=hidden]):not([type=file]),select,textarea'); if (f) f.focus({ preventScroll: true }); }
    }
    function fail(bad) {
      err.textContent = 'Please fill in the highlighted fields to continue.';
      err.hidden = false;
      if (bad && bad.focus && bad.type !== 'radio') bad.focus({ preventScroll: true });
    }
    function tryGo(i) {
      if (i <= cur) return go(i, true);
      for (var k = cur; k < i; k++) { var bad = check(k, true); if (bad) { if (k !== cur) go(k); fail(bad); return; } }
      go(i, true);
    }
    next.addEventListener('click', function () { tryGo(cur + 1); });
    back.addEventListener('click', function () { go(cur - 1, true); });

    // Enter moves to the next step instead of submitting early
    rf.addEventListener('keydown', function (e) {
      if (e.key !== 'Enter' || cur === n - 1) return;
      var t = e.target;
      if (t.tagName === 'TEXTAREA' || t.tagName === 'BUTTON') return;
      e.preventDefault(); tryGo(cur + 1);
    });
    // live feedback once a field is left / changed
    rf.addEventListener('focusout', function (e) {
      var el = e.target;
      if (!el.matches || !el.matches('input[type=text],input[type=tel],input[type=email],input[type=date],select,textarea')) return;
      if ((el.value || '').trim() || el.classList.contains('is-bad')) mark(el, fieldOk(el));
    });
    rf.addEventListener('change', function (e) {
      var el = e.target;
      if (el.type === 'radio' || el.type === 'checkbox') { mark(el, fieldOk(el)); }
      else if (el.tagName === 'SELECT') mark(el, fieldOk(el));
      if (!err.hidden && !check(cur, false)) err.hidden = true;
    });

    // final submit: main.js runs first; if it blocked, jump to the step with the problem
    rf.addEventListener('submit', function (e) {
      if (!e.defaultPrevented) {
        for (var k = 0; k < n; k++) { var bad = check(k, true); if (bad) { e.preventDefault(); go(k); fail(bad); return; } }
        submit.classList.add('is-loading');
        submit.textContent = 'Submitting…';
        setTimeout(function () { submit.disabled = true; }, 0);
        return;
      }
      for (var j = 0; j < n; j++) { if (check(j, true)) { go(j); fail(check(j, false)); return; } }
    });

    // start: first step, or (after a server-side error) the first step that needs attention
    var start = 0;
    if (rf.parentNode.querySelector('.notice.err')) { for (var s = 0; s < n; s++) { if (check(s, false)) { start = s; break; } start = n - 1; } }
    cur = start;
    go(start, false);
  })();

  /* ---------- 5. Registration received: a small celebration ---------- */
  (function () {
    var ico = d.querySelector('.reg-done .done-ico');
    if (!ico || reduce) return;
    ico.classList.add('mo-pop');
    var burst = d.createElement('span');
    burst.className = 'mo-burst'; burst.setAttribute('aria-hidden', 'true');
    for (var i = 0; i < 18; i++) {
      var s = d.createElement('i');
      s.style.setProperty('--a', (i * 20 + Math.random() * 12) + 'deg');
      s.style.setProperty('--r', (70 + Math.random() * 60) + 'px');
      s.style.setProperty('--t', (i % 3) * 60 + 'ms');
      burst.appendChild(s);
    }
    ico.appendChild(burst);
  })();

  /* ---------- 6. Scroll-linked pieces (Mentor page and any page that has them) ---------- */
  var scrollJobs = [];
  function onScrollJob(fn) {
    scrollJobs.push(fn);
    if (scrollJobs.length > 1) return;
    var ticking = false;
    function run() { ticking = false; scrollJobs.forEach(function (f) { f(); }); }
    window.addEventListener('scroll', function () { if (!ticking) { ticking = true; requestAnimationFrame(run); } }, { passive: true });
    window.addEventListener('resize', function () { requestAnimationFrame(run); });
  }

  // 6a. "Her Road": on wide screens the section pins and the timeline slides sideways as you scroll
  (function () {
    var sec = d.querySelector('.vx-road'), road = sec && sec.querySelector('.road');
    if (!road || reduce) return;
    var wrap = road.parentNode, items = Array.prototype.slice.call(road.children), dist = 0;
    var mq = window.matchMedia('(min-width: 900px) and (min-height: 600px)');
    function inner() { var cs = getComputedStyle(wrap); return wrap.clientWidth - parseFloat(cs.paddingLeft) - parseFloat(cs.paddingRight); }
    function measure() {
      if (!mq.matches) {
        sec.classList.remove('mo-pin'); sec.style.height = ''; road.style.transform = '';
        items.forEach(function (li) { li.classList.add('lit'); });
        return;
      }
      sec.classList.add('mo-pin');
      road.style.transform = '';
      dist = Math.max(0, road.getBoundingClientRect().width - inner());
      sec.style.height = Math.round(innerHeight + dist * 1.1) + 'px';
      update();
    }
    function update() {
      if (!sec.classList.contains('mo-pin')) return;
      var r = sec.getBoundingClientRect(), total = sec.offsetHeight - innerHeight;
      var p = total > 0 ? Math.min(1, Math.max(0, -r.top / total)) : 0;
      road.style.transform = 'translateX(' + (-p * dist).toFixed(1) + 'px)';
      // the "lit" line moves from 30% to the right edge of the row as you scroll, so the last stop lights at the end
      var box = wrap.getBoundingClientRect(), mark = box.left + parseFloat(getComputedStyle(wrap).paddingLeft) + inner() * (0.3 + 0.7 * p) + (p > 0.98 ? 40 : 0);
      var rr = road.getBoundingClientRect();
      road.style.setProperty('--fill', Math.min(100, Math.max(0, (mark - rr.left) / rr.width * 100)).toFixed(2) + '%');
      items.forEach(function (li) { li.classList.toggle('lit', li.getBoundingClientRect().left < mark); });
    }
    measure();
    window.addEventListener('resize', measure);
    if (mq.addEventListener) mq.addEventListener('change', measure);
    onScrollJob(update);
  })();

  // 6b. Quote lights up word by word as it scrolls through the screen
  (function () {
    var qs = Array.prototype.slice.call(d.querySelectorAll('.qs-quote, .about-intro .big-text'));
    if (!qs.length || reduce) return;
    qs.forEach(function (q) {
      var words = q.textContent.trim().split(/\s+/);
      // words stay readable to screen readers as plain text (no aria-label on <p>, which is not allowed)
      q.innerHTML = words.map(function (w) { return '<span class="mo-qw">' + w.replace(/&/g, '&amp;').replace(/</g, '&lt;') + '</span>'; }).join(' ');
      q.classList.add('mo-scrub'); if (q.classList.contains('big-text')) q.classList.add('mo-scrub-light');
      q._w = Array.prototype.slice.call(q.querySelectorAll('.mo-qw'));
    });
    function update() {
      var vh = innerHeight;
      qs.forEach(function (q) {
        var r = q.getBoundingClientRect();
        if (r.bottom < -50 || r.top > vh + 50) return;
        var p = Math.min(1, Math.max(0, (vh * 0.85 - r.top) / (r.height + vh * 0.4)));
        var lit = Math.round(p * q._w.length);
        q._w.forEach(function (w, i) { w.classList.toggle('on', i < lit); });
      });
    }
    update(); onScrollJob(update);
  })();

  // 6c. Simple "rise in" for lists that main.js does not reveal
  (function () {
    var groups = ['.msg-lines > p', '.hl-list > li', '.profile-facts > li', '.road > li', '.svc-grid > .svc-card', '.camp-cards > .camp-card', '.svc-facts > div', '.pills > span',
      /* About */ '.ai-head > *', '.ai-body > p:not(.big-text)', '.vm-left > .vm-title', '.profile-body > *', '.partners .container > *', '.imp-body .eyebrow, .imp-body h2', '.imp-line', '.faq-grid .acc-item', '.faq-more'];
    var els = [];
    groups.forEach(function (sel) {
      d.querySelectorAll(sel).forEach(function (el, k) {
        if (el.closest('.mo-pin')) return; // pinned timeline animates on its own
        el.classList.add('mo-rise'); el.style.setProperty('--d', k % 8); els.push(el);
      });
    });
    if (!els.length || reduce) { els.forEach(function (e) { e.classList.add('in'); }); return; }
    onView(els, function (e) { e.classList.add('in'); }, { threshold: 0.2, rootMargin: '0px 0px -8% 0px' });
  })();

  // 6d. Career figures like "4/37" count up
  (function () {
    var bs = Array.prototype.slice.call(d.querySelectorAll('.hl-card b'));
    if (!bs.length || reduce) return;
    bs.forEach(function (b) { b._orig = b.textContent; });
    onView(bs, function (b) {
      var m = b._orig.match(/^(\d+)\/(\d+)$/);
      if (!m) return;
      var a = +m[1], c = +m[2], t0 = null;
      (function tick(t) {
        if (t0 === null) t0 = t;
        var p = Math.min(1, (t - t0) / 1200), e = 1 - Math.pow(1 - p, 3);
        b.textContent = Math.round(a * e) + '/' + Math.round(c * e);
        if (p < 1) requestAnimationFrame(tick); else b.textContent = b._orig;
      })(performance.now());
    }, { threshold: 0.5 });
  })();

  /* ---------- 7. Services (and other) pages ---------- */
  // 7a. photos drift a little slower than the page (parallax inside their rounded frame)
  (function () {
    var imgs = Array.prototype.slice.call(d.querySelectorAll('.svc-photo > img, .prog-img img, .vm-card.photo > img, .imp-photo > img, .founder-tease .profile-photo:not(.is-poster) > img')); // poster photos keep their edges (text is printed on them)
    if (!imgs.length || reduce) return;
    imgs.forEach(function (im) { im.classList.add('mo-par'); });
    function update() {
      var vh = innerHeight;
      imgs.forEach(function (im) {
        var r = im.parentNode.getBoundingClientRect();
        if (r.bottom < 0 || r.top > vh) return;
        var p = (r.top + r.height / 2 - vh / 2) / (vh / 2 + r.height / 2); // -1 .. 1
        im.style.translate = '0 ' + (p * -28).toFixed(1) + 'px';
      });
    }
    update(); onScrollJob(update);
  })();

  // 7b. soft spotlight that follows the mouse on content cards
  (function () {
    if (!finePointer || reduce) return;
    d.querySelectorAll('.svc-card, .camp-card, .hl-card, .svc-flow > li, .highlights .hl-list > li, .vm-card, .cc-name').forEach(function (c) {
      c.classList.add('mo-spot');
      c.addEventListener('pointermove', function (e) {
        var r = c.getBoundingClientRect();
        c.style.setProperty('--mx', (e.clientX - r.left) + 'px');
        c.style.setProperty('--my', (e.clientY - r.top) + 'px');
      });
    });
  })();

  // 7c. "How it works": steps light up one by one and the connectors draw as you scroll
  (function () {
    var flows = Array.prototype.slice.call(d.querySelectorAll('.svc-flow'));
    if (!flows.length) return;
    if (reduce) { flows.forEach(function (f) { f.querySelectorAll('li').forEach(function (li) { li.classList.add('lit'); }); }); return; }
    flows.forEach(function (f) { f.classList.add('mo-flow'); f._li = Array.prototype.slice.call(f.children); });
    function update() {
      var vh = innerHeight;
      flows.forEach(function (f) {
        var r = f.getBoundingClientRect();
        if (r.bottom < -100 || r.top > vh + 100) return;
        var p = Math.min(1, Math.max(0, (vh * 0.85 - r.top) / (r.height * 0.7 + vh * 0.3)));
        var lit = Math.ceil(p * f._li.length - 0.001);
        f._li.forEach(function (li, i) { li.classList.toggle('lit', i < lit); });
      });
    }
    update(); onScrollJob(update);
  })();

  /* ---------- 8. Plan finder (Packages page) ---------- */
  (function () {
    var pf = d.querySelector('.pf');
    if (!pf) return;
    var plans = [];
    try { plans = JSON.parse(pf.getAttribute('data-plans') || '[]'); } catch (e) {}
    if (plans.length < 2) return;
    var qs = Array.prototype.slice.call(pf.querySelectorAll('.pf-q')), res = pf.querySelector('.pf-result');
    var bar = pf.querySelector('.pf-progress i'), answers = [], step = 0;
    function show(el, dir) {
      el.hidden = false;
      if (reduce) return;
      el.classList.remove('mo-in-r', 'mo-in-l'); void el.offsetWidth; el.classList.add(dir < 0 ? 'mo-in-l' : 'mo-in-r');
    }
    function progress() { bar.style.width = (answers.length / qs.length * 100) + '%'; }
    function result() {
      // the commitment question counts double; answers 0..3 map onto the plans from shortest to longest
      var w = [1, 1, 2], sum = 0, tw = 0;
      answers.forEach(function (a, i) { sum += a * (w[i] || 1); tw += (w[i] || 1); });
      var idx = Math.round((sum / tw) * (plans.length - 1) / 3);
      var p = plans[Math.max(0, Math.min(plans.length - 1, idx))];
      res.querySelector('.pf-name').textContent = p.name;
      res.querySelector('.pf-price').innerHTML = '₹<b>' + p.price + '</b>' + (p.sub ? '<small>' + p.sub.replace(/</g, '&lt;') + '</small>' : '');
      res.querySelector('.pf-desc').textContent = p.desc;
      res.querySelector('.pf-go').href = p.url;
      qs.forEach(function (q) { q.hidden = true; });
      show(res, 1);
      var b = res.querySelector('.pf-price b'), to = +String(p.price).replace(/\D/g, '');
      if (b && to) countTo(b, 0, to, 900);
      res.querySelector('.pf-name').setAttribute('tabindex', '-1');
      res.querySelector('.pf-name').focus({ preventScroll: true });
    }
    qs.forEach(function (q, qi) {
      q.querySelectorAll('.pf-opt').forEach(function (o) {
        o.addEventListener('click', function () {
          q.querySelectorAll('.pf-opt').forEach(function (x) { x.classList.toggle('is-on', x === o); x.setAttribute('aria-pressed', x === o ? 'true' : 'false'); });
          answers[qi] = +o.dataset.v; answers.length = qi + 1;
          progress();
          setTimeout(function () {
            q.hidden = true;
            if (qi + 1 < qs.length) { step = qi + 1; show(qs[step], 1); var f = qs[step].querySelector('.pf-opt'); if (f) f.focus({ preventScroll: true }); }
            else result();
          }, reduce ? 0 : 260);
        });
      });
    });
    res.querySelector('.pf-again').addEventListener('click', function () {
      answers = []; step = 0; progress(); res.hidden = true;
      qs.forEach(function (q) { q.hidden = true; q.querySelectorAll('.pf-opt').forEach(function (x) { x.classList.remove('is-on'); x.removeAttribute('aria-pressed'); }); });
      show(qs[0], -1); qs[0].querySelector('.pf-opt').focus({ preventScroll: true });
    });
  })();

  /* ---------- 3. Gallery: staggered wipe-in + full lightbox ---------- */
  (function () {
    var items = Array.prototype.slice.call(d.querySelectorAll('.g-item'));
    if (!items.length) return;

    if (!reduce) {
      items.forEach(function (a, k) { a.classList.add('mo-g'); a.style.setProperty('--d', k % 3); });
      onView(items, function (a) { a.classList.add('in'); }, { threshold: 0.12, rootMargin: '0px 0px -40px 0px' });
    }

    var photos = items.map(function (a) {
      var im = a.querySelector('img');
      return { src: a.href, alt: im ? im.alt : '' };
    });
    var ICON = {
      x: '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M6 6l12 12M18 6L6 18"/></svg>',
      l: '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M15 5l-7 7 7 7"/></svg>',
      r: '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M9 5l7 7-7 7"/></svg>'
    };
    var lb, img, cap, count, cur = 0, opener = null;

    function build() {
      lb = d.createElement('div');
      lb.className = 'mo-lb';
      lb.setAttribute('role', 'dialog');
      lb.setAttribute('aria-modal', 'true');
      lb.setAttribute('aria-label', 'Photo viewer');
      lb.innerHTML =
        '<div class="mo-lb-top"><span class="mo-lb-count" aria-live="polite"></span>' +
        '<button type="button" class="mo-lb-close" aria-label="Close">' + ICON.x + '</button></div>' +
        '<div class="mo-lb-stage"><img class="mo-lb-img" alt="">' +
        '<button type="button" class="mo-lb-nav mo-lb-prev" aria-label="Previous photo">' + ICON.l + '</button>' +
        '<button type="button" class="mo-lb-nav mo-lb-next" aria-label="Next photo">' + ICON.r + '</button></div>' +
        '<p class="mo-lb-cap"></p>';
      img = lb.querySelector('.mo-lb-img'); cap = lb.querySelector('.mo-lb-cap'); count = lb.querySelector('.mo-lb-count');
      lb.querySelector('.mo-lb-close').addEventListener('click', close);
      lb.querySelector('.mo-lb-prev').addEventListener('click', function () { go(-1); });
      lb.querySelector('.mo-lb-next').addEventListener('click', function () { go(1); });
      // click on the dark area (not the photo or a button) closes
      lb.addEventListener('click', function (e) { if (e.target === lb || e.target.classList.contains('mo-lb-stage') || e.target.classList.contains('mo-lb-top')) close(); });
      // swipe left / right
      var sx = null, sy = null;
      lb.addEventListener('pointerdown', function (e) { if (e.pointerType !== 'mouse') { sx = e.clientX; sy = e.clientY; } });
      lb.addEventListener('pointerup', function (e) {
        if (sx === null) return;
        var dx = e.clientX - sx, dy = e.clientY - sy; sx = null;
        if (Math.abs(dx) > 50 && Math.abs(dx) > Math.abs(dy)) go(dx < 0 ? 1 : -1);
        else if (dy > 90 && Math.abs(dy) > Math.abs(dx)) close();
      });
      if (photos.length < 2) lb.querySelectorAll('.mo-lb-nav').forEach(function (b) { b.hidden = true; });
    }
    function show(i, dir) {
      cur = (i + photos.length) % photos.length;
      var p = photos[cur];
      img.className = 'mo-lb-img ' + (reduce ? '' : (dir > 0 ? 'from-r' : dir < 0 ? 'from-l' : 'is-enter'));
      img.onload = function () { requestAnimationFrame(function () { img.className = 'mo-lb-img'; }); };
      img.src = p.src; img.alt = p.alt;
      if (img.complete) img.onload();
      cap.textContent = p.alt;
      count.innerHTML = '<b>' + String(cur + 1).padStart(2, '0') + '</b> / ' + String(photos.length).padStart(2, '0');
      [cur + 1, cur - 1].forEach(function (k) { var n = photos[(k + photos.length) % photos.length]; if (n) (new Image()).src = n.src; });
    }
    function go(step) { show(cur + step, step); }
    function key(e) {
      if (e.key === 'Escape') close();
      else if (e.key === 'ArrowRight') go(1);
      else if (e.key === 'ArrowLeft') go(-1);
      else if (e.key === 'Tab') { // keep focus inside the viewer
        var f = Array.prototype.slice.call(lb.querySelectorAll('button:not([hidden])'));
        var at = f.indexOf(d.activeElement);
        e.preventDefault();
        f[(at + (e.shiftKey ? f.length - 1 : 1)) % f.length].focus();
      }
    }
    function open(i, from) {
      if (!lb) build();
      opener = from;
      d.body.appendChild(lb);
      d.documentElement.classList.add('mo-lock');
      show(i, 0);
      requestAnimationFrame(function () { lb.classList.add('is-open'); });
      d.addEventListener('keydown', key);
      lb.querySelector('.mo-lb-close').focus();
    }
    function close() {
      if (!lb || !lb.parentNode) return;
      lb.classList.remove('is-open');
      d.removeEventListener('keydown', key);
      d.documentElement.classList.remove('mo-lock');
      setTimeout(function () { if (lb.parentNode) lb.parentNode.removeChild(lb); }, reduce ? 0 : 300);
      if (opener) opener.focus();
    }
    items.forEach(function (a, k) {
      a.setAttribute('aria-label', 'View photo ' + (k + 1) + ' of ' + items.length);
      a.addEventListener('click', function (e) { e.preventDefault(); open(k, a); });
    });
  })();
})();
