(function(){
"use strict";
var PHONE = '918796447595';
var $ = function(s, r){ return (r||document).querySelector(s); };
var $$ = function(s, r){ return Array.prototype.slice.call((r||document).querySelectorAll(s)); };
var reduce = window.matchMedia && matchMedia('(prefers-reduced-motion: reduce)').matches;
var store = {
  get: function(k, d){ try{ var v = localStorage.getItem(k); return v ? JSON.parse(v) : d; }catch(e){ return d; } },
  set: function(k, v){ try{ localStorage.setItem(k, JSON.stringify(v)); }catch(e){} },
  del: function(k){ try{ localStorage.removeItem(k); }catch(e){} }
};
function toast(msg){ var t = $('#toast'); if (!t) return; t.textContent = msg; t.classList.add('show'); clearTimeout(toast._t); toast._t = setTimeout(function(){ t.classList.remove('show'); }, 2400); }
function waLink(text){ return 'https://wa.me/' + PHONE + '?text=' + encodeURIComponent(text); }
var BATS = [[0,'Size 0',62.5],[122,'Size 1',65],[130,'Size 2',67.5],[137,'Size 3',70],[145,'Size 4',72.5],[150,'Size 5',75],[157,'Size 6',77.5],[165,'Harrow',81],[173,'Full size (SH)',85]];
function batFor(h){ var b = BATS[0]; BATS.forEach(function(x){ if (h >= x[0]) b = x; }); return b; }

var full = $('#axFull'), trial = $('#axTrial');
if (!full || !trial) return;
var mode = 'trial', step = 0, quizLevel = null;
var steps = $$('.ax-step[data-step]', full);

/* restore the admission draft */
var draft = store.get('vx-adm2', null);
if (draft){
  Object.keys(draft).forEach(function(k){
    var v = draft[k];
    $$('[name="'+k+'"]', full).forEach(function(el){
      if (el.type === 'radio') el.checked = el.value === v;
      else if (el.type === 'checkbox') el.checked = Array.isArray(v) && v.indexOf(el.value) >= 0;
      else el.value = v;
    });
  });
}
function val(n){
  var els = $$('[name="'+n+'"]', full); if (!els.length) return '';
  if (els[0].type === 'radio'){ var c = els.filter(function(e){ return e.checked; })[0]; return c ? c.value : ''; }
  if (els[0].type === 'checkbox') return els.filter(function(e){ return e.checked; }).map(function(e){ return e.value; });
  return els[0].value.trim();
}
function ageFrom(dob){ if (!dob) return null; var d = new Date(dob + 'T00:00:00'); if (isNaN(d)) return null; var n = new Date(); var a = n.getFullYear() - d.getFullYear(); var m = n.getMonth() - d.getMonth(); if (m < 0 || (m === 0 && n.getDate() < d.getDate())) a--; return a; }
function fmtDate(dob){ return new Date(dob + 'T00:00:00').toLocaleDateString('en-GB', {day:'numeric', month:'short', year:'numeric'}); }
function digits(s){ var d = (s||'').replace(/\D/g,''); return d.length > 10 ? d.slice(-10) : d; }

/* suggested level: the website's level check wins, otherwise experience */
function suggest(){
  $$('#aLevels .rec').forEach(function(r){ r.remove(); });
  var lv = quizLevel;
  if (!lv){ var e = val('exp'); lv = { 'New to cricket':'Beginner', 'Gully or park cricket':'Beginner', 'Has had coaching before':'Development', 'Plays for a school or club team':'Development' }[e] || null; }
  var note = $('#aRecNote');
  if (!lv){ note.textContent = 'the coach confirms it'; return; }
  var o = $('#aLevels .ax-opt[data-k="'+lv+'"]'); if (o) o.insertAdjacentHTML('afterbegin', '<i class="rec">Suggested</i>');
  note.textContent = (quizLevel ? 'from your level check: ' : 'suggested: ') + lv;
}
function ageChip(){
  var a = ageFrom(val('dob')), chip = $('#aAgeChip');
  if (a === null){ chip.hidden = true; return; }
  chip.hidden = false; chip.textContent = 'Age ' + a + (a >= 4 && a <= 25 ? '' : ' · please check the date');
}
function batHint(){
  var h = +val('height'), el = $('#aBatHint');
  if (h >= 90 && h <= 210){ var b = batFor(h); el.innerHTML = 'Suggested bat: <b>' + b[1] + '</b> (' + b[2] + ' cm). <a href="#lab-stance" id="aBat3d">See it in the Stance Studio</a>'; return b; }
  el.textContent = 'We use it to suggest a bat size.'; return null;
}
document.addEventListener('click', function(e){
  if (e.target && e.target.id === 'aBat3d'){ var s = $('#stHeight'), h = +val('height'); if (s && h){ s.value = Math.max(105, Math.min(190, h)); s.dispatchEvent(new Event('input')); } }
});

function message(){
  if (mode === 'trial'){
    var v = function(id){ return $(id).value.trim(); };
    return ['*Enquiry · Velocrix Cricket Academy*', '',
      'Parent: ' + (v('#tParent') || '—'),
      'Mobile: ' + (digits(v('#tPhone')) || '—'),
      'Child: ' + (v('#tChild') || '—') + (v('#tAge') ? ', age ' + v('#tAge') : ''),
      'Interested in: ' + v('#interest')].concat(v('#tNote') ? ['Note: ' + v('#tNote')] : []).concat(['', 'Please call me back with the details. Thank you.']).join('\n');
  }
  var age = ageFrom(val('dob')), b = batHint();
  var L = ['*Admission form · Velocrix Cricket Academy*', '', '*Player*', 'Name: ' + (val('name') || '—')];
  L.push('Date of birth: ' + (val('dob') ? fmtDate(val('dob')) + (age !== null ? ' (age ' + age + ')' : '') : '—'));
  L.push('Gender: ' + val('gender'));
  if (val('school')) L.push('School: ' + val('school'));
  if (val('area')) L.push('Area: ' + val('area'));
  if (val('height')) L.push('Height: ' + val('height') + ' cm' + (b ? ' (bat: ' + b[1] + ')' : ''));
  L.push('', '*Cricket*', 'Role: ' + (val('role').join(', ') || '—'), 'Bats: ' + val('bats') + ' · Bowls: ' + val('bowls'), 'Experience: ' + (val('exp') || '—'), 'Leather ball: ' + val('leather'));
  if (val('prev')) L.push('Previous team: ' + val('prev'));
  L.push('', '*Level and plan*', 'Starting level: ' + (val('level') || '—') + (quizLevel ? ' (website level check: ' + quizLevel + ')' : ''));
  L.push('Plan: ' + val('plan'));
  if (val('goals').length) L.push('Goals: ' + val('goals').join(', '));
  L.push('Start: ' + val('start'));
  L.push('', '*Parent or guardian*', 'Name: ' + (val('pname') || '—') + ' (' + val('rel') + ')', 'Mobile: ' + (digits(val('phone')) || '—'));
  if (val('email')) L.push('Email: ' + val('email'));
  L.push('Heard about us: ' + val('heard'));
  if (val('note')) L.push('Note: ' + val('note'));
  L.push('', 'Please share the batch timing and next steps. Thank you.');
  return L.join('\n');
}
var esc = function(s){ return s.replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;'); };
var NAMES = ['name','dob','gender','school','area','height','role','bats','bowls','exp','leather','prev','level','plan','goals','start','pname','rel','phone','email','heard','note'];
function update(){
  var m = message(), now = new Date();
  var tm = String(now.getHours()).padStart(2,'0') + ':' + String(now.getMinutes()).padStart(2,'0');
  $('#msgBubble').innerHTML = esc(m).replace(/\*([^*\n]+)\*/g, '<b>$1</b>') + '<span class="t">' + tm + ' ✓✓</span>';
  $('#waSend').href = waLink(m);
  if (mode === 'full'){ var d = {}; NAMES.forEach(function(n){ d[n] = val(n); }); store.set('vx-adm2', d); }
}
function checkField(f, show){
  var good, g = f.dataset.group, kind = f.dataset.kind;
  if (g) good = $$('[name="'+g+'"]', f.closest('form')).some(function(e){ return e.checked; });
  else {
    var inp = $('input,select,textarea', f), v = inp.value.trim();
    if (kind === 'phone') good = digits(v).length === 10;
    else if (kind === 'dob'){ var a = ageFrom(v); good = a !== null && a >= 3 && a <= 30; }
    else if (kind === 'age') good = +v >= 4 && +v <= 25;
    else good = !!v;
  }
  f.classList.toggle('bad', !!show && !good);
  return good;
}
function checkStep(i, show){ var ok = true; $$('.ax-f[data-req]', steps[i]).forEach(function(f){ if (!checkField(f, show)) ok = false; }); return ok; }
function checkTrial(show){ var ok = true; $$('.ax-f[data-req]', trial).forEach(function(f){ if (!checkField(f, show)) ok = false; }); return ok; }
function goStep(i, focus){
  step = i;
  steps.forEach(function(s, j){ s.hidden = j !== i; });
  $$('#axSteps button').forEach(function(b, j){ b.classList.toggle('on', j === i); b.classList.toggle('done', j < i && checkStep(j, false)); });
  $('#axBack').hidden = i === 0;
  $('#axStepLbl').textContent = 'Step ' + (i+1) + ' of 4';
  $('#axNext').textContent = i === 3 ? 'Review message' : 'Next';
  if (i === 2) suggest();
  if (focus){ var t = $('input:not([type=radio]):not([type=checkbox]),select', steps[i]); if (t) t.focus({preventScroll:true}); }
}
$('#axNext').addEventListener('click', function(){
  if (!checkStep(step, true)){ var f = $('.ax-f.bad input, .ax-f.bad select', steps[step]); if (f) f.focus(); toast('Fill in the highlighted fields'); return; }
  if (step < 3){ goStep(step + 1, true); var c = full.getBoundingClientRect(); if (c.top < 0) scrollTo({top: scrollY + c.top - 90, behavior: reduce ? 'auto' : 'smooth'}); }
  else { var chat = $('.ax-chat'); scrollTo({top: chat.getBoundingClientRect().top + scrollY - 90, behavior: reduce ? 'auto' : 'smooth'}); if (chat.animate && !reduce) chat.animate([{transform:'scale(1)'},{transform:'scale(1.02)'},{transform:'scale(1)'}], {duration:600}); toast('Your message is ready to send'); }
});
$('#axBack').addEventListener('click', function(){ goStep(Math.max(0, step - 1)); });
$$('#axSteps button').forEach(function(b){ b.addEventListener('click', function(){ var t = +b.dataset.s; if (t <= step) return goStep(t); for (var j = step; j < t; j++){ if (!checkStep(j, true)){ goStep(j); toast('Finish this step first'); return; } } goStep(t); }); });
function onChange(e){
  var f = e.target.closest('.ax-f'); if (f && f.classList.contains('bad')) checkField(f, true);
  if (e.target.name === 'dob') ageChip();
  if (e.target.name === 'exp') suggest();
  update();
}
full.addEventListener('input', onChange); full.addEventListener('change', onChange);
trial.addEventListener('input', onChange); trial.addEventListener('change', onChange);
full.addEventListener('submit', function(e){ e.preventDefault(); }); trial.addEventListener('submit', function(e){ e.preventDefault(); });

$('#waSend').addEventListener('click', function(e){
  if (mode === 'trial'){ if (!checkTrial(true)){ e.preventDefault(); toast('Fill in the highlighted fields'); var f = $('.ax-f.bad input', trial); if (f) f.focus(); } return; }
  for (var j = 0; j < 4; j++){ if (!checkStep(j, true)){ e.preventDefault(); goStep(j); toast('Step ' + (j+1) + ' needs a few details'); scrollTo({top: full.getBoundingClientRect().top + scrollY - 100, behavior: reduce ? 'auto' : 'smooth'}); return; } }
});
$('#msgCopy').addEventListener('click', function(){
  var text = message(), btn = this;
  var ok = function(){ btn.textContent = 'Copied'; setTimeout(function(){ btn.textContent = 'Copy message'; }, 1600); };
  try{ navigator.clipboard.writeText(text).then(ok, function(){ toast('Select the message and copy it'); }); }catch(err){ toast('Select the message and copy it'); }
});
$('#msgClear').addEventListener('click', function(){
  if (mode === 'trial'){ trial.reset(); $$('.ax-f.bad', trial).forEach(function(f){ f.classList.remove('bad'); }); }
  else { full.reset(); store.del('vx-adm2'); $$('.ax-f.bad', full).forEach(function(f){ f.classList.remove('bad'); }); goStep(0); ageChip(); batHint(); }
  update(); toast('Form cleared');
});
function setMode(m){
  mode = m;
  $$('#axTabs button').forEach(function(x){ var on = x.dataset.t === m; x.classList.toggle('on', on); x.setAttribute('aria-selected', on); });
  full.hidden = m !== 'full'; trial.hidden = m !== 'trial'; update();
}
$$('#axTabs button').forEach(function(b){ b.addEventListener('click', function(){ setMode(b.dataset.t); }); });

/* shortcuts from elsewhere on the page (girls' cricket, camps…) */
$$('[data-interest]').forEach(function(a){ a.addEventListener('click', function(){
  var want = a.dataset.interest, s = $('#interest');
  Array.prototype.forEach.call(s.options, function(o){ if (o.text === want) s.value = o.text; });
  $$('[data-interest-box]', full).forEach(function(c){ if (c.dataset.interestBox === want) c.checked = true; });
  setMode('trial');
}); });
/* level check result from the quiz */
document.addEventListener('vx:level', function(e){
  quizLevel = e.detail;
  var r = $('#aLevels input[value="'+quizLevel+'"]'); if (r && !val('level')) r.checked = true;
  suggest(); update();
});
$('#copyPhone').addEventListener('click', function(){
  var btn = this; try{ navigator.clipboard.writeText(($('#phoneTxt')||{}).textContent||'+91 879 644 7595').then(function(){ btn.textContent = 'Copied'; setTimeout(function(){ btn.textContent = 'Copy'; }, 1600); }); }catch(e){}
});

ageChip(); batHint(); suggest(); goStep(0); update();
})();
