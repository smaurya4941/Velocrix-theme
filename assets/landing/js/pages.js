/* Velocrix animated pages: small additions made in WordPress (the original scripts stay unchanged in behaviour).
   - section rail (desktop dots, shows the current section)
   - back-to-top button with scroll-progress ring
   - "See this bat and stance in 3D" (Kit & Bat Size page) carries the chosen height to the Stance Studio page
   - old links to Training Lab tools are forwarded to the tool's own page
*/
(function(){
  'use strict';
  var d=document, reduce=window.matchMedia&&matchMedia('(prefers-reduced-motion: reduce)').matches;
  var $=function(id){return d.getElementById(id)};

  /* ---- Training Lab: old links (/training-lab/#play, /training/#level ...) go to the tool's own page ----
     window.VX_LAB_MOVED (hash => URL) is printed by vx_landing_assets() on the Training and Training Lab pages. */
  var moved=window.VX_LAB_MOVED;
  var forward=function(){
    var hash=location.hash.slice(1);
    if(!moved||!hash||!moved[hash]||$(hash))return false;
    var to=moved[hash].split('#');
    location.replace(to[0]+location.search+'#'+(to[1]||hash));
    return true;
  };
  if(forward())return;
  if(moved)addEventListener('hashchange',forward); // same-page links such as /training-lab/#play clicked on the hub

  /* ---- section rail ---- */
  var secs=[].slice.call(d.querySelectorAll('main > section')).filter(function(s){return s.querySelector('h1,h2')&&s.offsetHeight>200});
  if(secs.length>2){
    var rail=d.createElement('nav');rail.className='vx-rail';rail.setAttribute('aria-label','Sections on this page');
    var dots=secs.map(function(s,i){
      if(!s.id)s.id='sec-'+(i+1);
      var h=s.querySelector('h1,h2'),t=(h.textContent||'').replace(/\s+/g,' ').trim();
      var a=d.createElement('a');a.href='#'+s.id;a.innerHTML='<span></span>';a.firstChild.textContent=t.length>42?t.slice(0,40)+'…':t;a.setAttribute('aria-label',t);
      rail.appendChild(a);return a;
    });
    d.body.appendChild(rail);
    var onRail=function(){
      var mid=innerHeight*.4,cur=0;
      secs.forEach(function(s,i){if(s.getBoundingClientRect().top<mid)cur=i});
      dots.forEach(function(a,i){a.classList.toggle('on',i===cur)});
      rail.classList.toggle('show',scrollY>innerHeight*.6);
    };
    addEventListener('scroll',onRail,{passive:true});onRail();
  }

  /* ---- back to top ---- */
  var tt=d.createElement('button');tt.type='button';tt.className='vx-totop';tt.setAttribute('aria-label','Back to top');
  tt.innerHTML='<svg class="ring" viewBox="0 0 46 46" aria-hidden="true"><circle cx="23" cy="23" r="22"/></svg><svg aria-hidden="true"><use href="#i-right"/></svg>';
  d.body.appendChild(tt);
  tt.addEventListener('click',function(){scrollTo({top:0,behavior:reduce?'auto':'smooth'})});
  addEventListener('scroll',function(){
    var h=d.documentElement.scrollHeight-innerHeight;
    tt.classList.toggle('show',scrollY>innerHeight*1.2);
    tt.style.setProperty('--p',h>0?Math.min(1,scrollY/h).toFixed(4):0);
  },{passive:true});

  /* ---- Home hero: live "Training today / Next session" chip (India time; days = Mon, Wed, Fri, Sat) ---- */
  var live=$('vxLive');
  if(live){
    var days=['Sun','Mon','Tue','Wed','Thu','Fri','Sat'],full=['Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'],train=[1,3,5,6],dow=-1;
    try{dow=days.indexOf(new Date().toLocaleString('en-US',{timeZone:'Asia/Kolkata',weekday:'short'}))}catch(e){}
    if(dow<0)dow=new Date().getDay();
    var sp=live.querySelector('span');
    if(train.indexOf(dow)>=0){live.classList.add('on');sp.textContent='Training today'}
    else{var nx=dow;do{nx=(nx+1)%7}while(train.indexOf(nx)<0);sp.textContent='Next session: '+full[nx]}
  }

  /* ---- About "who": big paragraph lights up word by word while it scrolls through the screen ---- */
  [].forEach.call(d.querySelectorAll('[data-words]'),function(p){
    var words=p.textContent.trim().split(/\s+/);
    p.textContent='';
    var spans=words.map(function(w,i){var s=d.createElement('span');s.textContent=w;p.appendChild(s);if(i<words.length-1)p.appendChild(d.createTextNode(' '));return s});
    if(reduce){spans.forEach(function(s){s.classList.add('lit')});return}
    var tick=function(){
      var r=p.getBoundingClientRect(),start=innerHeight*.85,end=innerHeight*.35;
      var k=Math.max(0,Math.min(1,(start-r.top)/((start-end)+r.height*.6)));
      var n=Math.round(k*spans.length);
      spans.forEach(function(s,i){s.classList.toggle('lit',i<n)});
    };
    addEventListener('scroll',tick,{passive:true});addEventListener('resize',tick);tick();
  });

  /* ---- tabs helper (Vision/Mission, Pillars): click, arrow keys, optional auto-advance ---- */
  function tabs(list,opts){
    var btns=[].slice.call(list.querySelectorAll('[role=tab]')),cur=0,timer=null,stopped=false;
    function show(i,focus){
      cur=(i+btns.length)%btns.length;
      btns.forEach(function(b,k){var on=k===cur;b.setAttribute('aria-selected',on);b.tabIndex=on?0:-1;var p=$(b.getAttribute('aria-controls'));if(p){p.hidden=!on;if(on){p.classList.remove('enter');void p.offsetWidth;p.classList.add('enter')}}});
      if(focus)btns[cur].focus();
      if(opts&&opts.onShow)opts.onShow(cur,btns[cur]);
    }
    function stop(){stopped=true;clearInterval(timer);list.classList.add('manual')}
    btns.forEach(function(b,i){b.addEventListener('click',function(){stop();show(i)})});
    list.addEventListener('keydown',function(e){var m={ArrowDown:1,ArrowRight:1,ArrowUp:-1,ArrowLeft:-1}[e.key];if(m){e.preventDefault();stop();show(cur+m,true)}});
    if(opts&&opts.auto&&!reduce&&'IntersectionObserver' in window){
      list.style.setProperty('--dur',opts.auto/1000+'s');
      var io=new IntersectionObserver(function(es){es.forEach(function(e){clearInterval(timer);if(e.isIntersecting&&!stopped){list.classList.add('running');show(cur);timer=setInterval(function(){show(cur+1)},opts.auto)}else list.classList.remove('running')})},{threshold:.35});
      io.observe(list);
      list.addEventListener('mouseenter',function(){if(!stopped){clearInterval(timer);list.classList.remove('running')}});
      list.addEventListener('mouseleave',function(){if(!stopped){list.classList.add('running');show(cur);timer=setInterval(function(){show(cur+1)},opts.auto)}});
    }
    show(0);
  }
  var vm=d.querySelector('.vm-tabs');
  if(vm)tabs(vm,{onShow:function(i,b){
    var key=b.id.replace('vmt-','');
    [].forEach.call(d.querySelectorAll('.vm-photos img'),function(im){im.classList.toggle('on',im.dataset.tab===key)});
    var ind=vm.querySelector('.vm-ind');if(ind){ind.style.width=b.offsetWidth+'px';ind.style.transform='translateX('+b.offsetLeft+'px)'}
  }});
  [].forEach.call(d.querySelectorAll('[data-pillars] .pl-list'),function(l){tabs(l,{auto:5000,onShow:function(i,b){
    // mobile: the list scrolls sideways; keep the active pillar visible (horizontal only, never moves the page)
    if(l.scrollWidth>l.clientWidth+4)l.scrollTo({left:Math.max(0,b.offsetLeft-16),behavior:reduce?'auto':'smooth'});
  }})});

  /* ---- Training page: bat height travels to the Stance Studio ---- */
  var k=$('kitTo3d'),hg=$('hgt');
  if(k&&hg&&k.href.indexOf('#')>0&&k.href.indexOf(location.pathname)<0){
    var base=k.href.split('#')[0].split('?')[0];
    var upd=function(){k.href=base+'?h='+encodeURIComponent(hg.value)+'#lab-stance'};
    hg.addEventListener('input',upd);upd();
  }
  /* ---- Training Lab: apply ?h= once the Stance Studio has started ---- */
  var m=/[?&]h=(\d{2,3})/.exec(location.search),st=$('stHeight');
  if(m&&st){
    var v=Math.max(+st.min||105,Math.min(+st.max||190,+m[1])),n=0;
    var apply=function(){st.value=v;st.dispatchEvent(new Event('input'))};
    var iv=setInterval(function(){apply();if(++n>12)clearInterval(iv)},700); // the 3D scene starts lazily; re-apply until it listens
    st.addEventListener('pointerdown',function(){clearInterval(iv)},{once:true});
  }
})();

/* Performance: pause the CSS animations of sections that are off screen (.vx-off in type.css),
   so tickers, spinners and pulses do not keep the phone busy while nobody can see them. */
(function(){
  if (!('IntersectionObserver' in window)) return;
  var els = document.querySelectorAll('main > section, main > div, .marquee, .pt-sec, .site-footer, footer');
  if (!els.length) return;
  var io = new IntersectionObserver(function(es){
    es.forEach(function(e){ e.target.classList.toggle('vx-off', !e.isIntersecting); });
  }, {rootMargin: '120px 0px'});
  Array.prototype.forEach.call(els, function(el){ io.observe(el); });
})();
