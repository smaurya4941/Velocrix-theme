(function(){
"use strict";
var f = document.getElementById('rvShare'); if (!f) return;
var $ = function(id){ return document.getElementById(id); };
var rating = 0, stars = Array.prototype.slice.call(f.querySelectorAll('.rv-stars button'));
function paint(n){ stars.forEach(function(b){ var on = +b.dataset.v <= n; b.classList.toggle('on', on); b.setAttribute('aria-checked', +b.dataset.v === rating); }); }
stars.forEach(function(b){
  b.addEventListener('click', function(){ rating = +b.dataset.v; paint(rating); update(); });
  b.addEventListener('mouseenter', function(){ paint(+b.dataset.v); });
});
f.querySelector('.rv-stars').addEventListener('mouseleave', function(){ paint(rating); });
function msg(){
  var v = function(id){ return $(id).value.trim(); };
  return 'Hello Velocrix! I would like to share a review.\n\n' +
    'Parent: ' + (v('rvName') || '—') + '\n' +
    'Child and batch: ' + (v('rvChild') || '—') + '\n' +
    'Rating: ' + (rating ? rating + ' out of 5' : '—') + '\n\n' +
    'Review: ' + (v('rvText') || '—') + '\n\n' +
    'Permission to publish on the website and Instagram: ' + ($('rvConsent').checked ? 'Yes, with my first name' : 'No, this is private feedback');
}
function complete(){ return $('rvName').value.trim() && rating && $('rvText').value.trim().length >= 10; }
function update(){ $('rvSend').href = 'https://wa.me/918796447595?text=' + encodeURIComponent(msg()); if (complete()) $('rvErr').hidden = true; }
f.addEventListener('input', update); f.addEventListener('change', update);
f.addEventListener('submit', function(e){ e.preventDefault(); });
Array.prototype.forEach.call(document.querySelectorAll('.rv-write'), function(l){ l.addEventListener('click', function(){
  var t = $('rvText'); if (!t.value.trim()) t.value = l.dataset.start || '';
  setTimeout(function(){ try{ t.focus({preventScroll:true}); t.setSelectionRange(t.value.length, t.value.length); }catch(e){} }, 450); update();
}); });
$('rvSend').addEventListener('click', function(e){
  var miss = [];
  if (!$('rvName').value.trim()) miss.push('your name');
  if (!rating) miss.push('a rating');
  if ($('rvText').value.trim().length < 10) miss.push('a few words of review');
  var err = $('rvErr');
  if (miss.length){ e.preventDefault(); err.textContent = 'Please add ' + miss.join(', ') + '.'; err.hidden = false; return; }
  err.hidden = true; update();
});
update();
})();
