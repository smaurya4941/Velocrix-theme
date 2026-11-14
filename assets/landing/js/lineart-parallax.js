(function(){
"use strict";
var $$ = function(s, r){ return Array.prototype.slice.call((r||document).querySelectorAll(s)); };
/* =========================================================
   GFX — engraved gold line art for section backgrounds
   Usage: <section data-gfx="field:right rosette:left icons">
   ========================================================= */
const GFX = (function(){
  const f = n => n.toFixed(1);
  function ground(o){
    o = Object.assign({stroke:'#B8913F', op:.5}, o||{});
    const C = 500; let s = '';
    s += '<g fill="none" stroke="'+o.stroke+'" stroke-width="1" opacity="'+o.op+'">';
    s += '<ellipse cx="500" cy="500" rx="470" ry="440"/>';
    s += '<ellipse cx="500" cy="500" rx="455" ry="425" stroke-width=".6"/>';
    s += '<ellipse cx="500" cy="500" rx="250" ry="235" stroke-dasharray="2 9" stroke-width="1.6" stroke-linecap="round"/>';
    s += '<ellipse cx="500" cy="500" rx="120" ry="112" stroke-width=".6"/>';
    // compass ticks around the rope
    for (let a=0; a<360; a+=3){ const r = a*Math.PI/180, l = a%15===0 ? 22 : 9; s += '<line x1="'+f(C+Math.cos(r)*478)+'" y1="'+f(C+Math.sin(r)*448)+'" x2="'+f(C+Math.cos(r)*(478+l))+'" y2="'+f(C+Math.sin(r)*(448+l))+'" stroke-width="'+(a%15===0?1:.6)+'"/>'; }
    // pitch and creases
    s += '<rect x="486" y="430" width="28" height="140" stroke-width="1.2"/>';
    s += '<path d="M478 444H522M478 556H522M482 436H518M482 564H518"/>';
    // field radials
    for (let a=0; a<360; a+=45){ const r = a*Math.PI/180; s += '<line x1="'+f(C+Math.cos(r)*130)+'" y1="'+f(C+Math.sin(r)*121)+'" x2="'+f(C+Math.cos(r)*445)+'" y2="'+f(C+Math.sin(r)*416)+'" stroke-dasharray="1 7" stroke-width=".8"/>'; }
    s += '</g>';
    // fielders
    const pos = [[-40,180],[30,300],[78,370],[125,330],[160,210],[205,380],[250,300],[300,390],[330,200]];
    s += '<g fill="'+o.stroke+'" opacity="'+(o.op*1.2)+'">';
    pos.forEach(p => { const r = p[0]*Math.PI/180; s += '<circle cx="'+f(C+Math.cos(r)*p[1])+'" cy="'+f(C+Math.sin(r)*p[1]*.94)+'" r="5"/>'; });
    s += '</g>';
    return '<svg viewBox="0 0 1000 1000">'+s+'</svg>';
  }
  function rosette(o){
    o = Object.assign({stroke:'#D9BC72', op:.22, rings:3}, o||{});
    let s = '<g fill="none" stroke="'+o.stroke+'" stroke-width=".7" opacity="'+o.op+'">';
    const ring = (R, r, d, n) => { let p = ''; const k = (R - r)/r; for (let i=0;i<=n;i++){ const t = i/n*Math.PI*2*r/ gcd(R,r); const x = 500 + (R-r)*Math.cos(t) + d*Math.cos(k*t), y = 500 + (R-r)*Math.sin(t) - d*Math.sin(k*t); p += (i?'L':'M')+f(x)+' '+f(y); } return '<path d="'+p+'Z"/>'; };
    s += ring(480, 32, 70, 2400);
    if (o.rings > 1) s += ring(360, 24, 60, 2000);
    if (o.rings > 2) s += ring(230, 20, 46, 1600);
    s += '<circle cx="500" cy="500" r="120"/><circle cx="500" cy="500" r="112" stroke-dasharray="2 6"/>';
    s += '</g>';
    return '<svg viewBox="0 0 1000 1000">'+s+'</svg>';
  }
  function gcd(a,b){ return b ? gcd(b, a%b) : a; }
  function seams(o){
    o = Object.assign({stroke:'#B8913F', op:.35}, o||{});
    let s = '<g fill="none" stroke="'+o.stroke+'" opacity="'+o.op+'">';
    const arc = (y0, bend) => 'M-40 '+y0+' C 400 '+(y0+bend)+', 1000 '+(y0+bend)+', 1640 '+y0;
    [[200,260],[236,260]].forEach(a => { s += '<path d="'+arc(a[0],a[1])+'" stroke-width="1.1"/>'; });
    // stitches along the two seams
    const pt = (y0, bend, t) => { const P0=[-40,y0],P1=[400,y0+bend],P2=[1000,y0+bend],P3=[1640,y0]; const m=1-t; return [m*m*m*P0[0]+3*m*m*t*P1[0]+3*m*t*t*P2[0]+t*t*t*P3[0], m*m*m*P0[1]+3*m*m*t*P1[1]+3*m*t*t*P2[1]+t*t*t*P3[1]]; };
    for (let i=0;i<=120;i++){ const t = i/120; [[200,260,-1],[236,260,1]].forEach(a => { const p = pt(a[0],a[1],t), q = pt(a[0],a[1],Math.min(1,t+.004)); const ang = Math.atan2(q[1]-p[1], q[0]-p[0]) + a[2]*0.9; s += '<line x1="'+f(p[0])+'" y1="'+f(p[1])+'" x2="'+f(p[0]+Math.cos(ang)*12)+'" y2="'+f(p[1]+Math.sin(ang)*12)+'" stroke-width="1.4" stroke-linecap="round"/>'; }); }
    s += '<path d="'+arc(150,260)+'" stroke-width=".5" stroke-dasharray="1 6"/><path d="'+arc(290,260)+'" stroke-width=".5" stroke-dasharray="1 6"/>';
    s += '</g>';
    return '<svg viewBox="0 0 1600 600" preserveAspectRatio="none">'+s+'</svg>';
  }
  function contour(o){
    o = Object.assign({stroke:'#B8913F', op:.22}, o||{});
    let s = '<g fill="none" stroke="'+o.stroke+'" stroke-width=".8" opacity="'+o.op+'">';
    for (let k=1;k<=16;k++){
      const R = 26*k; let p = '';
      for (let i=0;i<=180;i++){ const a = i/180*Math.PI*2; const w = 1 + .09*Math.sin(3*a + k*.4) + .05*Math.sin(5*a - k*.7) + .03*Math.sin(9*a + k); p += (i?'L':'M')+f(500+Math.cos(a)*R*w*1.15)+' '+f(500+Math.sin(a)*R*w); }
      s += '<path d="'+p+'Z"'+(k%4===0?' stroke-width="1.3"':'')+'/>';
    }
    s += '</g>';
    return '<svg viewBox="0 0 1000 1000">'+s+'</svg>';
  }
  const ICONS = {
    ball: '<circle cx="50" cy="50" r="40"/><path d="M14 34 Q50 56 86 34"/><path d="M14 44 Q50 66 86 44"/>' + (function(){ let s=''; for(let i=0;i<=12;i++){ const t=i/12, x=14+72*t, y1=34+ (4*t*(1-t))*22, y2=44+(4*t*(1-t))*22; s+='<path d="M'+f(x)+' '+f(y1-3)+'l3 3M'+f(x)+' '+f(y2+3)+'l3 -3" stroke-width="1"/>'; } return s; })(),
    stumps: '<path d="M30 20V92M50 20V92M70 20V92"/><path d="M28 17H50M50 17H72" stroke-width="2.4"/><path d="M18 92H82"/>',
    bat: '<path d="M46 6h8v28h-8z"/><path d="M42 34h16l4 6v52a4 4 0 0 1-4 4H42a4 4 0 0 1-4-4V40z"/><path d="M50 44V88" stroke-dasharray="2 4"/>',
    helmet: '<path d="M18 58a32 32 0 0 1 64 0v4H18z"/><path d="M14 62h46"/><path d="M60 62v18M70 62v16M80 62v14M56 72h28M56 80h22"/><circle cx="34" cy="40" r="3"/>',
    gloves: '<path d="M30 92V54a6 6 0 0 1 6-6h28a6 6 0 0 1 6 6v38z"/><path d="M38 48V20a5 5 0 0 1 10 0v28M50 48V14a5 5 0 0 1 10 0v34M62 48V22a5 5 0 0 1 10 0v26"/><path d="M30 70h40M30 80h40"/>',
    trophy: '<path d="M32 16h36v20a18 18 0 0 1-36 0z"/><path d="M32 22H20a12 12 0 0 0 12 16M68 22h12a12 12 0 0 1-12 16"/><path d="M50 54v18M36 88h28M40 72h20v16H40z"/>'
  };
  function icons(o){
    o = Object.assign({stroke:'#B8913F', op:.42, set:['ball','stumps','bat','helmet','gloves','trophy']}, o||{});
    const spots = [[6,12,140,-12],[84,8,120,14],[90,62,150,-8],[3,70,110,10],[48,90,96,-18],[66,30,84,6]];
    return o.set.map((k,i) => { const sp = spots[i % spots.length]; return '<svg class="float d'+(i%3+1)+'" viewBox="0 0 100 100" style="left:'+sp[0]+'%;top:'+sp[1]+'%;width:'+sp[2]+'px;height:'+sp[2]+'px;transform:rotate('+sp[3]+'deg)"><g fill="none" stroke="'+o.stroke+'" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" opacity="'+o.op+'">'+ICONS[k]+'</g></svg>'; }).join('');
  }
  const PLACE = {
    right:'right:-18%;top:50%;width:min(1100px,90vw);height:min(1100px,90vw);transform:translateY(-50%)',
    left:'left:-22%;top:50%;width:min(1000px,86vw);height:min(1000px,86vw);transform:translateY(-50%)',
    tr:'right:-14%;top:-30%;width:min(900px,80vw);height:min(900px,80vw)',
    bl:'left:-16%;bottom:-36%;width:min(900px,80vw);height:min(900px,80vw)',
    center:'left:50%;top:50%;width:min(1300px,120vw);height:min(1300px,120vw);transform:translate(-50%,-50%)',
    band:'left:0;right:0;top:8%;width:100%;height:84%'
  };
  function decorate(root){
    $$('[data-gfx]', root || document).forEach(host => {
      if (host.dataset.gfxDone) return; host.dataset.gfxDone = 1;
      host.classList.add('gfx-host');
      const layer = document.createElement('div'); layer.className = 'gfx'; layer.setAttribute('aria-hidden','true');
      const dark = host.matches('.gx, .board, .parents, footer, .marquee');
      host.dataset.gfx.split(/\s+/).forEach(tok => {
        const [kind, where] = tok.split(':');
        const stroke = dark ? '#D9BC72' : '#B8913F';
        let svg = '';
        if (kind === 'field') svg = ground({stroke, op: dark ? .32 : .42});
        else if (kind === 'rosette') svg = rosette({stroke: dark ? '#D9BC72' : '#B8913F', op: dark ? .22 : .2});
        else if (kind === 'contour') svg = contour({stroke, op: dark ? .22 : .25});
        else if (kind === 'seams') svg = seams({stroke, op: dark ? .3 : .32});
        else if (kind === 'icons'){ layer.insertAdjacentHTML('beforeend', icons({stroke, op: dark ? .35 : .45})); return; }
        if (!svg) return;
        const wrap = document.createElement('div');
        wrap.style.cssText = 'position:absolute;' + (PLACE[where || (kind==='seams'?'band':'right')] || PLACE.right);
        wrap.dataset.par = kind === 'seams' ? '0.08' : '0.18';
        wrap.innerHTML = svg.replace('<svg ', '<svg style="width:100%;height:100%;position:static" ' + (kind==='field'||kind==='rosette' ? 'class="spin-slow" ' : ''));
        layer.appendChild(wrap);
      });
      host.insertBefore(layer, host.firstChild);
    });
  }
  return {decorate, ground, rosette, contour, seams, icons};
})();


GFX.decorate();
/* gentle parallax for the line art */
var reduce = window.matchMedia && matchMedia('(prefers-reduced-motion: reduce)').matches;
if (!reduce){
  var els = $$('[data-par]'), tick = false;
  var run = function(){ tick = false; var vh = innerHeight;
    els.forEach(function(el){ var host = el.closest('.gfx-host'); if (!host) return; var r = host.getBoundingClientRect(); if (r.bottom < -200 || r.top > vh + 200) return;
      var k = +el.dataset.par, prog = (vh - r.top) / (vh + r.height); el.style.translate = '0 ' + ((0.5 - prog) * 520 * k).toFixed(1) + 'px'; }); };
  addEventListener('scroll', function(){ if (!tick){ tick = true; requestAnimationFrame(run); } }, {passive:true});
  run();
}
})();
