/* Classic Home: behaviour for the sections ported from the animated design (template-parts/home/*.php).
   Card fan, rolling ball on the pitch, photo tilt, magnetic buttons, reveal, and line-art backgrounds
   (same drawings as assets/landing/js/lineart-parallax.js, in Velocrix lime; used on Home and About). Vanilla, respects reduced motion. */
(function () {
  'use strict';
  var d = document, $$ = function (s, r) { return Array.prototype.slice.call((r || d).querySelectorAll(s)); };
  var reduce = window.matchMedia && matchMedia('(prefers-reduced-motion: reduce)').matches;
  var fine = window.matchMedia && matchMedia('(hover: hover) and (pointer: fine)').matches;
  var hasIO = 'IntersectionObserver' in window;

  /* ---------- reveal ---------- */
  var rv = $$('.hx-rv');
  if (hasIO && !reduce) {
    var rio = new IntersectionObserver(function (es) { es.forEach(function (e) { if (e.isIntersecting) { e.target.classList.add('in'); rio.unobserve(e.target); } }); }, { threshold: 0.12 });
    rv.forEach(function (e) { rio.observe(e); });
  } else rv.forEach(function (e) { e.classList.add('in'); });

  /* ---------- line art ---------- */
  var STROKE = '#7A9E00';
  var f = function (n) { return n.toFixed(1); };
  function ground(op) {
    var C = 500, s = '<g fill="none" stroke="' + STROKE + '" stroke-width="1" opacity="' + op + '">', a, r, l;
    s += '<ellipse cx="500" cy="500" rx="470" ry="440"/><ellipse cx="500" cy="500" rx="455" ry="425" stroke-width=".6"/>';
    s += '<ellipse cx="500" cy="500" rx="250" ry="235" stroke-dasharray="2 9" stroke-width="1.6" stroke-linecap="round"/><ellipse cx="500" cy="500" rx="120" ry="112" stroke-width=".6"/>';
    for (a = 0; a < 360; a += 3) { r = a * Math.PI / 180; l = a % 15 === 0 ? 22 : 9; s += '<line x1="' + f(C + Math.cos(r) * 478) + '" y1="' + f(C + Math.sin(r) * 448) + '" x2="' + f(C + Math.cos(r) * (478 + l)) + '" y2="' + f(C + Math.sin(r) * (448 + l)) + '" stroke-width="' + (a % 15 === 0 ? 1 : 0.6) + '"/>'; }
    s += '<rect x="486" y="430" width="28" height="140" stroke-width="1.2"/><path d="M478 444H522M478 556H522M482 436H518M482 564H518"/>';
    for (a = 0; a < 360; a += 45) { r = a * Math.PI / 180; s += '<line x1="' + f(C + Math.cos(r) * 130) + '" y1="' + f(C + Math.sin(r) * 121) + '" x2="' + f(C + Math.cos(r) * 445) + '" y2="' + f(C + Math.sin(r) * 416) + '" stroke-dasharray="1 7" stroke-width=".8"/>'; }
    s += '</g><g fill="' + STROKE + '" opacity="' + (op * 1.2) + '">';
    [[-40, 180], [30, 300], [78, 370], [125, 330], [160, 210], [205, 380], [250, 300], [300, 390], [330, 200]].forEach(function (p) { var q = p[0] * Math.PI / 180; s += '<circle cx="' + f(C + Math.cos(q) * p[1]) + '" cy="' + f(C + Math.sin(q) * p[1] * 0.94) + '" r="5"/>'; });
    return '<svg viewBox="0 0 1000 1000">' + s + '</g></svg>';
  }
  function seams(op) {
    var s = '<g fill="none" stroke="' + STROKE + '" opacity="' + op + '">';
    var arc = function (y0, b) { return 'M-40 ' + y0 + ' C 400 ' + (y0 + b) + ', 1000 ' + (y0 + b) + ', 1640 ' + y0; };
    var pt = function (y0, b, t) { var m = 1 - t, P = [[-40, y0], [400, y0 + b], [1000, y0 + b], [1640, y0]]; return [m * m * m * P[0][0] + 3 * m * m * t * P[1][0] + 3 * m * t * t * P[2][0] + t * t * t * P[3][0], m * m * m * P[0][1] + 3 * m * m * t * P[1][1] + 3 * m * t * t * P[2][1] + t * t * t * P[3][1]]; };
    s += '<path d="' + arc(200, 260) + '" stroke-width="1.1"/><path d="' + arc(236, 260) + '" stroke-width="1.1"/>';
    for (var i = 0; i <= 120; i++) {
      var t = i / 120;
      [[200, 260, -1], [236, 260, 1]].forEach(function (a) { var p = pt(a[0], a[1], t), q = pt(a[0], a[1], Math.min(1, t + 0.004)), g = Math.atan2(q[1] - p[1], q[0] - p[0]) + a[2] * 0.9; s += '<line x1="' + f(p[0]) + '" y1="' + f(p[1]) + '" x2="' + f(p[0] + Math.cos(g) * 12) + '" y2="' + f(p[1] + Math.sin(g) * 12) + '" stroke-width="1.4" stroke-linecap="round"/>'; });
    }
    s += '<path d="' + arc(150, 260) + '" stroke-width=".5" stroke-dasharray="1 6"/><path d="' + arc(290, 260) + '" stroke-width=".5" stroke-dasharray="1 6"/>';
    return '<svg viewBox="0 0 1600 600" preserveAspectRatio="none">' + s + '</g></svg>';
  }
  function contour(op) {
    var s = '<g fill="none" stroke="' + STROKE + '" stroke-width=".8" opacity="' + op + '">';
    for (var k = 1; k <= 16; k++) {
      var R = 26 * k, p = '';
      for (var i = 0; i <= 180; i++) { var a = i / 180 * Math.PI * 2, w = 1 + 0.09 * Math.sin(3 * a + k * 0.4) + 0.05 * Math.sin(5 * a - k * 0.7) + 0.03 * Math.sin(9 * a + k); p += (i ? 'L' : 'M') + f(500 + Math.cos(a) * R * w * 1.15) + ' ' + f(500 + Math.sin(a) * R * w); }
      s += '<path d="' + p + 'Z"' + (k % 4 === 0 ? ' stroke-width="1.3"' : '') + '/>';
    }
    return '<svg viewBox="0 0 1000 1000">' + s + '</g></svg>';
  }
  var ICONS = {
    ball: '<circle cx="50" cy="50" r="40"/><path d="M14 34 Q50 56 86 34"/><path d="M14 44 Q50 66 86 44"/>',
    stumps: '<path d="M30 20V92M50 20V92M70 20V92"/><path d="M28 17H50M50 17H72" stroke-width="2.4"/><path d="M18 92H82"/>',
    bat: '<path d="M46 6h8v28h-8z"/><path d="M42 34h16l4 6v52a4 4 0 0 1-4 4H42a4 4 0 0 1-4-4V40z"/><path d="M50 44V88" stroke-dasharray="2 4"/>',
    helmet: '<path d="M18 58a32 32 0 0 1 64 0v4H18z"/><path d="M14 62h46"/><path d="M60 62v18M70 62v16M80 62v14M56 72h28M56 80h22"/><circle cx="34" cy="40" r="3"/>',
    gloves: '<path d="M30 92V54a6 6 0 0 1 6-6h28a6 6 0 0 1 6 6v38z"/><path d="M38 48V20a5 5 0 0 1 10 0v28M50 48V14a5 5 0 0 1 10 0v34M62 48V22a5 5 0 0 1 10 0v26"/><path d="M30 70h40M30 80h40"/>',
    trophy: '<path d="M32 16h36v20a18 18 0 0 1-36 0z"/><path d="M32 22H20a12 12 0 0 0 12 16M68 22h12a12 12 0 0 1-12 16"/><path d="M50 54v18M36 88h28M40 72h20v16H40z"/>'
  };
  function icons(op) {
    var spots = [[1, 4, 96, -12], [93.5, 6, 84, 14], [93.5, 62, 96, -8], [1, 70, 88, 10], [1, 40, 64, -18], [94, 34, 64, 6]];
    return ['ball', 'stumps', 'bat', 'helmet', 'gloves', 'trophy'].map(function (k, i) { var p = spots[i]; return '<svg class="float d' + (i % 3 + 1) + '" viewBox="0 0 100 100" style="left:' + p[0] + '%;top:' + p[1] + '%;width:' + p[2] + 'px;height:' + p[2] + 'px;transform:rotate(' + p[3] + 'deg)"><g fill="none" stroke="' + STROKE + '" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" opacity="' + op + '">' + ICONS[k] + '</g></svg>'; }).join('');
  }
  var PLACE = {
    right: 'right:-18%;top:50%;width:min(1100px,90vw);height:min(1100px,90vw);margin-top:calc(min(1100px,90vw) / -2)',
    bl: 'left:-16%;bottom:-20%;width:min(900px,80vw);height:min(900px,80vw)',
    band: 'left:0;right:0;top:8%;width:100%;height:84%'
  };
  var par = [], tick = false;
  function decorate(host) {
    var layer = d.createElement('div'); layer.className = 'hx-gfx'; layer.setAttribute('aria-hidden', 'true');
    host.getAttribute('data-hx-gfx').split(/\s+/).forEach(function (tok) {
      var kind = tok.split(':')[0], svg = '';
      if (kind === 'icons') { layer.insertAdjacentHTML('beforeend', icons(0.45)); return; }
      if (kind === 'field') svg = ground(0.42); else if (kind === 'seams') svg = seams(0.32); else if (kind === 'contour') svg = contour(0.25);
      if (!svg) return;
      var w = d.createElement('div');
      w.style.cssText = 'position:absolute;' + (kind === 'seams' ? PLACE.band : kind === 'contour' ? PLACE.bl : PLACE.right);
      w.setAttribute('data-par', kind === 'seams' ? '0.08' : '0.18');
      w.innerHTML = svg.replace('<svg ', '<svg style="width:100%;height:100%;position:static" ' + (kind === 'field' ? 'class="spin-slow" ' : ''));
      layer.appendChild(w); par.push(w);
    });
    host.insertBefore(layer, host.firstChild);
  }
  function runPar() {
    tick = false; var vh = innerHeight;
    par.forEach(function (el) { var r = el.parentNode.parentNode.getBoundingClientRect(); if (r.bottom < -200 || r.top > vh + 200) return; var k = +el.getAttribute('data-par'), p = (vh - r.top) / (vh + r.height); el.style.translate = '0 ' + ((0.5 - p) * 520 * k).toFixed(1) + 'px'; });
  }
  var hosts = $$('[data-hx-gfx]');
  if (hasIO) {
    var gio = new IntersectionObserver(function (es) { es.forEach(function (e) { if (!e.isIntersecting) return; gio.unobserve(e.target); decorate(e.target); if (!reduce) runPar(); }); }, { rootMargin: '300px 0px' });
    hosts.forEach(function (h) { gio.observe(h); });
  } else hosts.forEach(decorate);
  if (!reduce) addEventListener('scroll', function () { if (!tick) { tick = true; requestAnimationFrame(runPar); } }, { passive: true });

  /* ---------- Life at the nets: card fan ---------- */
  $$('[data-hx-fan]').forEach(function (stage) {
    var caps = JSON.parse(stage.getAttribute('data-caps') || '[]');
    var cards = $$('.hx-card', stage), fan = stage.querySelector('.hx-fan'), dotsBox = stage.querySelector('.hx-dots'), dots = $$('i', dotsBox);
    var capB = stage.querySelector('.hx-cap b'), capS = stage.querySelector('.hx-cap span');
    var n = cards.length, cur = 0, timer = null, DUR = 5000, visible = false;
    function show(i) {
      cur = (i + n) % n;
      cards.forEach(function (c, k) { c.setAttribute('data-slot', (k - cur + n) % n); });
      if (caps[cur]) { capB.textContent = caps[cur][0]; capS.textContent = caps[cur][1]; }
      dots.forEach(function (dt, k) { dt.classList.remove('on'); void dt.offsetWidth; if (k === cur) dt.classList.add('on'); });
    }
    function auto() { clearInterval(timer); if (!reduce && visible) timer = setInterval(function () { show(cur + 1); }, DUR); }
    dotsBox.style.setProperty('--dur', DUR / 1000 + 's');
    if (reduce) dotsBox.classList.add('paused');
    stage.querySelector('.hx-next').addEventListener('click', function () { show(cur + 1); auto(); });
    stage.querySelector('.hx-prev').addEventListener('click', function () { show(cur - 1); auto(); });
    cards.forEach(function (c) { c.addEventListener('click', function () { show(+c.getAttribute('data-i')); auto(); }); });
    if (fine && !reduce) {
      fan.addEventListener('mouseenter', function () { clearInterval(timer); dotsBox.classList.add('paused'); });
      fan.addEventListener('mouseleave', function () { cards.forEach(function (c) { c.style.setProperty('--rx', '0deg'); c.style.setProperty('--ry', '0deg'); }); dotsBox.classList.remove('paused'); show(cur); auto(); });
      fan.addEventListener('mousemove', function (e) { var r = fan.getBoundingClientRect(), x = (e.clientX - r.left) / r.width - 0.5, y = (e.clientY - r.top) / r.height - 0.5; cards.forEach(function (c) { c.style.setProperty('--ry', (x * 14) + 'deg'); c.style.setProperty('--rx', (-y * 10) + 'deg'); }); });
    }
    /* the reel plays only while on screen; autoplay also pauses off screen */
    var vid = stage.querySelector('video.hx-auto');
    if (hasIO) {
      new IntersectionObserver(function (es) {
        visible = es[0].isIntersecting;
        if (vid && !reduce) { if (visible) { vid.preload = 'auto'; var p = vid.play(); if (p && p.catch) p.catch(function () {}); } else vid.pause(); }
        if (visible) { show(cur); auto(); } else clearInterval(timer);
      }, { threshold: 0.3 }).observe(stage);
    } else { visible = true; auto(); }
    if (vid && reduce) vid.controls = true;
  });

  /* ---------- 22 yards: rolling ball ---------- */
  $$('.hx-pitch').forEach(function (pitch) {
    var stops = $$('.hx-stops li', pitch), ball = pitch.querySelector('.hx-ball'), on = -1;
    function rollTo(i) {
      on = i; stops.forEach(function (s, k) { s.classList.toggle('on', k === i); });
      var pr = pitch.getBoundingClientRect(), r = stops[i].getBoundingClientRect();
      ball.classList.add('on');
      ball.style.transform = 'translate(' + (r.left - pr.left + 9) + 'px,' + (r.top - pr.top + 9) + 'px) rotate(' + (i * 220) + 'deg)';
    }
    stops.forEach(function (s, i) {
      s.addEventListener('click', function () { rollTo(i); });
      s.addEventListener('mouseenter', function () { if (fine) rollTo(i); });
      s.addEventListener('keydown', function (e) { if (e.key === 'Enter' || e.key === ' ') { e.preventDefault(); rollTo(i); } });
    });
    addEventListener('resize', function () { if (on > -1) rollTo(on); });
    if (!reduce && hasIO) {
      var po = new IntersectionObserver(function (es) {
        if (!es[0].isIntersecting) return; po.disconnect();
        var k = 0; rollTo(0); var t = setInterval(function () { k++; if (k >= stops.length) { clearInterval(t); return; } rollTo(k); }, 700);
      }, { threshold: 0.5 });
      po.observe(pitch);
    }
  });

  /* ---------- tilt + magnetic buttons (mouse only) ---------- */
  if (fine && !reduce) {
    $$('[data-hx-tilt]').forEach(function (x) {
      x.addEventListener('mousemove', function (e) { var r = x.getBoundingClientRect(), a = (e.clientX - r.left) / r.width - 0.5, b = (e.clientY - r.top) / r.height - 0.5; x.style.transform = 'perspective(900px) rotateY(' + (a * 10) + 'deg) rotateX(' + (-b * 8) + 'deg)'; });
      x.addEventListener('mouseleave', function () { x.style.transform = ''; });
    });
    $$('.hx-mag').forEach(function (b) {
      b.addEventListener('mousemove', function (e) { var r = b.getBoundingClientRect(); b.style.transform = 'translate(' + ((e.clientX - r.left - r.width / 2) * 0.18) + 'px,' + ((e.clientY - r.top - r.height / 2) * 0.3) + 'px)'; });
      b.addEventListener('mouseleave', function () { b.style.transform = ''; });
    });
  }
})();
