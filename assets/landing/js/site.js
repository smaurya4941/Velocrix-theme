(function(){
  var PHONE='918796447595';
  var reduce=window.matchMedia&&matchMedia('(prefers-reduced-motion: reduce)').matches;
  var fine=window.matchMedia&&matchMedia('(hover:hover) and (pointer:fine)').matches;
  var $=function(id){return document.getElementById(id)};
  var inr=function(n){return '₹'+Math.round(n).toLocaleString('en-IN')};
  function waUrl(t){return 'https://wa.me/'+PHONE+'?text='+encodeURIComponent(t)}
  function store(k,v){try{if(v===undefined)return JSON.parse(localStorage.getItem(k));localStorage.setItem(k,JSON.stringify(v))}catch(e){return null}}
  /* shutter intro + hero reveal */
  var intro=$('intro'),sc=$('showcase');
  function heroGo(){sc.classList.add('go')}
  if(!reduce)sc.classList.add('armed');
  function finishIntro(){if(!intro||intro.hidden)return;intro.classList.add('open');document.documentElement.style.overflow='';setTimeout(heroGo,250);setTimeout(function(){intro.hidden=true;intro.classList.remove('open')},1300)}
  if(window.__vxIntro){var it=setTimeout(finishIntro,1300);$('skipIntro').addEventListener('click',function(){clearTimeout(it);finishIntro()});setTimeout(function(){if(!intro.hidden)finishIntro()},4000)}
  else requestAnimationFrame(function(){requestAnimationFrame(heroGo)});
  $('replay').addEventListener('click',function(){
    if(reduce)return;scrollTo(0,0);sc.classList.remove('go');void sc.offsetWidth;
    var fresh=intro.cloneNode(true);intro.parentNode.replaceChild(fresh,intro);intro=fresh;intro.hidden=false;intro.classList.remove('open');document.documentElement.style.overflow='hidden';
    var t2=setTimeout(finishIntro,1300);intro.querySelector('.skip').addEventListener('click',function(){clearTimeout(t2);finishIntro()});
  });
  /* showcase depth on mouse + scroll */
  if(fine&&!reduce){var layers=[].slice.call(sc.querySelectorAll('.layer'));
    sc.addEventListener('mousemove',function(e){var r=sc.getBoundingClientRect(),x=(e.clientX-r.left)/r.width-.5,y=(e.clientY-r.top)/r.height-.5;layers.forEach(function(l){var d=+l.dataset.depth;l.style.transform='translate('+(-x*d)+'px,'+(-y*d)+'px)'})});
    sc.addEventListener('mouseleave',function(){layers.forEach(function(l){l.style.transform=''})});}
  if(!reduce){var bt=sc.querySelector('.bigtype');addEventListener('scroll',function(){var y=Math.min(scrollY,900);bt.style.translate=(-y*.12)+'px 0'},{passive:true})}

  var NS='http://www.w3.org/2000/svg';
  function el(t,a){var e=document.createElementNS(NS,t);for(var k in a)e.setAttribute(k,a[k]);return e}
  function svgPt(svg,e){var p=svg.createSVGPoint();p.x=e.clientX;p.y=e.clientY;return p.matrixTransform(svg.getScreenCTM().inverse())}
  function copy(text,btn,label,selEl){
    function ok(){btn.textContent='Copied';setTimeout(function(){btn.textContent=label},1600)}
    function fb(){if(selEl&&selEl.select){selEl.select();return}var r=document.createRange();r.selectNodeContents(selEl||$('phoneTxt'));var s=getSelection();s.removeAllRanges();s.addRange(r)}
    try{navigator.clipboard.writeText(text).then(ok,fb)}catch(e){fb()}
  }

  /* header: progress, hide on scroll down, active link */
  var top=$('top'),prog=$('progress'),lastY=0;
  var secs=[].slice.call(document.querySelectorAll('main section[id]'));
  var links=[].slice.call(document.querySelectorAll('.nav a'));
  addEventListener('scroll',function(){
    var y=scrollY,h=document.documentElement.scrollHeight-innerHeight;
    prog.style.setProperty('--p',h>0?(y/h).toFixed(4):0);
    top.classList.toggle('scrolled',y>8);
    if(!$('nav').classList.contains('open'))top.classList.toggle('hide',y>lastY+2&&y>400);
    lastY=y;
    var cur='';secs.forEach(function(s){if(s.getBoundingClientRect().top<innerHeight*.35)cur=s.id});
    links.forEach(function(a){a.classList.toggle('on',a.getAttribute('href')==='#'+cur)});
  },{passive:true});
  var nav=$('nav'),mb=$('menuBtn');
  mb.addEventListener('click',function(){var o=nav.classList.toggle('open');mb.setAttribute('aria-expanded',o)});
  nav.addEventListener('click',function(e){if(e.target.tagName==='A'){nav.classList.remove('open');mb.setAttribute('aria-expanded','false')}});

  /* live training status (India time) */
  var days=['Sun','Mon','Tue','Wed','Thu','Fri','Sat'],train=[1,3,5,6],full={1:'Monday',3:'Wednesday',5:'Friday',6:'Saturday'},dow;
  try{dow=days.indexOf(new Date().toLocaleString('en-US',{timeZone:'Asia/Kolkata',weekday:'short'}))}catch(e){dow=-1}
  if(dow<0)dow=new Date().getDay();
  if(train.indexOf(dow)>=0){$('status').classList.add('live');$('statusTxt').textContent='Training today'}
  else{var n=dow;do{n=(n+1)%7}while(train.indexOf(n)<0);$('statusTxt').textContent='Next session: '+full[n]}
  [].forEach.call(document.querySelectorAll('.day'),function(d){if(+d.dataset.dow===dow){d.classList.add('today');var s=document.createElement('span');s.className='now';s.textContent='Today';d.appendChild(s)}});

  /* reveal + counters + chat */
  if('IntersectionObserver' in window){
    var ro=new IntersectionObserver(function(es){es.forEach(function(e){if(e.isIntersecting){e.target.classList.add('in');ro.unobserve(e.target)}})},{threshold:.1});
    [].forEach.call(document.querySelectorAll('[data-reveal]'),function(x){if(x.getBoundingClientRect().top<innerHeight)x.classList.add('in');else ro.observe(x)});
    var co=new IntersectionObserver(function(es){es.forEach(function(e){if(!e.isIntersecting)return;co.unobserve(e.target);
      if(reduce)return;var x=e.target,end=+x.dataset.count,t0=performance.now();
      (function step(t){var k=Math.min(1,(t-t0)/1200);x.textContent=Math.round(end*(1-Math.pow(1-k,3)));if(k<1)requestAnimationFrame(step)})(t0);
    })},{threshold:.6});
    [].forEach.call(document.querySelectorAll('[data-count]'),function(x){co.observe(x)});
    var cho=new IntersectionObserver(function(es){if(es[0].isIntersecting&&!reduce){$('chat').classList.add('play');cho.disconnect()}},{threshold:.4});
    cho.observe($('chat'));
  }

  /* marquee */
  var words=['Bat','Bowl','Field','Keep','Think','Where dreams meet discipline'],html='';
  for(var r=0;r<2;r++)words.forEach(function(w){html+='<span>'+w+'<i class="ball"></i></span>'});
  $('track').innerHTML=html;

  /* autoplay muted videos while visible */
  var autos=[].slice.call(document.querySelectorAll('video.auto'));
  if(!reduce&&'IntersectionObserver' in window){
    var io=new IntersectionObserver(function(es){es.forEach(function(e){var v=e.target;if(e.isIntersecting){v.preload='auto';var p=v.play();if(p&&p.catch)p.catch(function(){})}else v.pause()})},{threshold:.35});
    autos.forEach(function(v){io.observe(v)});
  } else autos.forEach(function(v){v.controls=true});

  /* hero: stepped fan */
  var cards=[].slice.call(document.querySelectorAll('.card-m')),cur=0,timer=null,DUR=5000;
  var caps=[['At the nets','Ball 1 of 3: batting, catching, repeat'],['The load-up','Ball 2 of 3: high arm, eyes on the target'],['Focus','Ball 3 of 3: every delivery starts in the head']];
  var dots=[].slice.call($('dots').children);
  function show(i){cur=(i+3)%3;cards.forEach(function(c,k){c.dataset.slot=(k-cur+3)%3});
    $('capT').textContent=caps[cur][0];$('capS').textContent=caps[cur][1];
    dots.forEach(function(d,k){d.classList.remove('on');void d.offsetWidth;if(k===cur)d.classList.add('on')})}
  function auto(){clearInterval(timer);if(!reduce)timer=setInterval(function(){show(cur+1)},DUR)}
  $('dots').style.setProperty('--dur',DUR/1000+'s');if(reduce)$('dots').classList.add('paused');
  $('nextCard').addEventListener('click',function(){show(cur+1);auto()});
  $('prevCard').addEventListener('click',function(){show(cur-1);auto()});
  cards.forEach(function(c){c.addEventListener('click',function(){show(+c.dataset.i);auto()})});
  var fan=$('fan');
  if(fine&&!reduce){
    fan.addEventListener('mouseenter',function(){clearInterval(timer);$('dots').classList.add('paused')});
    fan.addEventListener('mouseleave',function(){cards.forEach(function(c){c.style.setProperty('--rx','0deg');c.style.setProperty('--ry','0deg')});$('dots').classList.remove('paused');show(cur);auto()});
    fan.addEventListener('mousemove',function(e){var r=fan.getBoundingClientRect(),x=(e.clientX-r.left)/r.width-.5,y=(e.clientY-r.top)/r.height-.5;
      cards.forEach(function(c){c.style.setProperty('--ry',(x*14)+'deg');c.style.setProperty('--rx',(-y*10)+'deg')})});
  }
  auto();

  /* tilt, magnetic buttons, cursor ring (mouse only) */
  if(fine&&!reduce){
    [].forEach.call(document.querySelectorAll('[data-tilt]'),function(x){
      x.addEventListener('mousemove',function(e){var r=x.getBoundingClientRect(),a=(e.clientX-r.left)/r.width-.5,b=(e.clientY-r.top)/r.height-.5;x.style.transform='perspective(900px) rotateY('+(a*10)+'deg) rotateX('+(-b*8)+'deg)'});
      x.addEventListener('mouseleave',function(){x.style.transform=''});
    });
    [].forEach.call(document.querySelectorAll('.mag'),function(b){
      b.addEventListener('mousemove',function(e){var r=b.getBoundingClientRect();b.style.transform='translate('+((e.clientX-r.left-r.width/2)*.18)+'px,'+((e.clientY-r.top-r.height/2)*.3)+'px)'});
      b.addEventListener('mouseleave',function(){b.style.transform=''});
    });
    var cu=$('cursor'),mx=0,my=0,cx=0,cy=0;
    addEventListener('mousemove',function(e){mx=e.clientX;my=e.clientY;cu.classList.add('on');var t=e.target.closest&&e.target.closest('a,button,label,.card-m,.pos,.fielder,.stops li,.reel,input,select,summary,.handle,tbody tr');cu.classList.toggle('big',!!t)});
    document.addEventListener('mouseleave',function(){cu.classList.remove('on')});
    (function loop(){cx+=(mx-cx)*.2;cy+=(my-cy)*.2;cu.style.transform='translate('+cx+'px,'+cy+'px)';requestAnimationFrame(loop)})();
  }

  /* mentor video */
  var mv=$('manifesto'),pb=$('playBtn'),pl=$('player');
  function setBtn(){var on=!mv.paused;pl.classList.toggle('playing',on);pb.querySelector('use').setAttribute('href',on?'#i-pause':'#i-sound');pb.querySelector('span').textContent=on?'Pause':(mv.currentTime>0&&!mv.ended?'Resume':'Play with sound')}
  pb.addEventListener('click',function(){if(mv.paused){mv.muted=false;var p=mv.play();if(p&&p.catch)p.catch(function(){})}else mv.pause()});
  mv.addEventListener('play',setBtn);mv.addEventListener('pause',setBtn);mv.addEventListener('ended',setBtn);
  mv.addEventListener('click',function(){pb.click()});

  /* pitch: rolling ball */
  var stops=[].slice.call($('stops').children),pball=$('pball'),pitch=$('pitch'),pon=0;
  function rollTo(i){pon=i;stops.forEach(function(s,k){s.classList.toggle('on',k===i)});var pr=pitch.getBoundingClientRect(),r=stops[i].getBoundingClientRect();
    pball.style.transform='translate('+(r.left-pr.left+9)+'px,'+(r.top-pr.top+9)+'px) rotate('+(i*220)+'deg)'}
  stops.forEach(function(s,i){s.addEventListener('click',function(){rollTo(i)});s.addEventListener('mouseenter',function(){if(fine)rollTo(i)});s.addEventListener('keydown',function(e){if(e.key==='Enter'||e.key===' '){e.preventDefault();rollTo(i)}})});
  rollTo(0);addEventListener('resize',function(){rollTo(pon)});
  if(!reduce&&'IntersectionObserver' in window){var po=new IntersectionObserver(function(es){if(es[0].isIntersecting){po.disconnect();var k=0,t=setInterval(function(){k++;if(k>4){clearInterval(t);return}rollTo(k)},700)}},{threshold:.5});po.observe(pitch)}

  /* level quiz */
  var Q=[
    {q:"How old is your child?",o:["5 to 8","9 to 12","13 to 16","17 or older"],s:[0,1,2,2],key:'Age'},
    {q:"How much cricket have they played?",o:["None yet","Gully or park cricket","Some coaching before","School or club team"],s:[0,1,2,3],key:'Experience'},
    {q:"Have they played with a hard leather ball?",o:["Not yet","A few times","Regularly"],s:[0,1,2],key:'Leather ball'},
    {q:"Can they bowl overarm with a straight arm?",o:["Not yet","Mostly","Yes, every ball"],s:[0,1,2],key:'Bowling action'},
    {q:"What are you hoping for?",o:["Fun and fitness","A place in the school team","District or state trials"],s:[0,0,0],key:'Goal'}
  ];
  var ans=[],qi=0,qbody=$('qbody');
  function qrender(){
    if(qi>=Q.length)return qresult();
    var q=Q[qi];$('qcount').textContent='Question '+(qi+1)+' of '+Q.length;$('qbar').style.setProperty('--w',((qi+1)/Q.length*100)+'%');
    var h='<p class="qtext">'+q.q+'</p><div class="opts" role="group" aria-label="'+q.q+'">';
    q.o.forEach(function(o,k){h+='<button type="button" data-k="'+k+'" aria-pressed="'+(ans[qi]===k)+'"><span class="k">'+String.fromCharCode(65+k)+'</span>'+o+'</button>'});
    h+='</div><div class="qnav"><button type="button" class="btn btn-ghost btn-sm" id="qback"'+(qi===0?' disabled':'')+'>Back</button><span class="hint">Pick an answer to continue</span></div>';
    qbody.innerHTML=h;
    [].forEach.call(qbody.querySelectorAll('.opts button'),function(b){b.addEventListener('click',function(){ans[qi]=+b.dataset.k;
      [].forEach.call(qbody.querySelectorAll('.opts button'),function(x){x.setAttribute('aria-pressed',x===b)});setTimeout(function(){qi++;qrender()},reduce?0:260)})});
    $('qback').addEventListener('click',function(){if(qi>0){qi--;qrender()}});
    $('levels').classList.remove('picked');
  }
  function qresult(){
    var sc=0;Q.forEach(function(q,k){sc+=q.s[ans[k]||0]});
    var lv=sc<=3?'Beginner':sc<=6?'Development':'Advanced';try{document.dispatchEvent(new CustomEvent('vx:level',{detail:lv}))}catch(e){}
    var why={Beginner:'A great place to start. We build grip, stance and a safe action, and make sure your child loves the game.',Development:'Your child has the basics. Next comes footwork, consistency and reading the game.',Advanced:'Already a match player. We work on pressure batting, plans for each bowler and trial preparation.'}[lv];
    $('qcount').textContent='Your result';$('qbar').style.setProperty('--w','100%');
    var lines=Q.map(function(q,k){return q.key+': '+q.o[ans[k]||0]}).join('\n');
    var msg='Hello Velocrix! I did the level check on your website.\n\nSuggested level: '+lv+'\n'+lines+'\n\nCan we book a free trial?';
    qbody.innerHTML='<div class="result"><div style="display:grid;gap:10px"><span class="hint">Suggested starting level</span><span class="lvname">'+lv+'</span><p style="color:var(--ink-2)">'+why+' We confirm the level on the ground at the free trial.</p><button type="button" class="btn btn-ghost btn-sm" id="qagain" style="justify-self:start">Start again</button></div><div><label class="hint" for="qmsg">Your message to Velocrix. You can edit it.</label><textarea id="qmsg"></textarea><div class="acts"><a class="btn btn-wa" id="qwa" target="_blank" rel="noopener" href="'+waUrl(msg)+'"><svg aria-hidden="true"><use href="#i-wa"/></svg>Send on WhatsApp</a><button type="button" class="btn btn-ghost" id="qcopy">Copy</button></div></div></div>';
    $('qmsg').value=msg;
    $('qmsg').addEventListener('input',function(){$('qwa').href=waUrl(this.value)});
    $('qcopy').addEventListener('click',function(){copy($('qmsg').value,this,'Copy',$('qmsg'))});
    $('qagain').addEventListener('click',function(){ans=[];qi=0;qrender()});
    var L=$('levels');L.classList.add('picked');[].forEach.call(L.children,function(c){c.classList.toggle('match',c.dataset.lv===lv)});
  }
  qrender();


  /* field explorer */
  var P=[
    ['Wicket-keeper',50,34,'Behind the stumps','Takes the ball when the batter misses it. Catches edges, makes stumpings and run-outs.'],
    ['Slips',43.5,33.5,'Off side, close','Stand next to the keeper, waiting for the thin edge off a fast bowler.'],
    ['Gully',37,37,'Off side, close','Between the slips and point. Catches the hard, rising edge.'],
    ['Silly point',45,41.5,'Off side, very close','A few steps from the bat with a helmet on. Snaps up bat-pad catches against spin.'],
    ['Point',23,41,'Off side, in the circle','Square of the batter on the off side. Stops the cut shot.'],
    ['Cover',27,56,'Off side, in the circle','In front of square. Stops drives and is often the best run-out fielder in the team.'],
    ['Mid-off',41,72,'Off side, near the bowler','Straight, on the off side of the bowler. Stops the straight drive.'],
    ['Long-off',37,93,'Off side, boundary','On the boundary behind mid-off. Catches lofted drives.'],
    ['Third man',22,10.5,'Off side, boundary','Behind square on the off side. Collects late cuts and edges that fly past the slips.'],
    ['Mid-on',59,72,'Leg side, near the bowler','Straight, on the leg side of the bowler. Stops drives through the on side.'],
    ['Long-on',63,93,'Leg side, boundary','On the boundary behind mid-on. Catches the big straight hit.'],
    ['Mid-wicket',72,57,'Leg side, in the circle','In front of square on the leg side. Stops the flick and the pull.'],
    ['Square leg',77,41,'Leg side, in the circle','Square of the batter on the leg side, near where the second umpire stands.'],
    ['Short leg',56,41.5,'Leg side, very close','Right next to the batter with a helmet on, for bat-pad catches.'],
    ['Fine leg',78,10.5,'Leg side, boundary','Behind square on the leg side. Stops the glance and the hook.'],
    ['Cow corner',83,82,'Leg side, boundary','Deep mid-wicket, where big swings across the line usually land.'],
    ['Bowler',50,64,'The bowler','Runs in from the other end. After bowling, fields straight back down the pitch.']
  ];
  var pg=$('posG'),fsvg=$('fieldSvg'),leg=$('legend'),posEls=[];
  function showPos(i){var p=P[i];$('pName').textContent=p[0];$('pSide').textContent=p[3];$('pDesc').textContent=p[4];
    posEls.forEach(function(g,k){g.classList.toggle('on',k===i)});[].forEach.call(leg.children,function(b,k){b.classList.toggle('on',k===i)})}
  P.forEach(function(p,i){var g=el('g',{class:'pos',tabindex:0,role:'button','aria-label':p[0]});
    g.appendChild(el('circle',{cx:p[1],cy:p[2],r:4,fill:'transparent'}));
    g.appendChild(el('circle',{class:'dot',cx:p[1],cy:p[2],r:1.8}));
    var t=el('text',{x:p[1],y:p[2]<8?p[2]+5.5:p[2]-3,'text-anchor':'middle'});t.textContent=p[0];g.appendChild(t);
    g.addEventListener('mouseenter',function(){showPos(i)});g.addEventListener('click',function(){showPos(i)});g.addEventListener('focus',function(){showPos(i)});
    pg.appendChild(g);posEls.push(g);
    var b=document.createElement('button');b.type='button';b.textContent=p[0];b.addEventListener('click',function(){showPos(i);moveF(p[1],p[2]+5,true)});leg.appendChild(b);
  });
  var fd=$('fielder'),fdrag=false,fx=70,fy=76;
  function nearest(x,y){var b=0,bd=1e9;P.forEach(function(p,i){var d=(p[1]-x)*(p[1]-x)+(p[2]-y)*(p[2]-y);if(d<bd){bd=d;b=i}});return b}
  function moveF(x,y,quiet){var dx=x-50,dy=y-50,r=Math.sqrt(dx*dx+dy*dy);if(r>46){x=50+dx/r*46;y=50+dy/r*46}fx=x;fy=y;fd.setAttribute('transform','translate('+x+' '+y+')');if(!quiet)showPos(nearest(x,y))}
  fd.addEventListener('pointerdown',function(e){fdrag=true;fsvg.setPointerCapture(e.pointerId);e.preventDefault()});
  fsvg.addEventListener('pointermove',function(e){if(!fdrag)return;var p=svgPt(fsvg,e);moveF(p.x,p.y)});
  fsvg.addEventListener('pointerup',function(){fdrag=false});fsvg.addEventListener('pointercancel',function(){fdrag=false});
  fd.addEventListener('keydown',function(e){var m={ArrowLeft:[-2,0],ArrowRight:[2,0],ArrowUp:[0,-2],ArrowDown:[0,2]}[e.key];if(m){e.preventDefault();moveF(fx+m[0],fy+m[1])}});
  showPos(11);

  /* fees */
  var plans=[{k:'m',name:'Monthly',price:3000,months:1},{k:'q',name:'Quarterly',price:8500,months:3},{k:'h',name:'Half-yearly',price:16200,months:6},{k:'a',name:'Annual',price:30000,months:12}];
  var tb=$('rateBody'),seg=$('planSeg'),rows=[];
  plans.forEach(function(p,i){
    var pm=p.price/p.months,save=3000*p.months-p.price,tr=document.createElement('tr');
    tr.innerHTML='<td>'+p.name+'</td><td class="n">'+inr(p.price)+'</td><td class="n">'+inr(pm)+'</td><td class="n '+(save?'save':'')+'">'+(save?inr(save):'–')+'</td>';
    tr.addEventListener('click',function(){$('plan-'+p.k).checked=true;calc()});tb.appendChild(tr);rows.push(tr);
    var l=document.createElement('label');l.innerHTML='<input type="radio" name="plan" value="'+i+'" id="plan-'+p.k+'"'+(i===1?' checked':'')+'><span>'+p.name+'</span>';seg.appendChild(l);
  });
  var sarv=$('sarv'),sib=$('sib'),shown=8500;
  function calc(){
    var i=+(document.querySelector('input[name=plan]:checked')||{value:1}).value,p=plans[i];
    rows.forEach(function(r,k){r.classList.toggle('sel',k===i)});
    var d=(sarv.checked?.10:0)+(sib.checked?.05:0),t=p.price*(1-d);
    $('totLabel').textContent=p.name+' plan'+(d?' with '+Math.round(d*100)+'% off':'');
    $('totNote').textContent=p.months>1?'Works out to '+inr(t/p.months)+' a month':'Billed every calendar month';
    var from=shown,t0=performance.now();shown=t;
    if(reduce){$('totAmt').textContent=inr(t);return}
    (function step(n){var k=Math.min(1,(n-t0)/450);$('totAmt').textContent=inr(from+(t-from)*(1-Math.pow(1-k,3)));if(k<1)requestAnimationFrame(step)})(t0);
  }
  seg.addEventListener('change',calc);sarv.addEventListener('change',calc);sib.addEventListener('change',calc);calc();

  /* bat size */
  var chart=[[0,122,'Size 0','Usually under 5'],[122,130,'Size 1','Usually ages 4 to 6'],[130,137,'Size 2','Usually ages 6 to 8'],[137,145,'Size 3','Usually ages 8 to 10'],[145,150,'Size 4','Usually ages 9 to 11'],[150,157,'Size 5','Usually ages 10 to 12'],[157,165,'Size 6','Usually ages 11 to 13'],[165,173,'Harrow','Usually ages 12 to 14'],[173,999,'Full size (SH)','Teens and adults']];
  function bat(){var h=+$('hgt').value,ci=0;chart.forEach(function(c,k){if(h>=c[0]&&h<c[1])ci=k});var c=chart[ci];
    $('hval').textContent=h+' cm';$('bsize').textContent=c[2];$('bage').textContent=c[3];
    $('kidBar').style.height=(h-62)+'px';$('batBar').style.height=(52+ci*7)+'px'}
  $('hgt').addEventListener('input',bat);bat();

  /* warm-up timer */
  var M=[['Arm circles','Big circles forwards, then backwards.'],['Leg swings','Hold a wall and swing each leg front to back.'],['High knees','Quick feet on the spot, knees up to the waist.'],['Lunge with a twist','Step forward and turn your chest over the front knee.'],['Side shuffles','Low and quick, like chasing a ball to the boundary.'],['Shadow bowling','Three slow bowling actions without a ball, then three quicker.']];
  var mi=0,left=20,tick=null,C=301.6;
  function tdraw(){var fin=mi>=M.length;$('mstep').textContent=fin?'All six done':'Move '+(mi+1)+' of '+M.length;$('mname').textContent=fin?'Warm-up complete':M[mi][0];$('mtip').textContent=fin?'Ready to train. See you at the nets!':M[mi][1];
    $('tsec').textContent=fin?'✓':left;$('tring').setAttribute('stroke-dashoffset',fin?0:C*(1-left/20))}
  function tstop(){clearInterval(tick);tick=null;$('tstart').querySelector('span').textContent=mi>=M.length?'Again':'Start';$('tstart').querySelector('use').setAttribute('href','#i-play')}
  $('tstart').addEventListener('click',function(){
    if(tick){tstop();return}
    if(mi>=M.length){mi=0;left=20}
    $('tstart').querySelector('span').textContent='Pause';$('tstart').querySelector('use').setAttribute('href','#i-pause');
    tick=setInterval(function(){left--;if(left<=0){mi++;left=20;if(mi>=M.length)tstop()}tdraw()},1000);tdraw();
  });
  $('tnext').addEventListener('click',function(){if(mi<M.length){mi++;left=20;if(mi>=M.length)tstop()}tdraw()});
  tdraw();

  /* checklist */
  var items=['Sports shoes with grip','Water bottle','Cap','Comfortable clothes','Small towel','A snack for after','Arrive 10 minutes early'];
  var ticked=store('vx-check')||{};
  $('check').innerHTML=items.map(function(t,i){return '<li><label for="ck'+i+'"><input type="checkbox" id="ck'+i+'"'+(ticked[i]?' checked':'')+'><span>'+t+'</span></label></li>'}).join('');
  $('check').addEventListener('change',function(e){var i=+e.target.id.slice(2);ticked[i]=e.target.checked;store('vx-check',ticked)});

})();
