(function(){
"use strict";
if (typeof THREE === 'undefined'){
  ['#storyCanvas','#simCanvas','#stCanvas','#facCanvas','#gameCanvas'].forEach(s => { const c = document.querySelector(s); if (c && c.parentElement) c.parentElement.insertAdjacentHTML('beforeend','<p class="nogl">The 3D view could not load. Check your connection and refresh.</p>'); });
  const h = document.getElementById('storyHud'); if (h) h.style.opacity = 1;
  return;
}
/* =========================================================
   CORE — config, helpers, 3D engine, shared builders
   ========================================================= */
const CONFIG = {
  whatsapp: '918796447595',
  instagram: 'https://www.instagram.com/velocrixofficial/',
  mapsQuery: 'Sarvottam International School Sector 10 Greater Noida West'
};

const $ = (s, r=document) => r.querySelector(s);
const $$ = (s, r=document) => Array.from(r.querySelectorAll(s));
const clamp = (v,a,b) => Math.max(a, Math.min(b, v));
const lerp = (a,b,t) => a + (b-a)*t;
const smooth = t => t*t*(3-2*t);
const ease = t => t<.5 ? 4*t*t*t : 1-Math.pow(-2*t+2,3)/2;
const DEG = Math.PI/180;
const reduced = matchMedia('(prefers-reduced-motion: reduce)').matches;
const finePointer = matchMedia('(hover: hover) and (pointer: fine)').matches;
const store = {
  get(k,d){ try{ const v = localStorage.getItem(k); return v ? JSON.parse(v) : d; }catch(e){ return d; } },
  set(k,v){ try{ localStorage.setItem(k, JSON.stringify(v)); }catch(e){} },
  del(k){ try{ localStorage.removeItem(k); }catch(e){} }
};
function toast(msg){ const t=$('#toast'); if(!t) return; t.textContent=msg; t.classList.add('show'); clearTimeout(toast._t); toast._t=setTimeout(()=>t.classList.remove('show'),2400); }
function waLink(text){ return 'https://wa.me/' + CONFIG.whatsapp + (text ? '?text=' + encodeURIComponent(text) : ''); }
function fillRange(el){ const p=(el.value-el.min)/(el.max-el.min)*100; el.style.setProperty('--p', p+'%'); }
async function copyText(text, fallbackEl){
  try{ await navigator.clipboard.writeText(text); toast('Message copied'); }
  catch(e){ if(fallbackEl){ const r=document.createRange(); r.selectNodeContents(fallbackEl); const s=getSelection(); s.removeAllRanges(); s.addRange(r); } toast('Press Ctrl+C to copy'); }
}
const hasGL = (function(){ try{ if(typeof THREE==='undefined') return false; const c=document.createElement('canvas'); return !!(window.WebGLRenderingContext && (c.getContext('webgl')||c.getContext('experimental-webgl'))); }catch(e){ return false; } })();
const lowPower = (navigator.hardwareConcurrency||8) <= 4 || (/Android|iPhone/i.test(navigator.userAgent) && innerWidth < 500);
const APP = { current:null };

/* ---------------- render loop ---------------- */
const scenes = [];
function makeRenderer(canvas, shadows){
  const r = new THREE.WebGLRenderer({canvas, antialias:true, alpha:true, powerPreference:'high-performance'});
  r.setPixelRatio(Math.min(window.devicePixelRatio||1, lowPower ? 1.3 : (innerWidth < 700 ? 1.6 : 2)));
  r.outputEncoding = THREE.sRGBEncoding;
  r.toneMapping = THREE.ACESFilmicToneMapping;
  r.toneMappingExposure = 1.0;
  r.setClearColor(0x000000, 0);
  r.physicallyCorrectLights = false;
  if (shadows){ r.shadowMap.enabled = true; r.shadowMap.type = THREE.PCFSoftShadowMap; }
  return r;
}
function addScene(o){
  o.visible = false;
  new IntersectionObserver(es => { o.visible = es[0].isIntersecting; }, {rootMargin:'160px'}).observe(o.canvas);
  const rs = () => {
    const w = o.canvas.clientWidth, h = o.canvas.clientHeight; if(!w || !h) return;
    o.renderer.setSize(w, h, false); o.camera.aspect = w/h;
    if (o.baseFov) o.camera.fov = w/h < 1 ? clamp(o.baseFov/Math.pow(w/h, 0.75), o.baseFov, 64) : o.baseFov;
    o.camera.updateProjectionMatrix();
    o.onResize && o.onResize(w,h);
  };
  if ('ResizeObserver' in window) new ResizeObserver(rs).observe(o.canvas); else window.addEventListener('resize', rs);
  rs();
  scenes.push(o);
  return o;
}
let lastT = performance.now();
function loop(now){
  const dt = Math.min(0.05, (now - lastT)/1000); lastT = now;
  for (const o of scenes){
    if (!o.visible) continue;
    try{ o.update && o.update(dt, now/1000); o.renderer.render(o.scene, o.camera); }catch(e){ console.error(e); o.visible=false; }
  }
  requestAnimationFrame(loop);
}
if (hasGL) requestAnimationFrame(loop);

/* ---------------- canvas textures ---------------- */
function mkCanvas(w,h){ const c=document.createElement('canvas'); c.width=w; c.height=h; return c; }
function speckle(ctx, w, h, amt){
  const img = ctx.getImageData(0,0,w,h), d = img.data;
  for (let i=0;i<d.length;i+=4){ const n=(Math.random()-0.5)*amt*255; d[i]=clamp(d[i]+n,0,255); d[i+1]=clamp(d[i+1]+n,0,255); d[i+2]=clamp(d[i+2]+n,0,255); }
  ctx.putImageData(img,0,0);
}
function tex(c, rep, srgb){ const t = new THREE.CanvasTexture(c); if (srgb !== false) t.encoding = THREE.sRGBEncoding; t.anisotropy = 8; if(rep){ t.wrapS=t.wrapT=THREE.RepeatWrapping; t.repeat.set(rep[0],rep[1]); } return t; }

let _ballTex = null;
function ballTextures(){
  if (_ballTex) return _ballTex;
  const W=2048, H=1024;
  const c = mkCanvas(W,H), x = c.getContext('2d');
  const b = mkCanvas(W,H), bx = b.getContext('2d');
  const g = x.createLinearGradient(0,0,0,H);
  g.addColorStop(0,'#C41B31'); g.addColorStop(.5,'#B0132A'); g.addColorStop(1,'#C41B31');
  x.fillStyle = g; x.fillRect(0,0,W,H);
  for (let i=0;i<9000;i++){ x.fillStyle = Math.random()<.5 ? 'rgba(90,0,12,.10)' : 'rgba(255,120,130,.07)'; const r = Math.random()*3+1; x.fillRect(Math.random()*W, Math.random()*H, r, r); }
  speckle(x,W,H,0.06);
  bx.fillStyle = '#808080'; bx.fillRect(0,0,W,H); speckle(bx,W,H,0.10);
  const quarter = (u, v0, v1) => {
    const px = u*W;
    x.strokeStyle='rgba(60,0,8,.55)'; x.lineWidth=3; x.beginPath(); x.moveTo(px,v0*H); x.lineTo(px,v1*H); x.stroke();
    bx.strokeStyle='#3a3a3a'; bx.lineWidth=5; bx.beginPath(); bx.moveTo(px,v0*H); bx.lineTo(px,v1*H); bx.stroke();
    for (let y=v0*H+14; y<v1*H-14; y+=18){ x.fillStyle='rgba(240,215,190,.28)'; x.fillRect(px-11,y,5,7); x.fillRect(px+6,y,5,7); }
  };
  [[.25,0,.47],[.75,0,.47],[0.002,.53,1],[.5,.53,1],[.998,.53,1]].forEach(a=>quarter(a[0],a[1],a[2]));
  const cy = H/2;
  x.fillStyle = '#9A0E22'; x.fillRect(0,cy-58,W,116);
  bx.fillStyle = '#B8B8B8'; bx.fillRect(0,cy-58,W,116);
  x.fillStyle = 'rgba(40,0,6,.5)'; x.fillRect(0,cy-3,W,6);
  bx.fillStyle = '#404040'; bx.fillRect(0,cy-4,W,8);
  [-48,-30,-12,12,30,48].forEach((o,ri) => {
    for (let u=(ri%2)*9; u<W+18; u+=18){
      x.save(); x.translate(u,cy+o); x.rotate(o<0?-.55:.55);
      x.fillStyle='#FBF5EA'; x.fillRect(-7.5,-3.4,15,6.8); x.fillStyle='rgba(160,140,120,.5)'; x.fillRect(-7.5,1.6,15,1.8); x.restore();
      bx.save(); bx.translate(u,cy+o); bx.rotate(o<0?-.55:.55); bx.fillStyle='#FFFFFF'; bx.fillRect(-7.5,-3.8,15,7.6); bx.restore();
    }
  });
  x.save(); x.translate(W*.5, H*.29); x.scale(1,1.35);
  const gg = x.createLinearGradient(-150,0,150,0); gg.addColorStop(0,'#E9C46A'); gg.addColorStop(.5,'#FFF0B8'); gg.addColorStop(1,'#D9A93C');
  x.fillStyle = gg; x.textAlign='center';
  x.font = 'italic 700 74px "Playfair Display", Georgia, serif'; x.fillText('Velocrix',0,0);
  x.font = '600 26px Arial, sans-serif'; x.fillText('CRICKET ACADEMY · 156 g',0,40); x.restore();
  bx.save(); bx.translate(W*.5, H*.29); bx.scale(1,1.35); bx.fillStyle='#5a5a5a'; bx.textAlign='center'; bx.font='800 76px Arial'; bx.fillText('VELOCRIX',0,0); bx.restore();
  _ballTex = {map: tex(c), bump: new THREE.CanvasTexture(b)};
  return _ballTex;
}
function makeBall(radius, opts){
  const {map,bump} = ballTextures();
  const mat = new THREE.MeshPhysicalMaterial({map, bumpMap:bump, bumpScale:radius*14, roughness:0.36, metalness:0, clearcoat:0.85, clearcoatRoughness:0.22});
  const mesh = new THREE.Mesh(new THREE.SphereGeometry(radius, 96, 64), mat);
  mesh.rotation.z = Math.PI/2;
  mesh.castShadow = true;
  const spin = new THREE.Group(); spin.add(mesh);
  const outer = new THREE.Group(); outer.add(spin);
  outer.userData.spin = spin;
  return outer;
}
function grassTexture(){
  const S = 1024, c = mkCanvas(S,S), x = c.getContext('2d');
  x.fillStyle = '#4C9A3E'; x.fillRect(0,0,S,S);
  x.fillStyle = '#5DAD4B'; x.fillRect(0,0,S/2,S);
  for (let i=0;i<26000;i++){
    const px = Math.random()*S, py = Math.random()*S;
    x.strokeStyle = Math.random()<.5 ? 'rgba(28,92,30,.16)' : 'rgba(176,230,128,.13)';
    x.lineWidth = 1; x.beginPath(); x.moveTo(px,py); x.lineTo(px+(Math.random()-.5)*3, py-3-Math.random()*4); x.stroke();
  }
  for (let i=0;i<60;i++){ const rg = x.createRadialGradient(0,0,0,0,0,60); const px=Math.random()*S, py=Math.random()*S; x.save(); x.translate(px,py); rg.addColorStop(0,Math.random()<.5?'rgba(30,80,20,.07)':'rgba(200,240,150,.06)'); rg.addColorStop(1,'rgba(0,0,0,0)'); x.fillStyle=rg; x.fillRect(-60,-60,120,120); x.restore(); }
  speckle(x,S,S,0.05);
  return c;
}
function clayTexture(){
  const W=512, H=2048, c=mkCanvas(W,H), x=c.getContext('2d');
  const g = x.createLinearGradient(0,0,W,0);
  g.addColorStop(0,'#BFA46F'); g.addColorStop(.1,'#D7BC88'); g.addColorStop(.5,'#E2C995'); g.addColorStop(.9,'#D7BC88'); g.addColorStop(1,'#BFA46F');
  x.fillStyle = g; x.fillRect(0,0,W,H);
  for (let i=0;i<9000;i++){ x.fillStyle = Math.random()<.5 ? 'rgba(120,90,45,.10)' : 'rgba(255,245,215,.10)'; x.fillRect(Math.random()*W, Math.random()*H, 2, 2); }
  speckle(x,W,H,0.07);
  const patch = (cy, rx, ry, a) => { x.save(); x.translate(W/2, cy); x.scale(rx/ry, 1); const rg = x.createRadialGradient(0,0,2,0,0,ry); rg.addColorStop(0,'rgba(140,105,55,'+a+')'); rg.addColorStop(1,'rgba(140,105,55,0)'); x.fillStyle=rg; x.beginPath(); x.arc(0,0,ry,0,7); x.fill(); x.restore(); };
  patch(150,180,160,.32); patch(H-150,180,160,.32); patch(H*0.7,120,180,.16); patch(H*0.3,120,180,.16);
  x.strokeStyle='rgba(110,82,40,.32)'; x.lineWidth=1.2;
  for (let i=0;i<70;i++){ let px=Math.random()*W, py=Math.random()*H; x.beginPath(); x.moveTo(px,py); for(let k=0;k<6;k++){ px+= (Math.random()-.5)*40; py+=(Math.random()-.5)*40; x.lineTo(px,py);} x.stroke(); }
  return c;
}
function textSprite(text, o){
  o = Object.assign({size:44, color:'#0B1D15', bg:'rgba(255,255,255,.95)', weight:700, font:'"Jost", Arial, sans-serif', h:0.25, pad:18, depthTest:true}, o||{});
  const m = mkCanvas(8,8).getContext('2d'); m.font = o.weight+' '+o.size+'px '+o.font;
  const w = Math.ceil(m.measureText(text).width) + o.pad*2, hh = Math.round(o.size + o.pad*1.15);
  const c = mkCanvas(w, hh), x = c.getContext('2d');
  if (o.bg){ x.fillStyle = o.bg; const r=hh/2; x.beginPath(); x.moveTo(r,0); x.arcTo(w,0,w,hh,r); x.arcTo(w,hh,0,hh,r); x.arcTo(0,hh,0,0,r); x.arcTo(0,0,w,0,r); x.fill(); }
  x.font = o.weight+' '+o.size+'px '+o.font; x.fillStyle=o.color; x.textBaseline='middle'; x.textAlign='center'; x.fillText(text, w/2, hh/2+1);
  const s = new THREE.Sprite(new THREE.SpriteMaterial({map:tex(c), transparent:true, depthWrite:false, depthTest:o.depthTest}));
  s.scale.set(o.h*w/hh, o.h, 1);
  s.renderOrder = 10;
  return s;
}
function setSpriteText(sprite, text, o){
  const n = textSprite(text, o);
  sprite.material.map.dispose(); sprite.material.map = n.material.map; sprite.material.needsUpdate = true; sprite.scale.copy(n.scale);
}

/* ---------------- sky + environment ---------------- */
function skyDome(radius, top, horizon, ground){
  const geo = new THREE.SphereGeometry(radius, 48, 24);
  const mat = new THREE.ShaderMaterial({
    side: THREE.BackSide, depthWrite:false, fog:false,
    uniforms:{ top:{value:new THREE.Color(top)}, hor:{value:new THREE.Color(horizon)}, gnd:{value:new THREE.Color(ground)}, sun:{value:new THREE.Vector3(-0.45,0.62,0.4).normalize()} },
    vertexShader:'varying vec3 vP; void main(){ vP = normalize(position); gl_Position = projectionMatrix*modelViewMatrix*vec4(position,1.0); }',
    fragmentShader:'uniform vec3 top; uniform vec3 hor; uniform vec3 gnd; uniform vec3 sun; varying vec3 vP;'+
      'void main(){ float h = vP.y; vec3 c = h>0.0 ? mix(hor, top, pow(clamp(h,0.0,1.0)+0.0001,0.55)) : mix(hor, gnd, clamp(-h*6.0,0.0,1.0));'+
      'float s = clamp(dot(normalize(vP), sun),0.0,1.0)+0.0001; c += vec3(1.0,0.9,0.7)*pow(s,40.0)*0.6 + vec3(1.0,0.94,0.8)*pow(s,5.0)*0.16;'+
      'gl_FragColor = vec4(c,1.0); }'
  });
  const m = new THREE.Mesh(geo, mat); m.renderOrder = -10; m.frustumCulled = false;
  return m;
}
const _envCache = new WeakMap();
function softwareGL(renderer){ try{ const gl = renderer.getContext(), ext = gl.getExtension('WEBGL_debug_renderer_info'); const r = ext ? gl.getParameter(ext.UNMASKED_RENDERER_WEBGL) : ''; return /swiftshader|llvmpipe|software/i.test(r); }catch(e){ return false; } }
function skyEnvironment(renderer){
  if (softwareGL(renderer)) return null;
  if (_envCache.has(renderer)) return _envCache.get(renderer);
  const pm = new THREE.PMREMGenerator(renderer);
  const s = new THREE.Scene();
  s.add(skyDome(50, 0x7DB8EE, 0xF4F7F2, 0x5E9A4C));
  const sun = new THREE.Mesh(new THREE.SphereGeometry(3, 16, 8), new THREE.MeshBasicMaterial({color:0xFFFFFF}));
  sun.material.color.setScalar(14); sun.position.set(-20, 27, 17); s.add(sun);
  const env = pm.fromScene(s, 0.03).texture;
  pm.dispose();
  _envCache.set(renderer, env);
  return env;
}
function studioEnvironment(renderer){
  return null;
  const pm = new THREE.PMREMGenerator(renderer);
  const env = THREE.RoomEnvironment ? pm.fromScene(new THREE.RoomEnvironment(), 0.04).texture : skyEnvironment(renderer);
  pm.dispose(); return env;
}
function outdoorLights(scene, shadowSize, mapSize){
  scene.add(new THREE.HemisphereLight(0xEAF2FF, 0x5E7F48, 0.62));
  scene.add(new THREE.AmbientLight(0xFFF6E8, 0.08));
  const sun = new THREE.DirectionalLight(0xFFEBCC, 1.9);
  sun.position.set(-8, 14, 7);
  if (shadowSize){
    sun.castShadow = true; const ms = mapSize || (lowPower ? 1024 : 2048); sun.shadow.mapSize.set(ms, ms);
    const c = sun.shadow.camera; c.left=-shadowSize; c.right=shadowSize; c.top=shadowSize; c.bottom=-shadowSize; c.near=1; c.far=70;
    sun.shadow.bias = -0.0003; sun.shadow.normalBias = 0.02; sun.shadow.radius = 4;
  }
  scene.add(sun); scene.add(sun.target);
  return sun;
}

/* ---------------- ground builders ---------------- */
const PITCH = { half:10.06, pop:1.22, width:3.05, stumpH:0.711, stumpHalf:0.1143, ballR:0.036 };
let _stumpMat = null;
function stumpMaterial(){
  if (_stumpMat) return _stumpMat;
  const c = mkCanvas(64, 512), x = c.getContext('2d');
  const g = x.createLinearGradient(0,0,64,0); g.addColorStop(0,'#E9DCC0'); g.addColorStop(.5,'#FBF4E4'); g.addColorStop(1,'#E2D2B2'); x.fillStyle=g; x.fillRect(0,0,64,512);
  x.fillStyle = '#C8102E'; x.fillRect(0,40,64,26); x.fillRect(0,90,64,10);
  x.fillStyle = 'rgba(160,120,70,.18)'; for (let i=0;i<14;i++) x.fillRect(4+i*4,0,1,512);
  _stumpMat = new THREE.MeshPhysicalMaterial({map:tex(c), roughness:.42, clearcoat:.5, clearcoatRoughness:.3});
  return _stumpMat;
}
function stumpSet(){
  const g = new THREE.Group();
  const mat = stumpMaterial();
  const geo = new THREE.CylinderGeometry(0.0175, 0.0175, PITCH.stumpH, 20); geo.translate(0, PITCH.stumpH/2, 0);
  const stumps = [-0.0968, 0, 0.0968].map(xx => { const m = new THREE.Mesh(geo, mat); m.position.x = xx; m.castShadow = true; m.receiveShadow = true; g.add(m); return m; });
  const bgeo = new THREE.CylinderGeometry(0.0085, 0.0085, 0.109, 12); bgeo.rotateZ(Math.PI/2);
  const bails = [-0.0484, 0.0484].map(xx => { const m = new THREE.Mesh(bgeo, mat); m.position.set(xx, PITCH.stumpH + 0.009, 0); m.castShadow = true; g.add(m); return m; });
  bails.forEach(b => b.userData.home = b.position.clone());
  return {group:g, stumps, bails};
}
function line3(w, len, x, z){
  const m = new THREE.Mesh(new THREE.PlaneGeometry(w, len), new THREE.MeshStandardMaterial({color:0xFFFFFF, roughness:.8}));
  m.rotation.x = -Math.PI/2; m.position.set(x, 0.013, z); m.receiveShadow = true; return m;
}
function addCreases(parent, zStump, dir){
  const zp = zStump - dir*PITCH.pop;
  parent.add(line3(2.64, 0.05, 0, zStump));
  parent.add(line3(3.66, 0.05, 0, zp));
  [-1.32, 1.32].forEach(xx => parent.add(line3(0.05, 2.44, xx, (zp + zStump + dir*1.22) / 2)));
}
let _clayTex = null;
function buildMachine(parent, x, z){
  const mach = new THREE.Group(); mach.position.set(x, 0, z); parent.add(mach);
  const body = new THREE.MeshPhysicalMaterial({color:0x0B3323, roughness:.35, clearcoat:.8}), steel = new THREE.MeshStandardMaterial({color:0xC9A251, metalness:.7, roughness:.3}), dark = new THREE.MeshStandardMaterial({color:0x1A1F1C, roughness:.8});
  [[0.5,0.45],[-0.5,0.45],[0,-0.6]].forEach(l => { const leg = new THREE.Mesh(new THREE.CylinderGeometry(0.03,0.03,1.7,8), steel); leg.position.set(l[0]*0.6, 0.8, l[1]*0.6); leg.lookAt(0, 1.75, 0); leg.rotateX(Math.PI/2); leg.castShadow = true; mach.add(leg); });
  const box = new THREE.Mesh(new THREE.BoxGeometry(0.62,0.42,0.52), body); box.position.y = 1.78; box.castShadow = true; mach.add(box);
  [-0.2,0.2].forEach(xx => { const w = new THREE.Mesh(new THREE.CylinderGeometry(0.22,0.22,0.09,28), dark); w.rotation.z = Math.PI/2; w.position.set(xx, 2.02, 0.12); w.castShadow = true; mach.add(w); w.userData.wheel = true; });
  const chute = new THREE.Mesh(new THREE.CylinderGeometry(0.07,0.09,0.5,16), steel); chute.rotation.x = Math.PI/2.2; chute.position.set(0, 2.05, 0.4); mach.add(chute);
  const hop = new THREE.Mesh(new THREE.CylinderGeometry(0.22,0.12,0.3,20,1,true), body); hop.position.set(0, 2.32, -0.12); mach.add(hop);
  const badge = textSprite('Velocrix', {size:44, h:0.13, color:'#D9BC72', bg:'rgba(11,51,35,.95)', font:'"Playfair Display", Georgia, serif', weight:'italic 700'}); badge.position.set(0, 1.5, 0.3); mach.add(badge);
  return mach;
}
function buildPitch(parent){
  if (!_clayTex) _clayTex = tex(clayTexture());
  const pitch = new THREE.Mesh(new THREE.PlaneGeometry(PITCH.width, 22.4), new THREE.MeshStandardMaterial({map:_clayTex, roughness:0.95}));
  pitch.rotation.x = -Math.PI/2; pitch.position.y = 0.006; pitch.receiveShadow = true;
  parent.add(pitch);
  addCreases(parent, PITCH.half, 1); addCreases(parent, -PITCH.half, -1);
  const bat = stumpSet(); bat.group.position.z = PITCH.half; parent.add(bat.group);
  const bowl = stumpSet(); bowl.group.position.z = -PITCH.half; parent.add(bowl.group);
  return {pitch, bat, bowl};
}
let _grassC = null;
function buildGround(parent, radius, rep){
  if (!_grassC) _grassC = grassTexture();
  const t = tex(_grassC, [rep, rep]);
  const g = new THREE.Mesh(new THREE.CircleGeometry(radius, 128), new THREE.MeshStandardMaterial({map:t, roughness:1, envMapIntensity:.6}));
  g.rotation.x = -Math.PI/2; g.receiveShadow = true; parent.add(g);
  return g;
}
function boards(parent, r){
  const c = mkCanvas(2048,96), x = c.getContext('2d');
  for (let i=0;i<8;i++){ x.fillStyle = i%2 ? '#F7F1E3' : '#0B3323'; x.fillRect(i*256,0,256,96); x.fillStyle = i%2 ? '#0B3323':'#D9BC72'; x.font='italic 700 34px "Playfair Display", Georgia, serif'; x.textAlign='center'; x.textBaseline='middle'; x.fillText(i%2?'Velocrix':'Cricket Academy',i*256+128,50); }
  const t = tex(c, [-8,1]);
  const m = new THREE.Mesh(new THREE.CylinderGeometry(r, r, 1.1, 160, 1, true), new THREE.MeshStandardMaterial({map:t, side:THREE.BackSide, roughness:.7}));
  m.position.y = 0.55; parent.add(m);
}
function skyline(parent, r0, count){
  const wc = mkCanvas(64,256), wx = wc.getContext('2d');
  wx.fillStyle = '#E9EEF1'; wx.fillRect(0,0,64,256);
  for (let y=6;y<256;y+=12) for (let xx=5;xx<64;xx+=10){ wx.fillStyle = Math.random()<.15 ? 'rgba(255,250,230,.95)' : 'rgba(120,145,165,.55)'; wx.fillRect(xx,y,6,7); }
  const wt = tex(wc, [3,6]);
  const mat = new THREE.MeshStandardMaterial({map:wt, roughness:.8, envMapIntensity:.4});
  const geo = new THREE.BoxGeometry(1,1,1); geo.translate(0,.5,0);
  const inst = new THREE.InstancedMesh(geo, mat, count);
  const m4 = new THREE.Matrix4(), q = new THREE.Quaternion(), v = new THREE.Vector3(), sc = new THREE.Vector3();
  let seed = 7; const rnd = () => (seed = (seed*16807) % 2147483647) / 2147483647;
  for (let i=0;i<count;i++){
    const a = (i/count)*Math.PI*2 + rnd()*0.08, r = r0 + rnd()*70;
    const h = 22 + rnd()*40;
    v.set(Math.cos(a)*r, 0, Math.sin(a)*r); q.setFromAxisAngle(new THREE.Vector3(0,1,0), -a); sc.set(14+rnd()*10, h, 14+rnd()*8);
    m4.compose(v,q,sc); inst.setMatrixAt(i, m4);
  }
  parent.add(inst);
  // tree line
  const tg = new THREE.IcosahedronGeometry(1, 3);
  const tm = new THREE.MeshStandardMaterial({color:0xFFFFFF, roughness:1});
  const tn = 260, trees = new THREE.InstancedMesh(tg, tm, tn); const col = new THREE.Color();
  for (let i=0;i<tn;i++){ const a = (i/tn)*Math.PI*2 + rnd()*0.02, r = Math.max(72, r0*0.42) + rnd()*16, s = 2.2 + rnd()*2.6; v.set(Math.cos(a)*r, s*0.85, Math.sin(a)*r); q.identity(); sc.set(s, s*1.2, s); m4.compose(v,q,sc); trees.setMatrixAt(i, m4); col.setHSL(0.28 + rnd()*0.06, 0.38 + rnd()*0.15, 0.26 + rnd()*0.1); trees.setColorAt(i, col); }
  parent.add(trees);
}
function floodlights(parent, r){
  const mat = new THREE.MeshStandardMaterial({color:0xD3DBD7, roughness:.5, metalness:.3});
  const head = new THREE.MeshStandardMaterial({color:0xFFFFFF, emissive:0xFFFBEA, emissiveIntensity:.7});
  for (let i=0;i<4;i++){
    const a = Math.PI/4 + i*Math.PI/2;
    const g = new THREE.Group();
    const pole = new THREE.Mesh(new THREE.CylinderGeometry(0.35, 0.7, 34, 10), mat); pole.position.y = 17; g.add(pole);
    const h = new THREE.Mesh(new THREE.BoxGeometry(6, 3.4, 0.7), head); h.position.y = 35; h.rotation.x = 0.35; g.add(h);
    g.position.set(Math.cos(a)*r, 0, Math.sin(a)*r); g.lookAt(0,0,0); parent.add(g);
  }
}
function outdoorWorld(scene, renderer, opts){
  opts = opts || {};
  scene.environment = null;
  const dome = skyDome(opts.dome || 380, 0x5E98D6, 0xF7EEDB, 0xD8D9B8); scene.add(dome);
  scene.fog = new THREE.Fog(0xF2ECDD, opts.fogNear || 60, opts.fogFar || 260);
  buildGround(scene, opts.ground || 140, opts.rep || 34);
  const far = new THREE.Mesh(new THREE.CircleGeometry(400, 64), new THREE.MeshStandardMaterial({color:0x8DBB76, roughness:1}));
  far.rotation.x = -Math.PI/2; far.position.y = -0.05; scene.add(far);
  if (opts.boards !== false) boards(scene, opts.boards || 62);
  if (opts.skyline !== false) skyline(scene, opts.skyline || 235, 54);
  if (opts.flood) floodlights(scene, opts.flood);
}

/* ---------------- delivery physics (coaching-grade) ---------------- */
const G = 9.81;
function computeDelivery(o){
  const v = o.speed/3.6, x0 = 0.3, y0 = o.release || 2.0, z0 = -8.9;
  const xb = o.line, zb = PITCH.half - o.len, R = PITCH.ballR;
  const D1 = Math.hypot(xb-x0, zb-z0), t1 = D1/v;
  const S = o.swing/100, ax = 2*S/(t1*t1);
  const vx0 = (xb - x0 - 0.5*ax*t1*t1)/t1, vz0 = (zb - z0)/t1;
  const vy0 = (R - y0 + 0.5*G*t1*t1)/t1;
  const e = o.surf === 'concrete' ? 0.6 : 0.5, k = o.surf === 'concrete' ? 0.93 : 0.88;
  const pts = []; const dt = 0.003;
  for (let t=0; t<t1; t+=dt) pts.push([x0+vx0*t+0.5*ax*t*t, y0+vy0*t-0.5*G*t*t, z0+vz0*t, t]);
  pts.push([xb, R, zb, t1]);
  const straight = (xb - x0)/t1, extra = vx0 + ax*t1 - straight;
  let vx = (straight + 0.35*extra)*k, vy = -(vy0 - G*t1)*e, vz = vz0*k;
  const t2est = (PITCH.half - zb)/vz;
  vx += (o.seam/100)/Math.max(t2est, 0.08);
  let x=xb, y=R, z=zb, t=t1;
  while (z < PITCH.half + 1.6 && t < t1 + 3){
    vy -= G*dt; x += vx*dt; y += vy*dt; z += vz*dt; t += dt;
    if (y < R && vy < 0){ y = R; vy = -vy*e; vz *= k; vx *= k; }
    pts.push([x,y,z,t]);
  }
  const cross = zz => { for (let i=1;i<pts.length;i++){ if (pts[i-1][2] < zz && pts[i][2] >= zz){ const a=pts[i-1], b=pts[i], f=(zz-a[2])/(b[2]-a[2]); return {x:lerp(a[0],b[0],f), y:lerp(a[1],b[1],f), t:lerp(a[3],b[3],f), i, v:Math.hypot(b[0]-a[0],b[1]-a[1],b[2]-a[2])/(b[3]-a[3])}; } } return null; };
  const pop = cross(PITCH.half - PITCH.pop), st = cross(PITCH.half);
  let hit = false, verdict = '', hitIdx = pts.length-1;
  if (st){
    const over = st.y > PITCH.stumpH + R, wide = Math.abs(st.x) > PITCH.stumpHalf + R;
    if (!over && !wide){ hit = true; hitIdx = st.i;
      const which = st.x > 0.05 ? 'off stump' : st.x < -0.05 ? 'leg stump' : 'middle stump';
      verdict = 'Hits ' + which + (st.y > 0.55 ? ', near the top' : st.y < 0.2 ? ', low down' : '');
    } else if (over && !wide) verdict = 'Goes over the stumps by ' + Math.round((st.y - PITCH.stumpH - R)*100) + ' cm';
    else if (st.x > 0) verdict = 'Misses off stump by ' + Math.round((st.x - PITCH.stumpHalf - R)*100) + ' cm';
    else verdict = 'Misses leg stump by ' + Math.round((-st.x - PITCH.stumpHalf - R)*100) + ' cm';
  }
  return {pts: pts.slice(0, hitIdx+1), all: pts, bounce:{x:xb, z:zb}, pop, st, hit, verdict, t1};
}
function samplePath(pts, t){
  if (t <= pts[0][3]) return pts[0];
  let lo = 0, hi = pts.length-1;
  if (t >= pts[hi][3]) return pts[hi];
  while (hi - lo > 1){ const m = (lo+hi)>>1; if (pts[m][3] < t) lo = m; else hi = m; }
  const a = pts[lo], b = pts[hi], f = (t - a[3])/(b[3]-a[3]);
  return [lerp(a[0],b[0],f), lerp(a[1],b[1],f), lerp(a[2],b[2],f), t];
}
function lengthName(L){ return L < 2 ? 'Yorker' : L < 5 ? 'Full' : L < 8 ? 'Good length' : 'Short'; }
function lengthColor(L){ return L < 2 ? 0xD7192F : L < 5 ? 0xD98A00 : L < 8 ? 0x138A43 : 0x2E6BE6; }
function lineName(x){
  if (x < -0.15) return 'Outside leg'; if (x < -0.05) return 'Leg stump'; if (x <= 0.05) return 'Middle stump';
  if (x <= 0.15) return 'Off stump'; if (x <= 0.35) return 'Outside off'; return 'Wide of off';
}

/* ---------------- bat sizes ---------------- */
const BATS = [
  {s:'Size 0', min:0,   len:62.5, age:'Under 5',          ball:'Soft or tennis ball'},
  {s:'Size 1', min:122, len:65.0, age:'4 to 6',           ball:'Soft or tennis ball'},
  {s:'Size 2', min:130, len:67.5, age:'6 to 8',           ball:'Soft or tennis ball'},
  {s:'Size 3', min:137, len:70.0, age:'8 to 10',          ball:'Junior, 133 g'},
  {s:'Size 4', min:145, len:72.5, age:'9 to 11',          ball:'Junior, 133 g'},
  {s:'Size 5', min:150, len:75.0, age:'10 to 12',         ball:'Junior, 133 g'},
  {s:'Size 6', min:157, len:77.5, age:'11 to 13',         ball:'Junior, 133 g'},
  {s:'Harrow', min:165, len:81.0, age:'12 to 14',         ball:'142 g'},
  {s:'Full size (SH)', min:173, len:85.0, age:'Teens and adults', ball:'142 g (girls), 156 g'}
];
function batForHeight(hcm){ let b = BATS[0]; BATS.forEach(x => { if (hcm >= x.min) b = x; }); return b; }
/* =========================================================
   BATTER — procedural player in full kit, IK-driven
   Coordinates (right-hander): stumps at origin, bowler toward -z,
   off side +x. Left-handers are mirrored on x.
   ========================================================= */
const _v1 = new THREE.Vector3(), _v2 = new THREE.Vector3(), _v3 = new THREE.Vector3(), _m4 = new THREE.Matrix4();
const UP = new THREE.Vector3(0,1,0);
function orient(obj, up, fwd){
  const y = _v1.copy(up).normalize();
  let z = _v2.copy(fwd).addScaledVector(y, -fwd.dot(y));
  if (z.lengthSq() < 1e-6) z.set(1,0,0).addScaledVector(y, -y.x);
  z.normalize();
  const x = _v3.crossVectors(y, z).normalize();
  _m4.makeBasis(x, y, z);
  obj.quaternion.setFromRotationMatrix(_m4);
}
function ik2(S, T, a, b, pole, outE, outT){
  const d0 = _v1.subVectors(T, S); let d = d0.length();
  const dir = d0.clone().normalize();
  d = clamp(d, Math.abs(a-b) + 1e-3, a + b - 1e-3);
  const cosA = clamp((a*a + d*d - b*b)/(2*a*d), -1, 1), sinA = Math.sqrt(1 - cosA*cosA);
  const p = pole.clone().addScaledVector(dir, -pole.dot(dir));
  if (p.lengthSq() < 1e-8) p.set(0,1,0).addScaledVector(dir, -dir.y);
  p.normalize();
  outE.copy(S).addScaledVector(dir, a*cosA).addScaledVector(p, a*sinA);
  outT.copy(S).addScaledVector(dir, d);
}
function rotY(v, ang){ const c = Math.cos(ang), s = Math.sin(ang); return new THREE.Vector3(v.x*c + v.z*s, v.y, -v.x*s + v.z*c); }

function makeBatMesh(L){
  if (!makeBatMesh.mats){
    const wc = mkCanvas(256, 1024), wx = wc.getContext('2d');
    const wg = wx.createLinearGradient(0,0,256,0); wg.addColorStop(0,'#E5CC9B'); wg.addColorStop(.5,'#F5E6C3'); wg.addColorStop(1,'#E0C590'); wx.fillStyle = wg; wx.fillRect(0,0,256,1024);
    for (let i=0;i<11;i++){ const x0 = 18 + i*21 + Math.random()*6; wx.strokeStyle = 'rgba(150,110,55,.32)'; wx.lineWidth = 1.3; wx.beginPath(); wx.moveTo(x0,0); for(let y=0;y<=1024;y+=32) wx.lineTo(x0 + Math.sin(y*0.012+i)*2.5, y); wx.stroke(); }
    speckle(wx,256,1024,0.04);
    const gc = mkCanvas(64,256), gx = gc.getContext('2d'); gx.fillStyle = '#C8162D'; gx.fillRect(0,0,64,256);
    for (let y=0;y<256;y+=8){ gx.fillStyle='rgba(0,0,0,.2)'; gx.fillRect(0,y,64,3); gx.fillStyle='rgba(255,255,255,.08)'; gx.fillRect(0,y+4,64,1); }
    const sc = mkCanvas(160,640), sx = sc.getContext('2d');
    sx.fillStyle = '#0A3D24'; sx.fillRect(0,0,160,640); sx.fillStyle = '#D7192F'; sx.fillRect(0,0,160,90); sx.fillRect(0,550,160,90);
    sx.fillStyle = '#E9C46A'; sx.fillRect(0,90,160,6); sx.fillRect(0,544,160,6);
    sx.save(); sx.translate(80,320); sx.rotate(-Math.PI/2); sx.fillStyle='#fff'; sx.font='italic 700 80px "Playfair Display", Georgia, serif'; sx.textAlign='center'; sx.textBaseline='middle'; sx.fillText('Velocrix',0,0); sx.restore();
    makeBatMesh.mats = {
      wood: new THREE.MeshPhysicalMaterial({map:tex(wc), roughness:.5, clearcoat:.4, clearcoatRoughness:.4}),
      grip: new THREE.MeshStandardMaterial({map:tex(gc,[2,6]), roughness:.85}),
      sticker: new THREE.MeshPhysicalMaterial({map:tex(sc), roughness:.45, clearcoat:.6})
    };
  }
  const M = makeBatMesh.mats;
  const blade = L*0.665, handle = L - blade, w = 0.088 + 0.02*clamp((L-0.65)/0.2,0,1);
  const bat = new THREE.Group();
  const sh = new THREE.Shape(); const e = w*0.32, sp = w*0.58;
  sh.moveTo(-w/2, 0); sh.lineTo(w/2, 0); sh.lineTo(w/2, e*0.7); sh.quadraticCurveTo(w*0.42, sp, 0, sp); sh.quadraticCurveTo(-w*0.42, sp, -w/2, e*0.7); sh.lineTo(-w/2, 0);
  const bg = new THREE.ExtrudeGeometry(sh, {depth:blade, bevelEnabled:true, bevelThickness:0.006, bevelSize:0.004, bevelSegments:3, curveSegments:14});
  bg.rotateX(-Math.PI/2);
  const pos = bg.attributes.position, uv = bg.attributes.uv;
  for (let i=0;i<pos.count;i++) uv.setXY(i, (pos.getX(i)/w)+0.5, pos.getY(i)/blade);
  const bm = new THREE.Mesh(bg, M.wood); bm.castShadow = true; bm.receiveShadow = true; bat.add(bm);
  const st = new THREE.Mesh(new THREE.PlaneGeometry(w*0.6, blade*0.4), M.sticker); st.position.set(0, blade*0.64, 0.0066); bat.add(st);
  const hz = -sp*0.45;
  const hg = new THREE.CylinderGeometry(0.0165, 0.0178, handle, 24); hg.translate(0, blade + handle/2, hz);
  const hm = new THREE.Mesh(hg, M.grip); hm.castShadow = true; bat.add(hm);
  const shoulder = new THREE.Mesh(new THREE.CylinderGeometry(0.019, w*0.3, 0.06, 20), M.wood); shoulder.position.set(0, blade+0.024, hz); bat.add(shoulder);
  const knob = new THREE.Mesh(new THREE.SphereGeometry(0.021, 16, 10), M.grip); knob.position.set(0, L+0.004, hz); bat.add(knob);
  bat.userData = {L, handleZ:hz};
  return bat;
}

function createBatter(){
  const root = new THREE.Group();        // mirrored for left-handers
  const body = new THREE.Group(); root.add(body);
  const batHolder = new THREE.Group(); root.add(batHolder);
  // ---- materials ----
  const fab = mkCanvas(128,128), fx = fab.getContext('2d'); fx.fillStyle = '#F5F4EF'; fx.fillRect(0,0,128,128);
  for (let i=0;i<128;i+=2){ fx.fillStyle = 'rgba(0,0,0,.025)'; fx.fillRect(0,i,128,1); fx.fillRect(i,0,1,128); }
  const whites = new THREE.MeshStandardMaterial({map:tex(fab,[3,3]), roughness:.88});
  const skin = new THREE.MeshStandardMaterial({color:0x9E6A47, roughness:.62});
  const pc = mkCanvas(256,128), px = pc.getContext('2d'); px.fillStyle = '#FBFBF7'; px.fillRect(0,0,256,128);
  for (let i=0;i<256;i+=32){ const g = px.createLinearGradient(i,0,i+32,0); g.addColorStop(0,'rgba(0,0,0,.10)'); g.addColorStop(.25,'rgba(0,0,0,0)'); g.addColorStop(.75,'rgba(255,255,255,0)'); g.addColorStop(1,'rgba(0,0,0,.12)'); px.fillStyle = g; px.fillRect(i,0,32,128); }
  const padMat = new THREE.MeshStandardMaterial({map:tex(pc,[1,1]), roughness:.62});
  const strap = new THREE.MeshStandardMaterial({color:0x0A3D24, roughness:.6});
  const helmetMat = new THREE.MeshPhysicalMaterial({color:0x0A3D24, roughness:.32, clearcoat:1, clearcoatRoughness:.12});
  const metal = new THREE.MeshStandardMaterial({color:0xD5DADF, metalness:.9, roughness:.28});
  const gloveMat = new THREE.MeshStandardMaterial({color:0xF7F7F3, roughness:.7});
  const gloveAcc = new THREE.MeshStandardMaterial({color:0x138A43, roughness:.6});
  const sole = new THREE.MeshStandardMaterial({color:0x2C302E, roughness:.9});
  const red = new THREE.MeshStandardMaterial({color:0xD7192F, roughness:.5});
  const shadowy = m => { m.castShadow = true; m.receiveShadow = true; return m; };

  // ---- geometry primitives (unit size, scaled per frame) ----
  const segGeo = taper => { const g = new THREE.CylinderGeometry(taper, 1, 1, 22, 1); g.translate(0,.5,0); return g; };
  const sph = new THREE.SphereGeometry(1, 24, 16);
  const seg = (mat, taper) => { const m = shadowy(new THREE.Mesh(segGeo(taper), mat)); body.add(m); return m; };
  const ball = mat => { const m = shadowy(new THREE.Mesh(sph, mat)); body.add(m); return m; };
  const P = {
    thighL: seg(whites, .78), thighR: seg(whites, .78),
    uArmL: seg(whites, .85), uArmR: seg(whites, .85),
    fArmL: seg(whites, .8), fArmR: seg(whites, .8),
    neck: seg(skin, 1),
    hipL: ball(whites), hipR: ball(whites), kneeL: ball(whites), kneeR: ball(whites),
    shL: ball(whites), shR: ball(whites), elL: ball(whites), elR: ball(whites)
  };
  // torso (lathe)
  const tp = [[0.00,0],[0.78,0],[0.80,0.18],[0.88,0.45],[0.98,0.68],[0.95,0.84],[0.74,0.95],[0.36,1.0],[0,1.01]].map(p => new THREE.Vector2(p[0],p[1]));
  const torsoG = new THREE.Group(); body.add(torsoG);
  const torso = shadowy(new THREE.Mesh(new THREE.LatheGeometry(tp, 32), whites)); torsoG.add(torso);
  const crest = new THREE.Mesh(new THREE.CircleGeometry(1, 24), red); torsoG.add(crest);
  const crestStitch = new THREE.Mesh(new THREE.RingGeometry(0.55, 0.62, 24), new THREE.MeshBasicMaterial({color:0xffffff})); crest.add(crestStitch); crestStitch.position.z = 0.01;
  const collar = shadowy(new THREE.Mesh(new THREE.TorusGeometry(1, 0.32, 10, 24), whites)); collar.rotation.x = Math.PI/2; torsoG.add(collar);
  const pelvisG = new THREE.Group(); body.add(pelvisG);
  const pp = [[0,0.0],[0.74,0.02],[0.9,0.4],[0.82,1.0],[0,1.0]].map(p => new THREE.Vector2(p[0],p[1]));
  const pelvis = shadowy(new THREE.Mesh(new THREE.LatheGeometry(pp, 28), whites)); pelvisG.add(pelvis);
  // head + helmet
  const headG = new THREE.Group(); body.add(headG);
  const head = shadowy(new THREE.Mesh(sph, skin)); headG.add(head);
  const shell = shadowy(new THREE.Mesh(new THREE.SphereGeometry(1, 36, 24, 0, Math.PI*2, 0, Math.PI*0.6), helmetMat)); headG.add(shell);
  const pkG = new THREE.RingGeometry(1.0, 1.32, 32, 1, -Math.PI/2 - 0.95, 1.9); pkG.rotateX(-Math.PI/2);
  const peakMat = helmetMat.clone(); peakMat.side = THREE.DoubleSide;
  const peak = shadowy(new THREE.Mesh(pkG, peakMat)); headG.add(peak);
  const grille = new THREE.Group(); headG.add(grille);
  [0, 1, 2].forEach(i => { const t = new THREE.Mesh(new THREE.TorusGeometry(1, 0.035, 8, 40, Math.PI*0.95), metal); t.rotation.set(Math.PI/2, 0, 0.025*Math.PI); t.userData.i = i; grille.add(t); });
  const gv = new THREE.Mesh(new THREE.CylinderGeometry(0.035, 0.035, 1, 8), metal); grille.add(gv);
  const badge = new THREE.Mesh(new THREE.CircleGeometry(1, 20), red); headG.add(badge);
  // pads
  const padG = () => {
    const g = new THREE.Group(); body.add(g);
    const shellP = shadowy(new THREE.Mesh(new THREE.CylinderGeometry(1, 1.08, 1, 28, 1, false, -1.85, 3.7), padMat)); shellP.geometry.translate(0,.5,0); g.add(shellP);
    shellP.material = padMat.clone(); shellP.material.side = THREE.DoubleSide;
    const roll = shadowy(new THREE.Mesh(new THREE.TorusGeometry(1, 0.28, 12, 28, Math.PI*1.1), padMat)); roll.rotation.set(Math.PI/2, 0, -0.05*Math.PI); g.add(roll);
    const bol = []; for (let i=-1;i<=1;i++){ const b = shadowy(new THREE.Mesh(new THREE.CylinderGeometry(1,1,1,12), padMat)); b.geometry.translate(0,.5,0); b.userData.i = i; g.add(b); bol.push(b); }
    const straps = [0.25, 0.62].map(h => { const s = new THREE.Mesh(new THREE.CylinderGeometry(1.02, 1.02, 1, 24, 1, true, Math.PI*0.6, Math.PI*0.8), strap); s.material = strap; s.userData.h = h; g.add(s); return s; });
    const knee = shadowy(new THREE.Mesh(sph, padMat)); g.add(knee);
    return {g, shellP, roll, bol, straps, knee};
  };
  const padL = padG(), padR = padG();
  // shoes
  const shoeG = () => { const g = new THREE.Group(); body.add(g); const up = shadowy(new THREE.Mesh(sph, gloveMat)); g.add(up); const so = shadowy(new THREE.Mesh(new THREE.BoxGeometry(1,1,1), sole)); g.add(so); const sp = new THREE.Mesh(new THREE.BoxGeometry(1,1,1), gloveAcc); g.add(sp); return {g, up, so, sp}; };
  const shoeL = shoeG(), shoeR = shoeG();
  // gloves
  const gloveG = () => { const g = new THREE.Group(); body.add(g); const palm = shadowy(new THREE.Mesh(sph, gloveMat)); g.add(palm); const cuff = shadowy(new THREE.Mesh(new THREE.CylinderGeometry(1,1,1,18), gloveAcc)); g.add(cuff); const rolls = []; for (let i=0;i<3;i++){ const r = shadowy(new THREE.Mesh(new THREE.CylinderGeometry(1,1,1,12), gloveAcc)); r.rotation.z = Math.PI/2; g.add(r); rolls.push(r); } return {g, palm, cuff, rolls}; };
  const gloveL = gloveG(), gloveR = gloveG();

  let bat = null, batL = 0;
  function setBatLength(L){
    if (bat && Math.abs(batL - L) < 1e-4) return;
    if (bat){ batHolder.remove(bat); bat.traverse(o => o.geometry && o.geometry.dispose()); }
    bat = makeBatMesh(L); batL = L; batHolder.add(bat);
  }

  // ---- dimensions ----
  let H = 1.5, D = {};
  function setHeight(h){
    H = h;
    const headR = 0.083 + (H - 1.2)*0.0127;
    D = { H, headR, ha:0.046*H, t:0.245*H, s:0.243*H, a:0.186*H, b:0.188*H, sh:0.112*H, hip:0.054*H, torso:0.29*H, neck:0.045*H,
      thighR:0.05*H, kneeR:0.036*H, uArmR:0.027*H, elR:0.023*H, fArmR:0.022*H, chestW:0.118*H, chestD:0.075*H, footL:0.15*H };
    // static scales
    P.hipL.scale.setScalar(D.thighR*1.02); P.hipR.scale.setScalar(D.thighR*1.02);
    P.kneeL.scale.setScalar(D.kneeR); P.kneeR.scale.setScalar(D.kneeR);
    P.shL.scale.setScalar(D.uArmR*1.22); P.shR.scale.setScalar(D.uArmR*1.22);
    P.elL.scale.setScalar(D.elR); P.elR.scale.setScalar(D.elR);
    head.scale.set(headR*0.92, headR, headR*0.98);
    shell.scale.setScalar(headR*1.17); shell.position.set(0, headR*0.08, -headR*0.06); shell.rotation.x = -0.42;
    peak.scale.set(headR*1.17, headR*1.17, headR*1.17); peak.position.set(0, headR*0.3, -headR*0.02); peak.rotation.x = 0.12;
    grille.position.set(0, -headR*0.08, 0);
    grille.children.forEach(c => { if (c.userData.i !== undefined){ c.scale.setScalar(headR*1.22); c.position.y = headR*(0.12 - c.userData.i*0.27); } else { c.scale.set(1, headR*0.62, 1); c.position.set(0, -headR*0.12, headR*1.21); } });
    badge.scale.setScalar(headR*0.16); badge.position.set(0, headR*0.62, headR*1.0); badge.rotation.x = -0.6;
    torso.scale.set(D.chestW, D.torso*0.98, D.chestD);
    collar.scale.set(H*0.034, H*0.034, H*0.034); collar.position.set(0, D.torso*0.99, H*0.004);
    crest.scale.setScalar(H*0.016); crest.position.set(-D.chestW*0.42, D.torso*0.74, D.chestD*0.93);
    pelvis.scale.set(D.chestW*0.86, H*0.075, D.chestD*1.05);
    [padL, padR].forEach(p => {
      const R = D.kneeR*1.35, len = D.s*0.94 + D.kneeR*1.2;
      p.shellP.scale.set(R, len, R*1.05); p.shellP.position.set(0, -D.ha*0.25, R*0.18);
      p.roll.scale.set(R*0.85, R*0.85, R*0.85); p.roll.position.set(0, len*0.98 - D.ha*0.25, R*0.18);
      p.knee.scale.set(R*0.82, R*0.7, R*0.62); p.knee.position.set(0, len*0.86, R*0.55);
      p.bol.forEach(b => { b.scale.set(R*0.16, len*0.82, R*0.16); b.position.set(b.userData.i*R*0.42, len*0.05, R*1.12 - Math.abs(b.userData.i)*R*0.12); });
      p.straps.forEach(s => { s.scale.set(R*1.06, H*0.012, R*1.1); s.position.set(0, len*s.userData.h, R*0.15); });
    });
    [shoeL, shoeR].forEach(s => {
      s.up.scale.set(D.footL*0.30, H*0.034, D.footL*0.55); s.up.position.set(0, H*0.022, D.footL*0.35);
      s.so.scale.set(D.footL*0.58, H*0.012, D.footL*1.12); s.so.position.set(0, H*0.006, D.footL*0.34);
      s.sp.scale.set(D.footL*0.61, H*0.004, D.footL*0.3); s.sp.position.set(0, H*0.014, D.footL*0.0);
    });
    [gloveL, gloveR].forEach(g => {
      g.palm.scale.set(H*0.034, H*0.05, H*0.04); g.palm.position.set(0, 0, 0);
      g.cuff.scale.set(H*0.033, H*0.045, H*0.033); g.cuff.position.set(0, -H*0.055, 0);
      g.rolls.forEach((r,i) => { r.scale.set(H*0.012, H*0.07, H*0.012); r.position.set(0, H*0.035 - i*H*0.022, H*0.03); });
    });
  }
  setHeight(1.5);

  // ---- pose → joints ----
  const J = {}; ['pelvis','hipL','hipR','kneeL','kneeR','ankL','ankR','neckB','shL','shR','elL','elR','hL','hR','head','eye'].forEach(k => J[k] = new THREE.Vector3());
  const tmpE = new THREE.Vector3(), tmpT = new THREE.Vector3();
  function legReach(k){ return Math.sqrt(D.t*D.t + D.s*D.s + 2*D.t*D.s*Math.cos(k*DEG)); }
  // pose: {ab, af, yawB, yawF, kb, kf, pelvisXZ, lean, open, shOpen, face, bat:{toe,u,f}, grip}
  function apply(p){
    const open = p.open*DEG, sOpen = (p.shOpen ?? p.open*1.15)*DEG;
    const right = rotY(new THREE.Vector3(0,0,1), open);          // body right axis (toward stumps)
    const fwd = rotY(new THREE.Vector3(1,0,0), open);            // chest direction
    // pelvis
    J.pelvis.set(p.pelvisXZ.x, 0, p.pelvisXZ.z);
    J.hipR.copy(J.pelvis).addScaledVector(right, D.hip); J.hipL.copy(J.pelvis).addScaledVector(right, -D.hip);
    J.ankR.copy(p.ab); J.ankL.copy(p.af);
    const yFor = (hip, ank, k) => { const hz = Math.hypot(hip.x-ank.x, hip.z-ank.z), r = legReach(k); return ank.y + Math.sqrt(Math.max(0.01, r*r - hz*hz)); };
    const y = Math.min(yFor(J.hipR, J.ankR, p.kb), yFor(J.hipL, J.ankL, p.kf));
    J.pelvis.y = y; J.hipR.y = y; J.hipL.y = y;
    const kneePoleR = rotY(new THREE.Vector3(1,0,0), (p.yawB||0)*DEG).add(new THREE.Vector3(0,0,0.15));
    const kneePoleL = rotY(new THREE.Vector3(1,0,0), (p.yawF||0)*DEG).add(new THREE.Vector3(0,0,-0.2));
    ik2(J.hipR, J.ankR, D.t, D.s, kneePoleR, J.kneeR, tmpT); J.ankR.copy(tmpT);
    ik2(J.hipL, J.ankL, D.t, D.s, kneePoleL, J.kneeL, tmpT); J.ankL.copy(tmpT);
    // spine
    const spine = UP.clone().applyAxisAngle(right, -p.lean*DEG).normalize();
    J.neckB.copy(J.pelvis).addScaledVector(spine, D.torso);
    const sRight = rotY(new THREE.Vector3(0,0,1), sOpen);
    const shBase = J.neckB.clone().addScaledVector(spine, -0.035*H);
    J.shR.copy(shBase).addScaledVector(sRight, D.sh); J.shL.copy(shBase).addScaledVector(sRight, -D.sh);
    const neckDir = spine.clone().lerp(UP, 0.6).normalize();
    J.head.copy(J.neckB).addScaledVector(neckDir, D.neck + D.headR*0.95);
    const face = (p.face || new THREE.Vector3(0.22,0,-1)).clone().normalize();
    J.eye.copy(J.head).addScaledVector(face, D.headR*0.82).addScaledVector(UP, D.headR*0.12);
    // bat + hands
    const b = p.bat, gTop = batL - 0.032 - (p.gripAdj||0), gBot = gTop - 0.088;
    J.hL.copy(b.toe).addScaledVector(b.u, gTop); J.hR.copy(b.toe).addScaledVector(b.u, gBot);
    const handleOff = new THREE.Vector3().crossVectors(b.u, new THREE.Vector3().crossVectors(b.f, b.u)).normalize().multiplyScalar(bat ? bat.userData.handleZ : 0);
    J.hL.add(handleOff); J.hR.add(handleOff);
    const poleL = p.poleL || new THREE.Vector3(0.55,-0.25,-0.8), poleR = p.poleR || new THREE.Vector3(0.35,-0.9,0.35);
    ik2(J.shL, J.hL, D.a, D.b, poleL, J.elL, tmpT); const reachL = tmpT.distanceTo(J.hL); J.hL.copy(tmpT);
    ik2(J.shR, J.hR, D.a, D.b, poleR, J.elR, tmpT); const reachR = tmpT.distanceTo(J.hR); J.hR.copy(tmpT);
    // ---- place meshes ----
    const place = (m, A, B, r) => { _v3.subVectors(B, A); const L = _v3.length(); m.position.copy(A); m.quaternion.setFromUnitVectors(UP, _v3.normalize()); m.scale.set(r, L, r); };
    place(P.thighL, J.hipL, J.kneeL, D.thighR); place(P.thighR, J.hipR, J.kneeR, D.thighR);
    place(P.uArmL, J.shL, J.elL, D.uArmR); place(P.uArmR, J.shR, J.elR, D.uArmR);
    place(P.fArmL, J.elL, J.hL, D.fArmR); place(P.fArmR, J.elR, J.hR, D.fArmR);
    place(P.neck, J.neckB, J.head, H*0.032);
    P.hipL.position.copy(J.hipL); P.hipR.position.copy(J.hipR); P.kneeL.position.copy(J.kneeL); P.kneeR.position.copy(J.kneeR);
    P.shL.position.copy(J.shL); P.shR.position.copy(J.shR); P.elL.position.copy(J.elL); P.elR.position.copy(J.elR);
    torsoG.position.copy(J.pelvis).addScaledVector(spine, -0.01*H); orient(torsoG, spine, fwd);
    torsoG.rotation.order = 'XYZ';
    pelvisG.position.copy(J.pelvis).addScaledVector(spine, -0.055*H); orient(pelvisG, spine, fwd);
    headG.position.copy(J.head); orient(headG, UP.clone().lerp(spine, .25), face);
    const padPlace = (pad, knee, ank, yaw) => { pad.g.position.copy(ank); const up = _v1.subVectors(knee, ank).normalize().clone(); orient(pad.g, up, rotY(new THREE.Vector3(1,0,0), yaw*DEG)); };
    padPlace(padL, J.kneeL, J.ankL, p.yawF||0); padPlace(padR, J.kneeR, J.ankR, p.yawB||0);
    const shoePlace = (s, ank, yaw) => { s.g.position.set(ank.x, 0, ank.z); orient(s.g, UP, rotY(new THREE.Vector3(1,0,0), yaw*DEG)); s.g.position.addScaledVector(rotY(new THREE.Vector3(1,0,0), yaw*DEG), -D.footL*0.12); };
    shoePlace(shoeL, J.ankL, p.yawF||0); shoePlace(shoeR, J.ankR, p.yawB||0);
    const glovePlace = (g, el, h) => { g.g.position.copy(h); const up = _v1.subVectors(h, el).normalize().clone(); orient(g.g, up, b.f.clone().negate()); };
    glovePlace(gloveL, J.elL, J.hL); glovePlace(gloveR, J.elR, J.hR);
    // bat
    if (bat){ bat.position.copy(b.toe); const x = new THREE.Vector3().crossVectors(b.u, b.f).normalize(); const z = new THREE.Vector3().crossVectors(x, b.u).normalize(); _m4.makeBasis(x, b.u, z); bat.quaternion.setFromRotationMatrix(_m4); }
    return {reachL, reachR};
  }

  // ---- stance from settings ----
  // s: {height, batLen, guard, open, widthRatio, knee, batAngle, grip, weight, hand}
  function address(s){
    const Hh = s.height;
    const footFwd = 0.12*Hh;
    const guardX = s.guard;
    const xf = guardX - footFwd - 0.05 - 0.02*Hh;
    const w = s.widthRatio * 0.23 * Hh;
    const zB = -1.0, zF = zB - w;
    const openShift = -(s.open/40)*0.09*Hh;
    const ab = new THREE.Vector3(xf, 0.046*Hh, zB), af = new THREE.Vector3(xf + openShift, 0.046*Hh, zF);
    const pelvisXZ = new THREE.Vector3(xf - 0.02*Hh - Math.sin(s.knee*DEG)*0.11*Hh, 0, (zB+zF)/2 + s.weight*w*0.22);
    const toe = new THREE.Vector3(guardX, 0.004, zB - 0.32*w);
    const target = new THREE.Vector3(pelvisXZ.x + 0.02*Hh, 0, zF + 0.25*w);
    const az = Math.atan2(target.z - toe.z, target.x - toe.x);
    const a = s.batAngle*DEG;
    const u = new THREE.Vector3(Math.cos(az)*Math.sin(a), Math.cos(a), Math.sin(az)*Math.sin(a)).normalize();
    const f0 = new THREE.Vector3(0.12,0,-1); const f = f0.addScaledVector(u, -f0.dot(u)).normalize();
    return { ab, af, yawB: 0, yawF: s.open*0.7 + 8, kb: s.knee, kf: s.knee*0.9, pelvisXZ, lean: s.lean, open: s.open*0.85, shOpen: s.open, face: new THREE.Vector3(0.2 + s.open/120, 0, -1),
      bat:{toe, u, f}, gripAdj: {top:0, mid:0.045, low:0.095}[s.grip] || 0 };
  }

  return { root, body, setHeight, setBatLength, apply, address, joints:J, dims:() => D, batLen:() => batL };
}

/* pose interpolation helpers */
function clonePose(p){
  return { ab:p.ab.clone(), af:p.af.clone(), yawB:p.yawB, yawF:p.yawF, kb:p.kb, kf:p.kf, pelvisXZ:p.pelvisXZ.clone(), lean:p.lean, open:p.open, shOpen:p.shOpen, face:p.face.clone(),
    bat:{toe:p.bat.toe.clone(), u:p.bat.u.clone(), f:p.bat.f.clone()}, gripAdj:p.gripAdj, poleL:p.poleL ? p.poleL.clone() : null, poleR:p.poleR ? p.poleR.clone() : null };
}
function mixPose(A, B, t){
  const r = clonePose(A);
  r.ab.lerp(B.ab, t); r.af.lerp(B.af, t); r.pelvisXZ.lerp(B.pelvisXZ, t); r.face.lerp(B.face, t);
  ['yawB','yawF','kb','kf','lean','open','shOpen','gripAdj'].forEach(k => r[k] = lerp(A[k], B[k], t));
  // interpolate the bat by its grip point so the hands travel smoothly
  const gA = A.bat.toe.clone().addScaledVector(A.bat.u, 0.55), gB = B.bat.toe.clone().addScaledVector(B.bat.u, 0.55);
  const g = gA.lerp(gB, t);
  r.bat.u.copy(A.bat.u).lerp(B.bat.u, t).normalize();
  r.bat.f.copy(A.bat.f).lerp(B.bat.f, t); r.bat.f.addScaledVector(r.bat.u, -r.bat.f.dot(r.bat.u)).normalize();
  r.bat.toe.copy(g).addScaledVector(r.bat.u, -0.55);
  const pl = (a, b) => a && b ? a.clone().lerp(b, t) : (b || a);
  r.poleL = pl(A.poleL, B.poleL); r.poleR = pl(A.poleR, B.poleR);
  return r;
}
/* shot keyframes, built from the address pose */
function shotFrames(kind, A, H, batLen, backlift){
  const V = (x,y,z) => new THREE.Vector3(x,y,z);
  const hi = backlift === 'high';
  const bl = clonePose(A);
  const gMid = batLen - 0.075;
  const handsA = A.bat.toe.clone().addScaledVector(A.bat.u, gMid);
  const setBat = (pose, hands, u, f) => { u = u.clone().normalize(); f = f.clone(); f.addScaledVector(u, -f.dot(u)).normalize(); pose.bat = {toe: hands.clone().addScaledVector(u, -gMid), u, f}; };
  // backlift: hands up toward the back hip, toe pointing up at the slips
  setBat(bl, handsA.clone().add(V(-0.03*H, (hi?0.17:0.11)*H, 0.11*H)), hi ? V(0.05,-0.62,-0.78) : V(0.08,-0.35,-0.93), V(0.9,0.25,0.3));
  bl.poleL = V(0.5,-0.1,-0.85); bl.poleR = V(0.2,-1,0.3);
  bl.lean = A.lean + 2;
  const frames = [];
  if (kind === 'defence' || kind === 'drive'){
    const drive = kind === 'drive';
    const st = clonePose(bl);
    st.af.add(V((drive?0.13:0.09)*H, 0, -(drive?0.25:0.22)*H)); st.yawF = drive ? 30 : 22;
    st.kf = 48; st.kb = 14; st.pelvisXZ.add(V(0.05*H, 0, -0.13*H)); st.lean = A.lean + 13; st.open = A.open + 6; st.shOpen = A.shOpen + 4;
    st.face = V(0.55, -0.35, -0.75);
    const ct = clonePose(st);
    const toe = V(st.af.x + (drive?0.20:0.15)*H, 0.03*H, st.af.z - 0.10*H);
    const u = drive ? V(-0.05, 1, -0.18) : V(0.04, 1, -0.5);
    ct.bat = {toe, u: u.normalize(), f: (drive ? V(0.55,0,-0.84) : V(0,-0.3,-1)).addScaledVector(u, -0).normalize()};
    ct.bat.f.addScaledVector(ct.bat.u, -ct.bat.f.dot(ct.bat.u)).normalize();
    ct.poleL = V(0.9,0.4,-0.2); ct.poleR = V(0.2,-1,0.4); ct.face = V(0.45,-0.5,-0.75);
    frames.push([0, A], [0.38, bl], [0.78, st], [1.02, ct]); frames.tc = 1.02; frames.ct = ct;
    if (drive){
      const fo = clonePose(ct);
      const sh = new THREE.Vector3(st.pelvisXZ.x + 0.06*H, 0.95*H, st.pelvisXZ.z - 0.22*H);
      setBat(fo, sh, V(0.25,-0.55,-0.8), V(0,0.5,-0.9)); fo.poleL = V(0.3,0.5,-0.8); fo.poleR = V(0.6,0.2,0.6); fo.open = st.open + 18; fo.shOpen = st.shOpen + 30; fo.lean = st.lean - 4;
      frames.push([1.35, fo], [2.1, fo], [2.9, A]);
    } else frames.push([1.85, ct], [2.6, A]);
  } else { // back-foot defence
    const bk = clonePose(bl);
    bk.ab.add(V(0.07*H, 0, 0.06*H)); bk.af.add(V(0.07*H, 0, 0.1*H)); bk.yawB = 12; bk.yawF = 18;
    bk.kb = 9; bk.kf = 8; bk.pelvisXZ.add(V(0.07*H, 0, 0.08*H)); bk.lean = 7; bk.face = V(0.4,-0.25,-0.85);
    const ct = clonePose(bk);
    const toe = V(bk.ab.x + 0.21*H, 0.24*H, bk.ab.z - 0.2*H);
    const u = V(0.02, 1, -0.22).normalize();
    ct.bat = {toe, u, f: V(0,-0.15,-1).addScaledVector(u, 0.22).normalize()};
    ct.poleL = V(0.9,0.5,-0.3); ct.poleR = V(0.3,-1,0.5);
    frames.push([0, A], [0.36, bl], [0.7, bk], [0.92, ct], [1.75, ct], [2.5, A]); frames.tc = 0.92; frames.ct = ct;
  }
  return frames;
}
function poseAt(frames, t){
  if (t <= frames[0][0]) return frames[0][1];
  for (let i=1;i<frames.length;i++){
    if (t <= frames[i][0]){ const a = frames[i-1], b = frames[i], f = (t - a[0])/(b[0]-a[0]); return mixPose(a[1], b[1], ease(clamp(f,0,1))); }
  }
  return frames[frames.length-1][1];
}

/* =========================================================
   STANCE STUDIO
   ========================================================= */
function bindSeg(id, cb){
  const box = document.getElementById(id); if (!box) return () => null;
  const get = () => { const b = box.querySelector('button.on'); return b ? b.dataset.v : null; };
  box.addEventListener('click', e => { const b = e.target.closest('button'); if (!b) return; $$('button', box).forEach(x => { x.classList.toggle('on', x===b); x.setAttribute('aria-pressed', x===b); }); cb && cb(b.dataset.v); });
  $$('button', box).forEach(x => x.setAttribute('aria-pressed', x.classList.contains('on')));
  return get;
}
function makeNetCage(parent, o){
  if (!makeNetCage.tex){ const nc = mkCanvas(128,128), nx = nc.getContext('2d'); nx.strokeStyle = 'rgba(14,40,28,.9)'; nx.lineWidth = 2.2; for (let i=0;i<=128;i+=16){ nx.beginPath(); nx.moveTo(i,0); nx.lineTo(i,128); nx.stroke(); nx.beginPath(); nx.moveTo(0,i); nx.lineTo(128,i); nx.stroke(); } makeNetCage.tex = nc; }
  const netMat = (rx, ry) => { const t = new THREE.CanvasTexture(makeNetCage.tex); t.wrapS = t.wrapT = THREE.RepeatWrapping; t.repeat.set(rx, ry); t.anisotropy = 8; return new THREE.MeshStandardMaterial({map:t, transparent:true, side:THREE.DoubleSide, depthWrite:false, opacity:.7, roughness:1}); };
  const {xs, z0, z1, h} = o, LEN = z1 - z0, W = xs[xs.length-1] - xs[0], cx = (xs[0]+xs[xs.length-1])/2;
  xs.forEach(x => { const p = new THREE.Mesh(new THREE.PlaneGeometry(LEN, h), netMat(LEN/1.1, h/1.1)); p.rotation.y = Math.PI/2; p.position.set(x, h/2, (z0+z1)/2); parent.add(p); });
  if (o.roof !== false){ const roof = new THREE.Mesh(new THREE.PlaneGeometry(W, LEN), netMat(W/1.1, LEN/1.1)); roof.rotation.x = -Math.PI/2; roof.position.set(cx, h, (z0+z1)/2); parent.add(roof); }
  if (o.back !== false){ const back = new THREE.Mesh(new THREE.PlaneGeometry(W, h), netMat(W/1.1, h/1.1)); back.position.set(cx, h/2, z1); parent.add(back); }
  const poleM = new THREE.MeshStandardMaterial({color:0x0A3D24, roughness:.4, metalness:.4});
  for (let z=z0; z<=z1+0.01; z+=4) xs.forEach(x => { const p = new THREE.Mesh(new THREE.CylinderGeometry(0.045,0.045,h,10), poleM); p.position.set(x, h/2, z); p.castShadow = true; parent.add(p); });
  xs.forEach(x => { const b = new THREE.Mesh(new THREE.BoxGeometry(0.06,0.06,LEN), poleM); b.position.set(x, h, (z0+z1)/2); parent.add(b); });
}
function dashedLine(color, opacity){
  const l = new THREE.Line(new THREE.BufferGeometry().setFromPoints([new THREE.Vector3(), new THREE.Vector3(0,0,1)]), new THREE.LineDashedMaterial({color, dashSize:0.05, gapSize:0.035, transparent:true, opacity:opacity||1, depthTest:false}));
  l.renderOrder = 9; l.frustumCulled = false;
  l.set = (a, b) => { l.geometry.setFromPoints([a, b]); l.computeLineDistances(); };
  return l;
}

function initStance(){
  const canvas = $('#stCanvas'), view = $('#stView');
  const el = id => document.getElementById(id);
  const ctl = { height:el('stHeight'), width:el('stWidth'), knee:el('stKnee'), lean:el('stLean'), angle:el('stAngle'), bat:el('stBat') };
  const seg = {};
  let rebuild = () => {};
  ['stHand','stGuard','stOpen','stGrip','stWeight','stLift'].forEach(k => seg[k] = bindSeg(k, () => rebuild()));
  ctl.bat.innerHTML = '<option value="auto">Auto, from height</option>' + BATS.map((b,i) => '<option value="'+i+'">'+b.s+' · '+b.len+' cm</option>').join('');
  const S = () => {
    const h = +ctl.height.value / 100;
    const auto = batForHeight(+ctl.height.value);
    const chosen = ctl.bat.value === 'auto' ? auto : BATS[+ctl.bat.value];
    return { height:h, bat:chosen, auto, batLen:chosen.len/100, hand:seg.stHand(), guard:{leg:-0.1, ml:-0.05, mid:0, off:0.1}[seg.stGuard()],
      open:{side:0, semi:16, open:34}[seg.stOpen()], widthRatio:+ctl.width.value/100, knee:+ctl.knee.value, lean:+ctl.lean.value,
      batAngle:+ctl.angle.value, grip:seg.stGrip(), weight:{back:1, even:0, front:-1}[seg.stWeight()], lift:seg.stLift() };
  };

  let world = null;
  if (hasGL){
    const renderer = makeRenderer(canvas, true);
    renderer.toneMappingExposure = 1.05;
    const scene = new THREE.Scene();
    const camera = new THREE.PerspectiveCamera(34, 1, 0.05, 900);
    outdoorWorld(scene, renderer, {boards:false, ground:120, rep:30, fogNear:30, fogFar:240});
    const sun = outdoorLights(scene, 3.2);
    sun.position.set(-3.5, 7, 3);
    const pitchG = new THREE.Group(); scene.add(pitchG);
    pitchG.position.z = -PITCH.half;   // batter's stumps at origin
    const P = buildPitch(pitchG);
    makeNetCage(scene, {xs:[-3.4, 3.4], z0:-21, z1:2.4, h:3.6, roof:true});
    // reference lines
    const offLine = new THREE.Mesh(new THREE.PlaneGeometry(0.014, 2.4), new THREE.MeshBasicMaterial({color:0xD7192F, transparent:true, opacity:.75}));
    offLine.rotation.x = -Math.PI/2; offLine.position.set(0.0968, 0.016, -1.2); scene.add(offLine);
    const guardMark = new THREE.Mesh(new THREE.PlaneGeometry(0.03, 0.14), new THREE.MeshBasicMaterial({color:0xFFFFFF})); guardMark.rotation.x = -Math.PI/2; scene.add(guardMark);
    const bt = createBatter(); scene.add(bt.root);
    const eyeLine = dashedLine(0xD7192F); scene.add(eyeLine);
    const plumb = dashedLine(0x0B1D15, .7); scene.add(plumb);
    const widthLine = dashedLine(0x2E6BE6); scene.add(widthLine);
    const eyeTag = textSprite('Eye-line', {size:40, h:0.11, color:'#FFFFFF', bg:'rgba(215,25,47,.95)', depthTest:false}); scene.add(eyeTag);
    const widthTag = textSprite('Feet', {size:40, h:0.1, color:'#FFFFFF', bg:'rgba(46,107,230,.95)', depthTest:false}); scene.add(widthTag);
    const shotBall = makeBall(PITCH.ballR); shotBall.visible = false; scene.add(shotBall);
    const flash = new THREE.Mesh(new THREE.RingGeometry(0.05, 0.07, 32), new THREE.MeshBasicMaterial({color:0xFFFFFF, transparent:true, opacity:0, side:THREE.DoubleSide, depthTest:false}));
    flash.renderOrder = 11; scene.add(flash);
    const controls = new THREE.OrbitControls(camera, canvas);
    controls.enableDamping = true; controls.dampingFactor = 0.08; controls.enableZoom = false; controls.enablePan = false; controls.maxPolarAngle = 1.5;
    const VIEWS = { bowler:{c:[-0.7,1.25,-5.6], t:[-0.25,0.72,-1.25]}, side:{c:[3.05,1.05,-1.55], t:[-0.25,0.7,-1.3]}, behind:{c:[-1.5,1.5,2.2], t:[-0.25,0.75,-1.3]}, top:{c:[0.15,5.6,-1.2], t:[-0.25,0,-1.25]} };
    let tween = null, dist = 1;
    const go = (v, instant) => {
      const V = VIEWS[v]; const tc = new THREE.Vector3(...V.c), tt = new THREE.Vector3(...V.t);
      if (seg.stHand() === 'L'){ tc.x *= -1; tt.x *= -1; }
      tween = {fc:camera.position.clone(), ft:controls.target.clone(), tc, tt, k: instant ? 1 : 0};
      if (instant){ camera.position.copy(tc); controls.target.copy(tt); }
      $$('#stViews button').forEach(b => b.classList.toggle('on', b.dataset.v === v)); curView = v;
    };
    let curView = 'side';
    $$('#stViews button').forEach(b => b.addEventListener('click', () => go(b.dataset.v)));
    const zoom = f => { const d = camera.position.clone().sub(controls.target); const L = clamp(d.length()*f, 1.4, 12); camera.position.copy(controls.target).addScaledVector(d.normalize(), L); tween = null; };
    el('stZoomIn').addEventListener('click', () => zoom(0.82)); el('stZoomOut').addEventListener('click', () => zoom(1.22));
    go('side', true); controls.update();
    let pose = null, shot = null, idle = 0, s = S();
    world = {
      set(st){
        s = st;
        bt.setHeight(st.height); bt.setBatLength(st.batLen);
        bt.root.scale.x = st.hand === 'L' ? -1 : 1;
        pose = bt.address(st);
        guardMark.position.set((st.hand==='L'?-1:1)*st.guard, 0.017, -PITCH.pop);
        offLine.position.x = (st.hand==='L'?-1:1)*0.0968;
        if (!shot) bt.apply(pose);
        return measure();
      },
      play(kind){ shot = {kind, t:0, frames: shotFrames(kind, pose, s.height, s.batLen, s.lift)}; shotBall.visible = true; },
      reView(){ go(curView); }
    };
    function toWorld(v){ const w = v.clone(); if (s.hand === 'L') w.x *= -1; return w; }
    function measure(){
      const J = bt.joints, D = bt.dims();
      const eye = toWorld(J.eye), ankL = toWorld(J.ankL), ankR = toWorld(J.ankR);
      eyeLine.set(eye, new THREE.Vector3(eye.x, eye.y, -7)); eyeTag.position.set(eye.x, eye.y + 0.1, eye.z - 0.32);
      setSpriteText(eyeTag, 'Eye-line ' + Math.round(J.eye.y*100) + ' cm', {size:40, h:0.11, color:'#FFFFFF', bg:'rgba(215,25,47,.95)', depthTest:false});
      plumb.set(eye, new THREE.Vector3(eye.x, 0.02, eye.z));
      const a = new THREE.Vector3(ankL.x, 0.03, ankL.z), b = new THREE.Vector3(ankR.x, 0.03, ankR.z);
      widthLine.set(a, b); widthTag.position.copy(a).lerp(b, .5).add(new THREE.Vector3(0.32, 0.05, 0));
      const wcm = Math.round(J.ankL.distanceTo(J.ankR)*100);
      setSpriteText(widthTag, 'Feet ' + wcm + ' cm', {size:40, h:0.1, color:'#FFFFFF', bg:'rgba(46,107,230,.95)', depthTest:false});
      return {eyeY:J.eye.y, headX:J.head.x, ballFootX: (J.ankL.x + J.ankR.x)/2 + 0.075*s.height, widthCm:wcm, hipY:J.pelvis.y, D};
    }
    const ballPath = {};
    addScene({canvas, renderer, scene, camera, page:'lab', baseFov:34, update(dt){
      if (tween && tween.k < 1){ tween.k = Math.min(1, tween.k + dt*1.5); const f = ease(tween.k); camera.position.lerpVectors(tween.fc, tween.tc, f); controls.target.lerpVectors(tween.ft, tween.tt, f); }
      controls.update();
      idle += dt;
      if (shot){
        shot.t += dt * (reduced ? 1.6 : 0.85);
        const fr = shot.frames, end = fr[fr.length-1][0];
        bt.apply(poseAt(fr, shot.t));
        // ball: arrives at the bat at contact time, then reacts to the shot
        const ct = fr.ct, tc = fr.tc;
        const cp = ct.bat.toe.clone().addScaledVector(ct.bat.u, 0.17).addScaledVector(ct.bat.f, 0.05);
        const start = new THREE.Vector3(0.28, 1.95, -17.5), tIn = 0.62;
        const tt = shot.t - (tc - tIn);
        let bp = null;
        if (tt < 0) shotBall.visible = false;
        else if (tt <= tIn){
          shotBall.visible = true; const f = tt/tIn, fb = 0.72;
          const bounce = start.clone().lerp(cp, fb); bounce.y = PITCH.ballR;
          if (f < fb){ const g = f/fb; bp = start.clone().lerp(bounce, g); bp.y = lerp(start.y, PITCH.ballR, g*g); }
          else { const g = (f-fb)/(1-fb); bp = bounce.clone().lerp(cp, g); bp.y = PITCH.ballR + (cp.y - PITCH.ballR)*Math.sin(g*Math.PI/2); }
          shotBall.userData.spin.rotation.x -= dt*30;
        } else {
          const u = tt - tIn; shotBall.visible = u < 1.6;
          if (shot.kind === 'drive'){ const dir = ct.bat.f.clone(); dir.y = 0; dir.normalize(); bp = cp.clone().addScaledVector(dir, u*16); bp.y = Math.max(PITCH.ballR, cp.y + 1.2*u - 4.9*u*u); }
          else { bp = cp.clone().add(new THREE.Vector3(0.15*u, 0, -0.8*u)); bp.y = Math.max(PITCH.ballR, cp.y - 4.9*u*u + 0.4*u); }
          shotBall.userData.spin.rotation.x -= dt*12;
          flash.material.opacity = Math.max(0, 1 - u*3); flash.scale.setScalar(1 + u*14); flash.position.copy(toWorld(cp)); flash.lookAt(camera.position);
        }
        if (bp) shotBall.position.copy(toWorld(bp));
        if (shot.t >= end + 0.3){ shot = null; shotBall.visible = false; flash.material.opacity = 0; bt.apply(pose); }
      } else if (pose && !reduced){
        const b = Math.sin(idle*1.6)*0.6;
        const p = clonePose(pose); p.lean += b*0.6; bt.apply(p);
      }
    }});
  } else {
    view.insertAdjacentHTML('beforeend','<p class="nogl">The 3D view needs WebGL, which this browser has turned off. The checks on the right still work.</p>');
  }

  rebuild = () => {
    const st = S();
    Object.values(ctl).forEach(c => c.type === 'range' && fillRange(c));
    el('oStHeight').textContent = st.height*100 + ' cm';
    el('oStWidth').textContent = Math.round(st.widthRatio*100) + '% of shoulders';
    el('oStKnee').textContent = st.knee + '°';
    el('oStLean').textContent = st.lean + '°';
    el('oStAngle').textContent = st.batAngle + '°';
    const m = world ? world.set(st) : null;
    // readouts
    el('rBat').textContent = st.bat.s;
    el('rBatLen').textContent = st.bat.len + ' cm';
    el('rBatAge').textContent = st.bat.age;
    el('rBall').textContent = st.bat.ball;
    el('rRec').textContent = st.auto.s; el('rAge').textContent = st.auto.age;
    const hipStand = 0.53*st.height, fit = st.batLen / hipStand;
    const fitPct = Math.round(fit*100);
    const fitEl = el('rFit'), fitBar = el('rFitBar');
    fitBar.style.left = clamp((fit - 0.7)/0.6*100, 2, 98) + '%';
    let tips = [];
    if (fit < 0.86){ fitEl.textContent = 'Too short'; fitEl.dataset.s = 'warn'; tips.push(['warn','Bat is short for this height. The player has to bend over and loses reach on drives. Try ' + st.auto.s + '.']); }
    else if (fit > 1.08){ fitEl.textContent = 'Too long'; fitEl.dataset.s = 'bad'; tips.push(['bad','Bat is too long. The handle catches the body and the bat swings across the line. Drop to ' + st.auto.s + '.']); }
    else { fitEl.textContent = 'Good fit'; fitEl.dataset.s = 'good'; tips.push(['good','Bat fits. Grounded beside the back foot, the handle reaches the top of the thigh (' + fitPct + '% of hip height).']); }
    if (m){
      el('rEye').textContent = Math.round(m.eyeY*100) + ' cm';
      el('rFeet').textContent = m.widthCm + ' cm';
      const off = m.headX - m.ballFootX, offH = off / st.height;
      if (offH < -0.06) tips.push(['warn','Head sits behind the feet, so weight is on the heels. Add a little lean from the hips.']);
      else if (offH > 0.07) tips.push(['warn','Head is ahead of the toes. The player may topple forward on full balls.']);
      else tips.push(['good','Head over the balls of the feet. Balanced and ready to move forward or back.']);
    }
    if (st.knee < 8) tips.push(['warn','Legs nearly straight. Soft knees (10–25°) help the first movement.']);
    else if (st.knee > 30) tips.push(['warn','Deep crouch. It tires the legs and makes the bounce harder to judge.']);
    else tips.push(['good','Soft knees: ready to push off either foot.']);
    if (st.widthRatio < 0.85) tips.push(['warn','Feet close together. Widen to about shoulder width for balance.']);
    else if (st.widthRatio > 1.35) tips.push(['warn','Very wide stance. Stepping forward to full balls gets harder.']);
    else tips.push(['good','Feet about shoulder-width apart.']);
    if (st.open > 20) tips.push(['info','Open stance: shoulders face the bowler more. Useful against inswing; watch the off stump.']);
    if (st.grip === 'low') tips.push(['info','Low grip gives control. Good for young players and defence; less reach on drives.']);
    $('#stTips').innerHTML = tips.map(t => '<li data-s="'+t[0]+'">'+t[1]+'</li>').join('');
  };
  Object.values(ctl).forEach(c => c.addEventListener(c.tagName === 'SELECT' ? 'change' : 'input', () => rebuild()));
  $('#stHand').addEventListener('click', () => world && setTimeout(() => world.reView(), 0));
  $$('#stShots button').forEach(b => b.addEventListener('click', () => { if (world) world.play(b.dataset.shot); }));
  rebuild();
}

/* =========================================================
   HERO — scroll-bowled delivery
   ========================================================= */
function initStory(){
  const canvas = $('#storyCanvas');
  if (!hasGL){ canvas.classList.add('nogl-bg'); $('#storyHud').style.opacity = 1; return; }
  const renderer = makeRenderer(canvas, true);
  const scene = new THREE.Scene();
  const camera = new THREE.PerspectiveCamera(40, 1, 0.02, 900);
  outdoorWorld(scene, renderer, {boards:62, flood:76, ground:140, rep:34, fogNear:70, fogFar:300});
  const sun = outdoorLights(scene, 6);
  const P = buildPitch(scene);
  const ball = makeBall(PITCH.ballR); scene.add(ball);
  // batter at the striker's end
  const bt = createBatter(); bt.setHeight(1.66); bt.setBatLength(0.85);
  bt.root.position.z = PITCH.half; scene.add(bt.root);
  const st = {height:1.66, batLen:0.85, guard:0, open:6, widthRatio:1.05, knee:18, lean:16, batAngle:16, grip:'top', weight:0};
  const addr = bt.address(st);
  const leave = clonePose(addr);
  leave.af.add(new THREE.Vector3(0.05, 0, -0.26)); leave.yawF = 24; leave.kf = 34; leave.kb = 12; leave.pelvisXZ.add(new THREE.Vector3(0.03, 0, -0.1));
  const hands = new THREE.Vector3(addr.pelvisXZ.x + 0.02, 1.62, addr.pelvisXZ.z - 0.02);
  const lu = new THREE.Vector3(0.05, -0.75, -0.62).normalize();
  leave.bat = {toe: hands.clone().addScaledVector(lu, -(0.85 - 0.075)), u: lu, f: new THREE.Vector3(1,0.2,0).addScaledVector(lu, -lu.dot(new THREE.Vector3(1,0.2,0))).normalize()};
  leave.poleL = new THREE.Vector3(0.6,0.3,-0.8); leave.poleR = new THREE.Vector3(0.4,0.2,0.8); leave.face = new THREE.Vector3(0.35,-0.25,-1);
  bt.apply(addr);

  const D = computeDelivery({speed:125, len:5.6, line:0.13, swing:9, seam:-2, surf:'turf'});
  const hitPt = D.st || D.pts[D.pts.length-1];
  const tEnd = D.pts[D.pts.length-1][3];
  const reactMs = Math.round(D.pop.t*1000);
  const hitStump = hitPt.x > 0.05 ? 2 : hitPt.x < -0.05 ? 0 : 1;
  const R0 = new THREE.Vector3(D.pts[0][0], D.pts[0][1], D.pts[0][2]);
  const trail = new THREE.Line(new THREE.BufferGeometry().setFromPoints(D.pts.map(p => new THREE.Vector3(p[0],p[1],p[2]))), new THREE.LineBasicMaterial({color:0xD7192F, transparent:true, opacity:.6}));
  trail.geometry.setDrawRange(0,0); scene.add(trail);
  const mark = new THREE.Mesh(new THREE.RingGeometry(0.06, 0.1, 40), new THREE.MeshBasicMaterial({color:0xD7192F, transparent:true, opacity:0}));
  mark.rotation.x = -Math.PI/2; mark.position.set(D.bounce.x, 0.016, D.bounce.z); scene.add(mark);
  const dust = new THREE.Points(new THREE.BufferGeometry(), new THREE.PointsMaterial({color:0xC9A36A, size:0.035, transparent:true, opacity:0}));
  { const a = []; for (let i=0;i<60;i++) a.push((Math.random()-.5)*0.2, Math.random()*0.02, (Math.random()-.5)*0.2); dust.geometry.setAttribute('position', new THREE.Float32BufferAttribute(a, 3)); }
  dust.position.copy(mark.position); scene.add(dust);

  const HUD = [
    {t:'The new ball', x:'Cork, leather and six rows of hand stitching. Scroll to send it down.', k:['156 g','22.4 cm','6 rows']},
    {t:'Seam upright', x:'Released from about 2 m with backspin. The seam points down the pitch so it can move off the surface.', k:['2.0 m release','Backspin','Seam up']},
    {t:'A good length', x:'It lands 5.6 m in front of the stumps. Too full to go back, too short to drive.', k:['5.6 m','Good length','Off-stump line']},
    {t: reactMs + ' milliseconds', x:'That is all the batter gets at 125 km/h, from release to bat. Reading length early is trained, not born.', k:['125 km/h', reactMs + ' ms', 'Leaves it']},
    {t:'Bowled.', x:'The batter shoulders arms and the off stump goes back. Reading length early is what we train at Velocrix.', k:['Off stump','Through the gate','Wicket']}
  ];
  const hud = {step:$('#hudStep'), title:$('#hudTitle'), text:$('#hudText'), chips:$('#hudChips'), segs:$$('#hudSegs i')};
  let hudIdx = -1;
  const setHud = i => {
    if (i === hudIdx) return; hudIdx = i; const h = HUD[i];
    hud.step.textContent = 'Delivery ' + (i+1) + ' / 5'; hud.title.textContent = h.t; hud.text.textContent = h.x;
    hud.chips.innerHTML = h.k.map(k => '<span>'+k+'</span>').join('');
    hud.segs.forEach((s,j) => s.classList.toggle('on', j <= i));
    const card = $('#storyHud'); card.classList.remove('swap'); void card.offsetWidth; card.classList.add('swap');
  };
  const hero = $('#delivery'), stage = $('.st-stage'), copy = $('.st-copy'), side = $$('.st-fade'), hudEl = $('#storyHud');
  const mouse = {x:0, y:0, tx:0, ty:0};
  hero.addEventListener('pointermove', e => { const r = stage.getBoundingClientRect(); mouse.tx = (e.clientX - r.left)/r.width - .5; mouse.ty = (e.clientY - r.top)/r.height - .5; });
  const keys = [
    {p:0.00, c:[0.09,0.05,-0.36], t:[0,0,0], rel:true},
    {p:0.15, c:[0.8,0.32,-1.4], t:[0,-0.25,2.6], rel:true},
    {p:0.30, c:[-1.0,2.7,-15.8], t:[0,0.6,6.5]},
    {p:0.62, c:[3.2,1.35,6.2], t:[-0.1,0.6,9.9]},
    {p:0.80, c:[4.0,1.7,13.8], t:[-0.1,0.5,9.6]},
    {p:1.00, c:[18,20,34], t:[0,0,1.5]}
  ];
  const cpos = new THREE.Vector3(), ctgt = new THREE.Vector3(), tmpA = new THREE.Vector3(), tmpB = new THREE.Vector3();
  const keyVec = (k, which) => { const a = k[which]; const v = new THREE.Vector3(a[0],a[1],a[2]); if (k.rel) v.add(R0); return v; };
  let pSm = 0, w = 1, h = 1, spinAng = 0, idle = 0;
  addScene({canvas, renderer, scene, camera, page:'home',
    onResize(W,H){ w = W; h = H; },
    update(dt){
      const r = hero.getBoundingClientRect();
      const span = Math.max(1, r.height - stage.clientHeight);
      const pRaw = clamp(-r.top / span, 0, 1);
      pSm = reduced ? pRaw : lerp(pSm, pRaw, 1 - Math.pow(0.002, dt));
      const p = pSm;
      mouse.x = lerp(mouse.x, mouse.tx, 0.05); mouse.y = lerp(mouse.y, mouse.ty, 0.05);
      idle += dt;
      const fly = clamp((p - 0.30)/(0.62 - 0.30), 0, 1);
      const after = clamp((p - 0.62)/0.16, 0, 1);
      let bp;
      if (fly < 1) bp = samplePath(D.pts, fly*tEnd);
      else { const s = after*0.7; bp = [hitPt.x + 0.25*s, Math.max(PITCH.ballR, hitPt.y + 1.2*s - 4.9*s*s), PITCH.half - 0.04 - 1.4*s]; }
      ball.position.set(bp[0], bp[1], bp[2]);
      spinAng += dt * (fly > 0 && fly < 1 ? 40 : 0.9) * (reduced ? 0 : 1);
      ball.userData.spin.rotation.x = -spinAng;
      ball.rotation.y = p < 0.2 ? Math.sin(idle*0.6)*0.3 : 0;
      // batter: stance, then leave as the ball arrives
      const lv = smooth(clamp((fly - 0.45)/0.35, 0, 1));
      bt.apply(lv > 0 ? mixPose(addr, leave, lv) : addr);
      const n = Math.floor(D.pts.length * fly);
      trail.geometry.setDrawRange(0, fly > 0 ? Math.max(2,n) : 0);
      trail.material.opacity = 0.6 * (1 - clamp((p-0.86)/0.1,0,1)*0.6);
      const passed = fly*tEnd >= D.t1;
      mark.material.opacity = passed ? 0.9 : 0;
      const dq = passed ? clamp((fly*tEnd - D.t1)/0.25, 0, 1) : 0;
      dust.material.opacity = passed ? (1 - dq)*0.9 : 0; dust.scale.setScalar(1 + dq*4); dust.position.y = dq*0.12;
      const q = after;
      P.bat.stumps.forEach((s,i) => { s.rotation.x = i === hitStump ? smooth(clamp(q*1.6,0,1))*0.6 : (i===1 ? q*0.1 : 0); });
      P.bat.bails.forEach((b,i) => { const s = q*0.75, h0 = b.userData.home, dir = i===0 ? -1 : 1; b.position.set(h0.x + dir*0.9*s, Math.max(0.01, h0.y + 3.2*s - 4.9*s*s), h0.z + 2.2*s); b.rotation.set(s*14*dir, s*6, s*9); });
      let i = 0; while (i < keys.length-2 && p > keys[i+1].p) i++;
      const k0 = keys[i], k1 = keys[i+1];
      const f = smooth(clamp((p - k0.p)/(k1.p - k0.p), 0, 1));
      cpos.copy(keyVec(k0,'c')).lerp(keyVec(k1,'c'), f);
      ctgt.copy(keyVec(k0,'t')).lerp(keyVec(k1,'t'), f);
      if (fly > 0 && fly < 1){ const chase = Math.sin(fly*Math.PI); tmpA.set(bp[0] + 1.7, bp[1] + 0.9, bp[2] - 4.4); cpos.lerp(tmpA, chase*0.5); tmpB.set(bp[0], bp[1]*0.6, bp[2] + 2.5); ctgt.lerp(tmpB, chase*0.42); }
      cpos.x += mouse.x * (p < 0.2 ? 0.06 : 0.7); cpos.y -= mouse.y * (p < 0.2 ? 0.04 : 0.45);
      camera.position.copy(cpos); camera.lookAt(ctgt);
      const shift = 1 - smooth(clamp(p/0.24,0,1));
      if (w > 860) camera.setViewOffset(w, h, -w*0.22*shift, -h*0.03*shift, w, h);
      else camera.setViewOffset(w, h, w*0.12*shift, -h*0.36*shift, w, h);
      sun.position.set(-8 + ctgt.x, 14, 7 + ctgt.z); sun.target.position.copy(ctgt);
      const fade = 1 - smooth(clamp((p - 0.05)/0.1, 0, 1));
      copy.style.opacity = fade; copy.style.transform = 'translate3d(0,' + (-40*(1-fade)) + 'px,0)'; copy.style.visibility = fade < 0.02 ? 'hidden' : '';
      side.forEach(s => s.style.opacity = fade);
      hudEl.style.opacity = w > 860 ? smooth(clamp(-r.top/(innerHeight*0.25)+1,0,1)) : smooth(clamp(p/0.07,0,1));
      const idx = p < 0.16 ? 0 : p < 0.31 ? 1 : p < 0.47 ? 2 : p < 0.63 ? 3 : 4;
      setHud(idx); $('#hudBar').style.transform = 'scaleX(' + p.toFixed(3) + ')';
    }
  });
}

/* =========================================================
   DELIVERY LAB
   ========================================================= */
const DELIVERIES = {
  outswing:{n:'Outswinger', speed:118, len:6.4, line:0.22, swing:22, seam:2, d:'Starts on the stumps and curves away from a right-hander. Beats the outside edge or finds it, for a catch to the slips.'},
  inswing:{n:'Inswinger', speed:116, len:5.8, line:0.24, swing:-26, seam:-3, d:'Curves into the batter. Aims at the pads and the gap between bat and pad.'},
  yorker:{n:'Yorker', speed:128, len:0.9, line:0.02, swing:-6, seam:0, d:'Lands at the toes. The hardest ball to get the bat down on, used at the death.'},
  bouncer:{n:'Bouncer', speed:138, len:11, line:0.12, swing:0, seam:0, d:'Dug in short so it rears up at chest or head height. A batter must duck, sway or pull.'},
  cutter:{n:'Off-cutter', speed:104, len:6.2, line:0.24, swing:0, seam:-14, d:'Fingers roll over the ball, so it straightens or jags back off the pitch.'},
  slower:{n:'Slower ball', speed:88, len:4.2, line:0.1, swing:4, seam:0, d:'Same action, less pace. The batter is through the shot too early.'}
};
function initSim(){
  const el = {speed:$('#sSpeed'), len:$('#sLen'), line:$('#sLine'), swing:$('#sSwing'), seam:$('#sSeam')};
  const out = {speed:$('#oSpeed'), len:$('#oLen'), line:$('#oLine'), swing:$('#oSwing'), seam:$('#oSeam')};
  let surf = 'turf', slow = true, showBatter = true, desc = DELIVERIES.outswing.d;
  const canvas = $('#simCanvas');
  let S = null;
  if (hasGL){
    const renderer = makeRenderer(canvas, true);
    const scene = new THREE.Scene();
    const camera = new THREE.PerspectiveCamera(38, 1, 0.05, 900);
    outdoorWorld(scene, renderer, {boards:58, ground:120, rep:30, fogNear:60, fogFar:280});
    const sun = outdoorLights(scene, 14);
    const P = buildPitch(scene);
    const ball = makeBall(PITCH.ballR * 1.5); scene.add(ball);
    const bt = createBatter(); bt.setHeight(1.52); bt.setBatLength(0.775); bt.root.position.z = PITCH.half; scene.add(bt.root);
    const addr = bt.address({height:1.52, batLen:0.775, guard:-0.05, open:6, widthRatio:1.05, knee:18, lean:16, batAngle:16, grip:'top', weight:0});
    const lift = clonePose(addr);
    { const hands = new THREE.Vector3(addr.pelvisXZ.x, 1.5, addr.pelvisXZ.z); const lu = new THREE.Vector3(0.05,-0.75,-0.62).normalize(); lift.bat = {toe: hands.clone().addScaledVector(lu, -0.7), u:lu, f:new THREE.Vector3(1,0,0).addScaledVector(lu, -lu.x).normalize()}; lift.poleL = new THREE.Vector3(0.6,0.3,-0.8); lift.poleR = new THREE.Vector3(0.4,0.2,0.8); lift.af.add(new THREE.Vector3(0.03,0,-0.12)); lift.kf = 28; }
    bt.apply(addr);
    const fullLine = new THREE.Line(new THREE.BufferGeometry(), new THREE.LineDashedMaterial({color:0x0B1D15, dashSize:0.12, gapSize:0.1, transparent:true, opacity:.3}));
    const trail = new THREE.Line(new THREE.BufferGeometry(), new THREE.LineBasicMaterial({color:0xD7192F}));
    scene.add(fullLine, trail);
    const ringMat = new THREE.MeshBasicMaterial({color:0xD7192F, transparent:true, opacity:.95, side:THREE.DoubleSide});
    const ring = new THREE.Mesh(new THREE.RingGeometry(0.07, 0.12, 40), ringMat); ring.rotation.x = -Math.PI/2; ring.position.y = 0.017; scene.add(ring);
    const heightTag = textSprite('0 cm', {size:40, h:0.13, color:'#FFFFFF', bg:'rgba(215,25,47,.95)', depthTest:false}); scene.add(heightTag);
    const popPlane = new THREE.Mesh(new THREE.PlaneGeometry(3.66, 2.2), new THREE.MeshBasicMaterial({color:0x2E6BE6, transparent:true, opacity:.06, side:THREE.DoubleSide, depthWrite:false}));
    popPlane.position.set(0, 1.1, PITCH.half - PITCH.pop); scene.add(popPlane);
    const history = [], dotGeo = new THREE.CircleGeometry(0.05, 24);
    const controls = new THREE.OrbitControls(camera, canvas);
    controls.enableDamping = true; controls.dampingFactor = 0.08; controls.maxPolarAngle = 1.52; controls.enableZoom = false; controls.enablePan = false;
    const VIEWS = { batter:{c:[0.45,1.65,15.6], t:[0,0.3,-1]}, umpire:{c:[-0.6,2.1,-13.2], t:[0,0.5,7]}, side:{c:[8.8,2.4,4.5], t:[0,0.7,5]}, top:{c:[0.01,21,2.5], t:[0,0,2.5]} };
    let tween = null;
    const setView = (v, instant) => { const V = VIEWS[v]; tween = {fc:camera.position.clone(), ft:controls.target.clone(), tc:new THREE.Vector3(...V.c), tt:new THREE.Vector3(...V.t), k: instant ? 1 : 0}; if (instant){ camera.position.copy(tween.tc); controls.target.copy(tween.tt); } $$('#simViews button').forEach(b => b.classList.toggle('on', b.dataset.v === v)); };
    $$('#simViews button').forEach(b => b.addEventListener('click', () => setView(b.dataset.v)));
    const zoom = f => { const d = camera.position.clone().sub(controls.target); const L = clamp(d.length()*f, 3, 40); camera.position.copy(controls.target).addScaledVector(d.normalize(), L); tween = null; };
    $('#simZoomIn').addEventListener('click', () => zoom(0.8)); $('#simZoomOut').addEventListener('click', () => zoom(1.25));
    setView('batter', true); controls.update();
    let Dl = null, playT = 0, hold = 0;
    const resetStumps = () => { P.bat.stumps.forEach(s => s.rotation.x = 0); P.bat.bails.forEach(b => { b.position.copy(b.userData.home); b.rotation.set(0,0,0); }); };
    S = {
      set(d, L){
        Dl = d; playT = 0; hold = 0; resetStumps();
        const pts = d.pts.map(p=>new THREE.Vector3(p[0],p[1],p[2]));
        fullLine.geometry.dispose(); fullLine.geometry = new THREE.BufferGeometry().setFromPoints(pts); fullLine.computeLineDistances();
        trail.geometry.dispose(); trail.geometry = new THREE.BufferGeometry().setFromPoints(pts); trail.geometry.setDrawRange(0,0);
        ring.position.x = d.bounce.x; ring.position.z = d.bounce.z; ringMat.color.setHex(lengthColor(L));
        if (d.pop){ setSpriteText(heightTag, Math.round(d.pop.y*100) + ' cm at the bat', {size:40, h:0.13, color:'#FFFFFF', bg:'rgba(215,25,47,.95)', depthTest:false}); heightTag.position.set(d.pop.x + 0.75, d.pop.y + 0.12, PITCH.half - PITCH.pop); }
        const dot = new THREE.Mesh(dotGeo, new THREE.MeshBasicMaterial({color:lengthColor(L), transparent:true, opacity:.8}));
        dot.rotation.x = -Math.PI/2; dot.position.set(d.bounce.x, 0.015, d.bounce.z); scene.add(dot); history.push(dot);
        if (history.length > 10){ const o = history.shift(); scene.remove(o); o.material.dispose(); }
        history.forEach((h,i) => h.material.opacity = 0.2 + 0.6*(i+1)/history.length);
      },
      replay(){ playT = 0; hold = 0; resetStumps(); },
      batter(v){ bt.root.visible = v; }
    };
    addScene({canvas, renderer, scene, camera, page:'lab', baseFov:38, update(dt){
      if (tween && tween.k < 1){ tween.k = Math.min(1, tween.k + dt*1.5); const f = ease(tween.k); camera.position.lerpVectors(tween.fc, tween.tc, f); controls.target.lerpVectors(tween.ft, tween.tt, f); }
      controls.update();
      if (!Dl) return;
      const end = Dl.pts[Dl.pts.length-1][3];
      if (playT < end) playT += dt*(slow ? 0.25 : 1);
      else { hold += dt; if (hold > 2.2 && !reduced) S.replay(); }
      const p = samplePath(Dl.pts, Math.min(playT, end));
      ball.position.set(p[0], p[1], p[2]);
      ball.userData.spin.rotation.x -= dt*(slow ? 8 : 30);
      const n = Dl.pts.findIndex(q => q[3] >= playT); trail.geometry.setDrawRange(0, n < 0 ? Dl.pts.length : Math.max(2,n));
      ring.scale.setScalar(playT >= Dl.t1 ? 1 + Math.max(0, 0.6 - (playT - Dl.t1)*3) : 0.001);
      heightTag.visible = Dl.pop && playT >= Dl.pop.t;
      const lv = smooth(clamp((playT - Dl.t1*0.55)/(Dl.t1*0.5), 0, 1)) * (hold > 1.4 ? Math.max(0, 1 - (hold-1.4)*2) : 1);
      bt.apply(lv > 0 ? mixPose(addr, lift, lv) : addr);
      if (Dl.hit && playT >= end){ const q = Math.min(1, hold*2.2); const hs = Dl.st.x > 0.05 ? 2 : Dl.st.x < -0.05 ? 0 : 1;
        P.bat.stumps.forEach((s,i) => s.rotation.x = i===hs ? smooth(q)*0.55 : 0);
        P.bat.bails.forEach((b,i) => { const s = q*0.6, h0 = b.userData.home, dir = i ? 1 : -1; b.position.set(h0.x + dir*0.7*s, Math.max(0.01, h0.y + 2.6*s - 4.9*s*s), h0.z + 1.6*s); b.rotation.set(s*12*dir, s*5, s*8); }); }
    }});
  } else {
    canvas.parentElement.insertAdjacentHTML('beforeend','<p class="nogl">The 3D view needs WebGL. The numbers still work.</p>');
  }
  bindSeg('sSurf', v => { surf = v; run(); });
  bindSeg('sPlay', v => { slow = v === 'slow'; S && S.replay(); });
  bindSeg('sBatter', v => { showBatter = v === 'on'; S && S.batter(showBatter); });
  const setPreset = k => {
    const d = DELIVERIES[k]; ['speed','len','line','swing','seam'].forEach(f => el[f].value = d[f]); desc = d.d;
    $$('#simPresets button').forEach(b => b.classList.toggle('on', b.dataset.p === k)); run();
  };
  $$('#simPresets button').forEach(b => b.addEventListener('click', () => setPreset(b.dataset.p)));
  const run = (manual) => {
    if (manual){ $$('#simPresets button').forEach(b => b.classList.remove('on')); desc = 'Your own delivery. Change any setting and watch how it changes the result.'; }
    const o = {speed:+el.speed.value, len:+el.len.value, line:+el.line.value, swing:+el.swing.value, seam:+el.seam.value, surf};
    Object.values(el).forEach(fillRange);
    out.speed.textContent = o.speed + ' km/h';
    out.len.textContent = o.len.toFixed(1) + ' m · ' + lengthName(o.len);
    out.line.textContent = lineName(o.line);
    out.swing.textContent = o.swing === 0 ? 'None' : (o.swing > 0 ? 'Away ' : 'In ') + Math.abs(o.swing) + ' cm';
    out.seam.textContent = o.seam === 0 ? 'None' : (o.seam > 0 ? 'Away ' : 'In ') + Math.abs(o.seam) + ' cm';
    const d = computeDelivery(o);
    if (d.pop){
      $('#rTime').textContent = Math.round(d.pop.t*1000);
      $('#rHeight').textContent = Math.round(d.pop.y*100);
      $('#rSpeed').textContent = Math.round(d.pop.v*3.6);
      const y = d.pop.y;
      $('#rBody').textContent = y < 0.15 ? 'Toes' : y < 0.42 ? 'Shin' : y < 0.58 ? 'Knee' : y < 0.85 ? 'Thigh' : y < 1.0 ? 'Waist' : y < 1.22 ? 'Chest' : y < 1.38 ? 'Shoulder' : 'Head';
    }
    const v = $('#rVerdict'); v.dataset.s = d.hit ? 'hit' : 'miss';
    $('#rVerdictText').textContent = d.verdict || 'Does not reach the stumps';
    $('#rDesc').textContent = desc;
    S && S.set(d, o.len);
  };
  let rq = 0;
  Object.values(el).forEach(i => i.addEventListener('input', () => { cancelAnimationFrame(rq); rq = requestAnimationFrame(() => run(true)); }));
  $('#bowlBtn').addEventListener('click', () => S && S.replay());
  setPreset('outswing');
}

/* =========================================================
   FACILITIES — nets tour
   ========================================================= */
const FAC_SPOTS = [
  {k:'pitch', s:'Clay pitch', t:'Clay pitch', d:'A rolled mitti (clay) pitch, the kind young players meet in school and district matches, so the bounce in practice is the bounce on match day.', p:[0,0.4,1.5], cam:[-6.4,3.2,10.5], tgt:[0,0.5,1]},
  {k:'machine', s:'Bowling machine', t:'Bowling machine', d:'Set to the right pace for each level, so a batter gets ball after ball in the same spot to groove a shot. A coach runs it at all times, with helmets and pads compulsory.', p:[0.3,2.6,-9.6], cam:[4.6,3.1,-3.6], tgt:[0.3,1.5,-9.6]},
  {k:'nets', s:'Nets', t:'Nets', d:'A netted lane keeps every ball in, so batters play their shots freely while the rest of the group trains safely around them.', p:[2.1,3.5,4], cam:[1.5,8.5,22], tgt:[0,1.2,0]},
  {k:'drills', s:'Drills zone', t:'Fielding and fitness', d:'Open ground beside the nets for catching, ground fielding, keeping and the agility work that keeps young players injury-free.', p:[8,0.8,0], cam:[16,5.5,10], tgt:[8,0.3,0]},
  {k:'runup', s:'Run-up', t:'Bowlers’ run-up', d:'Room behind the bowling crease for a full run-up. Bowlers mark it, measure it and repeat it every Wednesday.', p:[-0.4,0.7,-15], cam:[-5.5,3.6,-25], tgt:[0,0.6,-11]}
];
function initFac(){
  const btns = $('#facBtns');
  btns.innerHTML = FAC_SPOTS.map(s => '<button type="button" data-v="'+s.k+'">'+s.s+'</button>').join('');
  let cur = 'pitch';
  let select = k => { cur = k; const s = FAC_SPOTS.find(x=>x.k===k); $('#facTitle').textContent = s.t; $('#facText').textContent = s.d; $('#facIdx').textContent = (FAC_SPOTS.indexOf(s)+1) + ' / ' + FAC_SPOTS.length; $$('#facBtns button').forEach(b => b.classList.toggle('on', b.dataset.v===k)); };
  const canvas = $('#facCanvas'), view = canvas.parentElement;
  if (hasGL){
    const renderer = makeRenderer(canvas, true);
    const scene = new THREE.Scene();
    const camera = new THREE.PerspectiveCamera(40, 1, 0.1, 900);
    outdoorWorld(scene, renderer, {boards:false, ground:120, rep:30, fogNear:45, fogFar:260});
    outdoorLights(scene, 18);
    const P = buildPitch(scene);
    makeNetCage(scene, {xs:[-2.1, 2.1], z0:-11, z1:12.6, h:3.3, roof:false});
    const mach = buildMachine(scene, 0.3, -9.6);
    const bt = createBatter(); bt.setHeight(1.45); bt.setBatLength(0.725);
    const pose = bt.address({height:1.45, batLen:0.725, guard:0, open:8, widthRatio:1.05, knee:18, lean:16, batAngle:16, grip:'top', weight:0});
    bt.apply(pose); bt.root.position.set(0, 0, PITCH.half); scene.add(bt.root);
    const coneM = new THREE.MeshStandardMaterial({color:0xF07A1A, roughness:.55});
    const cone = (x, z, p) => { const c = new THREE.Mesh(new THREE.ConeGeometry(0.12, 0.3, 16), coneM); c.position.set(x, 0.15, z); c.castShadow = true; (p||scene).add(c); };
    for (let z=-13; z>=-21; z-=2.6) cone(-0.6, z);
    const fz = new THREE.Group(); fz.position.set(8, 0, 0); scene.add(fz);
    for (let i=0;i<6;i++) cone((i%2)*1.6 - 0.8, -5 + i*1.8, fz);
    const stumpsF = stumpSet(); stumpsF.group.position.set(0.2, 0, 4.5); fz.add(stumpsF.group);
    const balls = [[7.2,0.05,-2],[8.6,0.05,1.2],[7.6,0.05,3.4]].map(p => { const b = makeBall(PITCH.ballR*1.6); b.position.set(p[0], 0.06, p[2]); scene.add(b); return b; });
    const tags = FAC_SPOTS.map(s => { const b = document.createElement('button'); b.type = 'button'; b.className = 'hotspot'; b.innerHTML = '<i></i><span>' + s.s + '</span>'; b.dataset.k = s.k; b.addEventListener('click', () => select(s.k)); view.appendChild(b); return {b, s, v:new THREE.Vector3(...s.p)}; });
    const controls = new THREE.OrbitControls(camera, canvas);
    controls.enableDamping = true; controls.maxPolarAngle = 1.45; controls.enableZoom = false; controls.enablePan = false;
    camera.position.set(-14, 9.5, 22); controls.target.set(0, 0.8, 0); controls.update();
    let tw = null;
    const base = select;
    select = (k, quiet) => { base(k); const s = FAC_SPOTS.find(x=>x.k===k); if (!quiet) tw = {fc:camera.position.clone(), ft:controls.target.clone(), tc:new THREE.Vector3(...s.cam), tt:new THREE.Vector3(...s.tgt), k:0}; tags.forEach(t => t.b.classList.toggle('on', t.s.k===k)); };
    let idleT = 0;
    controls.addEventListener('start', () => { idleT = -6; tw = null; });
    const pv = new THREE.Vector3();
    addScene({canvas, renderer, scene, camera, page:'facilities', baseFov:40, update(dt){
      idleT += dt;
      mach.children.forEach(c => { if (c.userData.wheel) c.rotation.x += dt*10; });
      if (tw && tw.k < 1){ tw.k = Math.min(1, tw.k + dt*0.8); const f = ease(tw.k); camera.position.lerpVectors(tw.fc, tw.tc, f); controls.target.lerpVectors(tw.ft, tw.tt, f); }
      else if (!tw && idleT > 0 && !reduced){ const a = dt*0.05; const x = camera.position.x - controls.target.x, z = camera.position.z - controls.target.z; camera.position.x = controls.target.x + x*Math.cos(a) - z*Math.sin(a); camera.position.z = controls.target.z + x*Math.sin(a) + z*Math.cos(a); }
      controls.update();
      const W = canvas.clientWidth, H = canvas.clientHeight;
      tags.forEach(t => { pv.copy(t.v).project(camera); const vis = pv.z < 1 && Math.abs(pv.x) < 0.95 && Math.abs(pv.y) < 0.92; t.b.style.opacity = vis ? 1 : 0; t.b.style.pointerEvents = vis ? '' : 'none'; t.b.style.transform = 'translate(' + ((pv.x+1)/2*W) + 'px,' + ((1-pv.y)/2*H) + 'px) translate(-50%,-50%)'; });
    }});
  } else {
    view.insertAdjacentHTML('beforeend','<p class="nogl">The 3D tour needs WebGL. Use the stops below to read about each area.</p>');
  }
  $$('#facBtns button').forEach(b => b.addEventListener('click', () => select(b.dataset.v)));
  const step = d => { const i = FAC_SPOTS.findIndex(s => s.k === cur); select(FAC_SPOTS[(i + d + FAC_SPOTS.length) % FAC_SPOTS.length].k); };
  $('#facPrev').addEventListener('click', () => step(-1));
  $('#facNext').addEventListener('click', () => step(1));
  select('pitch', true);
}

/* =========================================================
   NETS CHALLENGE — 3D batting game
   ========================================================= */
const GAME_LEVELS = {
  easy:   {n:'Easy',   speed:[78,92],   len:[3.5,7.5], line:[-0.04,0.18], swing:6,  seam:0,  win:0.13, ts:0.62, slower:0,    yorker:0,   bouncer:0},
  medium: {n:'Medium', speed:[104,122], len:[1.5,9.5], line:[-0.1,0.24],  swing:16, seam:8,  win:0.085,ts:0.78, slower:0.08, yorker:0.1, bouncer:0.1},
  hard:   {n:'Hard',   speed:[128,146], len:[0.8,10.8],line:[-0.14,0.28], swing:26, seam:14, win:0.055,ts:0.92, slower:0.16, yorker:0.18,bouncer:0.18}
};
function initGame(){
  const canvas = $('#gameCanvas'), host = $('#gameStage');
  const ui = {menu:$('#gMenu'), comm:$('#gComm'), score:$('#gScore'), balls:$('#gBalls'), sr:$('#gSR'), best:$('#gBest'), over:$('#gOver'), meter:$('#gMeter'), mark:$('#gMark'), mlbl:$('#gMeterLbl'), swing:$('#gSwing'), mute:$('#gMute'), lvl:$('#gLevelLbl'), light:$('#gLight')};
  let level = 'medium', muted = store.get('vx-game-mute', false);
  const best = store.get('vx-game-best', {easy:0, medium:0, hard:0});
  const S = {state:'menu', runs:0, wkts:0, balls:0, fours:0, sixes:0, over:[], t:0, D:null, swingAt:null, hit:null, wait:0, res:null};
  bindSeg('gLevels', v => { level = v; showBest(); });
  function showBest(){ ui.best.textContent = best[level] || 0; $$('#gLevels button').forEach(b => { const s = b.querySelector('small'); if (s) s.textContent = 'Best ' + (best[b.dataset.v] || 0); }); }
  ui.mute.addEventListener('click', () => { muted = !muted; store.set('vx-game-mute', muted); ui.mute.classList.toggle('off', muted); ui.mute.setAttribute('aria-label', muted ? 'Sound off' : 'Sound on'); });
  ui.mute.classList.toggle('off', muted);
  // ---- sound ----
  let actx = null;
  function sfx(kind){
    if (muted) return;
    try{
      actx = actx || new (window.AudioContext || window.webkitAudioContext)();
      const t = actx.currentTime, o = actx.createOscillator(), g = actx.createGain(), f = actx.createBiquadFilter();
      o.connect(f); f.connect(g); g.connect(actx.destination);
      if (kind === 'hit'){ o.type='triangle'; o.frequency.setValueAtTime(820,t); o.frequency.exponentialRampToValueAtTime(180,t+.09); f.type='lowpass'; f.frequency.value=2400; g.gain.setValueAtTime(.55,t); g.gain.exponentialRampToValueAtTime(.001,t+.14); o.start(t); o.stop(t+.15); }
      else if (kind === 'stumps'){ o.type='square'; o.frequency.setValueAtTime(320,t); o.frequency.exponentialRampToValueAtTime(90,t+.25); f.type='lowpass'; f.frequency.value=1200; g.gain.setValueAtTime(.3,t); g.gain.exponentialRampToValueAtTime(.001,t+.3); o.start(t); o.stop(t+.32); }
      else if (kind === 'cheer'){ o.type='sawtooth'; o.frequency.setValueAtTime(520,t); o.frequency.linearRampToValueAtTime(880,t+.35); f.type='bandpass'; f.frequency.value=900; g.gain.setValueAtTime(.0001,t); g.gain.linearRampToValueAtTime(.12,t+.05); g.gain.exponentialRampToValueAtTime(.001,t+.6); o.start(t); o.stop(t+.62); }
      else { o.type='sine'; o.frequency.setValueAtTime(260,t); g.gain.setValueAtTime(.12,t); g.gain.exponentialRampToValueAtTime(.001,t+.08); o.start(t); o.stop(t+.09); }
    }catch(e){}
  }
  if (!hasGL){ host.insertAdjacentHTML('beforeend','<p class="nogl" style="color:#F1DFAE">The game needs WebGL, which this browser has turned off.</p>'); return; }

  const renderer = makeRenderer(canvas, true);
  const scene = new THREE.Scene();
  const camera = new THREE.PerspectiveCamera(46, 1, 0.05, 900);
  outdoorWorld(scene, renderer, {boards:66, flood:80, ground:140, rep:34, fogNear:80, fogFar:320});
  const sun = outdoorLights(scene, 8);
  const P = buildPitch(scene);
  const rope = new THREE.Mesh(new THREE.TorusGeometry(58, 0.22, 8, 200), new THREE.MeshStandardMaterial({color:0xF7F1E3, roughness:.6}));
  rope.rotation.x = -Math.PI/2; rope.position.y = 0.18; scene.add(rope);
  // 30-yard circle dots
  { const g = new THREE.CircleGeometry(0.35, 10); const m = new THREE.MeshBasicMaterial({color:0xFFFFFF}); const pts = []; for (let a=0;a<Math.PI*2;a+=Math.PI/40) pts.push([Math.cos(a)*27.4, Math.sin(a)*30]); const inst = new THREE.InstancedMesh(g, m, pts.length); const m4 = new THREE.Matrix4(), q = new THREE.Quaternion().setFromEuler(new THREE.Euler(-Math.PI/2,0,0)); pts.forEach((p,i) => { m4.compose(new THREE.Vector3(p[0],0.03,p[1]), q, new THREE.Vector3(1,1,1)); inst.setMatrixAt(i, m4); }); scene.add(inst); }
  // bowling machine at the bowler's end
  const mach = buildMachine(scene, 0.3, -9.6);
  const lampMat = new THREE.MeshBasicMaterial({color:0x333333});
  const lamp = new THREE.Mesh(new THREE.SphereGeometry(0.07, 16, 12), lampMat); lamp.position.set(0.3, 2.2, -9.25); scene.add(lamp);
  // batter
  const bt = createBatter(); bt.setHeight(1.66); bt.setBatLength(0.85); bt.root.position.z = PITCH.half; scene.add(bt.root);
  const A = bt.address({height:1.66, batLen:0.85, guard:-0.05, open:6, widthRatio:1.05, knee:18, lean:16, batAngle:16, grip:'top', weight:0});
  const FR = shotFrames('drive', A, 1.66, 0.85, 'high');
  const BL = FR[1][1], ST = FR[2][1], CT = FR[3][1], FO = FR[4][1];
  bt.apply(A);
  const ball = makeBall(PITCH.ballR*1.25); scene.add(ball); ball.visible = false;
  const trail = new THREE.Line(new THREE.BufferGeometry(), new THREE.LineBasicMaterial({color:0xF1DFAE, transparent:true, opacity:.75})); scene.add(trail);
  const trailPts = [];
  const ring = new THREE.Mesh(new THREE.RingGeometry(0.07,0.12,32), new THREE.MeshBasicMaterial({color:0xD9BC72, transparent:true, opacity:0, side:THREE.DoubleSide})); ring.rotation.x = -Math.PI/2; ring.position.y = 0.016; scene.add(ring);
  const burst = new THREE.Points(new THREE.BufferGeometry(), new THREE.PointsMaterial({color:0xF1DFAE, size:0.06, transparent:true, opacity:0, depthWrite:false}));
  { const a = [], v = []; for (let i=0;i<70;i++){ a.push(0,0,0); const d = new THREE.Vector3(Math.random()-.5, Math.random()*.8, Math.random()-.5).normalize().multiplyScalar(1+Math.random()*2.5); v.push(d); } burst.geometry.setAttribute('position', new THREE.Float32BufferAttribute(a, 3)); burst.userData.v = v; }
  scene.add(burst);
  const CAM = {pos:new THREE.Vector3(0.55, 2.05, 15.2), tgt:new THREE.Vector3(0, 0.55, -2)};
  const camPos = CAM.pos.clone(), camTgt = CAM.tgt.clone();
  // ---- helpers ----
  const rnd = (a,b) => a + Math.random()*(b-a);
  function newDelivery(){
    const L = GAME_LEVELS[level];
    let o = {speed:rnd(...L.speed), len:rnd(...L.len), line:rnd(...L.line), swing:rnd(-L.swing, L.swing), seam:rnd(-L.seam, L.seam), surf:'turf'};
    const r = Math.random();
    if (r < L.yorker){ o.len = rnd(0.6, 1.6); o.line = rnd(-0.06, 0.1); }
    else if (r < L.yorker + L.bouncer){ o.len = rnd(9.8, 11); o.line = rnd(-0.05, 0.18); }
    if (Math.random() < L.slower) o.speed *= 0.72;
    return computeDelivery(o);
  }
  function setLamp(c){ lampMat.color.setHex(c); }
  function commentary(text, kind){ ui.comm.textContent = text; ui.comm.dataset.k = kind || ''; ui.comm.classList.remove('show'); void ui.comm.offsetWidth; ui.comm.classList.add('show'); }
  function updateHud(){
    ui.score.innerHTML = S.runs + '<span>/' + S.wkts + '</span>';
    ui.balls.textContent = S.balls;
    ui.sr.textContent = S.balls ? Math.round(S.runs / S.balls * 100) : 0;
    ui.over.innerHTML = S.over.slice(-6).map(o => '<i data-k="'+o+'">'+(o === 0 ? '•' : o)+'</i>').join('') + '<em>' + Array(Math.max(0, 6 - S.over.slice(-6).length)).fill('<i class="e"></i>').join('') + '</em>';
  }
  function showMeter(err, win, whiff){
    const x = clamp(err / (win*2), -1, 1);
    ui.mark.style.left = (50 + x*48) + '%';
    ui.meter.classList.add('show'); ui.meter.dataset.q = whiff ? 'miss' : Math.abs(err) < win*0.35 ? 'perfect' : Math.abs(err) < win ? 'good' : 'miss';
    const ms = Math.round(Math.abs(err)*1000 / GAME_LEVELS[level].ts);
    ui.mlbl.textContent = Math.abs(err) < win*0.2 ? 'Perfect timing' : (err < 0 ? 'Early by ' : 'Late by ') + ms + ' ms';
  }
  // ---- flow ----
  function start(){
    S.runs = 0; S.wkts = 0; S.balls = 0; S.fours = 0; S.sixes = 0; S.over = [];
    ui.menu.hidden = true; host.classList.add('playing'); ui.lvl.textContent = GAME_LEVELS[level].n;
    updateHud(); showBest(); commentary('Take guard. Click, tap or press Space to swing.', 'info');
    nextBall(1.6);
  }
  function nextBall(delay){
    S.state = 'ready'; S.wait = delay ?? 1.3; S.swingAt = null; S.hit = null; S.res = null;
    ball.visible = false; trailPts.length = 0; trail.geometry.setFromPoints([]); ring.material.opacity = 0;
    P.bat.stumps.forEach(s => s.rotation.set(0,0,0)); P.bat.bails.forEach(b => { b.position.copy(b.userData.home); b.rotation.set(0,0,0); });
    ui.meter.classList.remove('show');
    setLamp(0xD98A00);
  }
  function bowl(){ S.D = newDelivery(); S.t = 0; S.state = 'flight'; ball.visible = true; setLamp(0x2ECC71); sfx('tick'); }
  function swing(){
    if (S.state === 'menu' || S.state === 'over') return;
    if (S.state !== 'flight' || S.swingAt !== null) return;
    S.swingAt = S.t;
    const D = S.D, arrival = D.pop ? D.pop.t : D.t1 + 0.2, win = GAME_LEVELS[level].win;
    const err = S.t + 0.15 - arrival;
    const reach = D.pop && D.pop.y < 1.75 && Math.abs(D.pop.x) < 0.75;
    if (Math.abs(err) <= win && reach){
      S.hit = {err, q: 1 - Math.abs(err)/win, at: arrival};
    }
    showMeter(err, win, !(Math.abs(err) <= win && reach));
  }
  function outcome(h){
    const q = h.q, win = GAME_LEVELS[level].win;
    const side = clamp(h.err / win, -1, 1);
    let theta = side * 72 * DEG + rnd(-10, 10) * DEG;
    let r;
    if (q > 0.72) r = {runs:6, v:31, phi:34*DEG, roll:0, text:['Into the stands! SIX.','That is huge. SIX!','Out of the ground. Maximum!'], kind:'six'};
    else if (q > 0.45) r = {runs:4, v:30, phi:5*DEG, roll:2.4, text:['Pierces the field. FOUR.','Timed beautifully. FOUR!','Races away to the rope. FOUR.'], kind:'four'};
    else if (q > 0.2){ const two = Math.random() < .5; r = {runs: two ? 2 : 1, v: two ? 17 : 13, phi:9*DEG, roll:7, text: two ? ['Into the gap, they come back for two.'] : ['Worked away for a single.','Nudged into the gap, one run.'], kind:'run'}; }
    else if (Math.random() < 0.38){ r = {runs:0, wicket:true, v:15, phi:6*DEG, roll:9, edge:true, text:['Edged and caught behind! OUT.','Thin edge, gone! Caught behind.'], kind:'out'}; theta = Math.PI + rnd(-.3,.3); }
    else { r = {runs:1, v:11, phi:4*DEG, roll:8, edge:true, text:['Off the edge, they scamper a single.'], kind:'run'}; theta = Math.PI*0.75*Math.sign(side||1); }
    r.dir = new THREE.Vector3(Math.sin(theta), 0, -Math.cos(theta));
    return r;
  }
  function settle(res){
    S.balls++;
    if (res.wicket){ S.wkts++; S.over.push('W'); }
    else { S.runs += res.runs; S.over.push(res.runs); if (res.runs === 4) S.fours++; if (res.runs === 6) S.sixes++; }
    commentary(res.text[Math.floor(Math.random()*res.text.length)], res.kind);
    updateHud();
    if (res.runs >= 4) sfx('cheer');
    if (S.wkts >= 3){ S.state = 'result'; S.wait = 2.2; S.after = gameOver; }
    else { S.state = 'result'; S.wait = res.runs === 6 ? 2.6 : 1.8; S.after = () => nextBall(); }
  }
  function gameOver(){
    S.state = 'over'; host.classList.remove('playing');
    const isBest = S.runs > (best[level] || 0);
    if (isBest){ best[level] = S.runs; store.set('vx-game-best', best); }
    showBest();
    $('#gMenuTitle').innerHTML = isBest && S.runs > 0 ? 'New best: <span>' + S.runs + '</span>' : 'All out for <span>' + S.runs + '</span>';
    $('#gMenuText').textContent = S.runs + ' runs from ' + S.balls + ' balls on ' + GAME_LEVELS[level].n + ' · ' + S.fours + ' fours, ' + S.sixes + ' sixes. ' + (S.runs >= 30 ? 'Proper batting. Imagine it with a coach.' : 'Timing comes with practice. That is what the nets are for.');
    $('#gStart').textContent = 'Play again';
    $('#gApply').hidden = false;
    ui.menu.hidden = false;
  }
  $('#gStart').addEventListener('click', start);
  ui.swing.addEventListener('pointerdown', e => { e.preventDefault(); e.stopPropagation(); swing(); });
  canvas.addEventListener('pointerdown', e => { if (S.state === 'flight' || S.state === 'ready') { e.preventDefault(); swing(); } });
  let inView = false;
  new IntersectionObserver(es => { inView = es[0].intersectionRatio > 0.4; }, {threshold:[0,0.4,0.8]}).observe(host);
  document.addEventListener('keydown', e => {
    if (e.code !== 'Space' && e.code !== 'Enter') return;
    if (!inView || /INPUT|TEXTAREA|SELECT/.test(document.activeElement.tagName)) return;
    if (e.code === 'Enter' && document.activeElement.tagName === 'BUTTON') return;
    if (S.state === 'menu' || S.state === 'over'){ if (e.code === 'Enter'){ e.preventDefault(); start(); } return; }
    e.preventDefault(); swing();
  });
  // ---- main update ----
  let swingClock = 0;
  const v3 = new THREE.Vector3();
  addScene({canvas, renderer, scene, camera, page:'game', baseFov:46,
    onResize(w, h){ if (h > w*1.1){ CAM.pos.set(0.35, 3.1, 19.2); CAM.tgt.set(0, 0.2, 1.5); } else { CAM.pos.set(0.55, 2.05, 15.2); CAM.tgt.set(0, 0.55, -2); } },
    update(dt, time){
    const L = GAME_LEVELS[level];
    // machine wheels spin
    mach.children.forEach(c => { if (c.userData.wheel) c.rotation.x += dt * (S.state === 'menu' ? 2 : 18); });
    let camFollow = null;
    if (S.state === 'menu' || S.state === 'over'){
      const a = time*0.08; camPos.set(Math.sin(a)*9 + 2, 4.2, 12 + Math.cos(a)*3); camTgt.set(0, 0.8, 1);
      bt.apply(A);
    } else if (S.state === 'ready'){
      S.wait -= dt;
      const k = smooth(clamp(1 - S.wait/1.2, 0, 1));
      bt.apply(mixPose(A, BL, k));
      if (S.wait <= 0) bowl();
    } else if (S.state === 'flight'){
      S.t += dt * L.ts;
      const D = S.D, end = D.pts[D.pts.length-1][3];
      // swing animation
      if (S.swingAt !== null){
        const sw = (S.t - S.swingAt);
        const pose = sw < 0.08 ? mixPose(BL, ST, ease(sw/0.08)) : sw < 0.15 ? mixPose(ST, CT, ease((sw-0.08)/0.07)) : sw < 0.42 ? mixPose(CT, FO, ease((sw-0.15)/0.27)) : FO;
        bt.apply(pose);
      } else bt.apply(BL);
      // contact
      if (S.hit && S.t >= S.hit.at){
        const p = samplePath(D.pts, S.hit.at);
        const res = outcome(S.hit);
        const vel = res.dir.clone().multiplyScalar(res.v * Math.cos(res.phi)); vel.y = res.v * Math.sin(res.phi);
        S.res = res; S.fly = {p:new THREE.Vector3(p[0], p[1], p[2]), v:vel, t:0, roll:res.roll, done:false};
        S.state = 'hit'; sfx('hit');
        burst.position.copy(S.fly.p); burst.material.opacity = 1; burst.userData.t = 0;
        trailPts.length = 0;
      } else {
        const p = samplePath(D.pts, Math.min(S.t, end));
        ball.position.set(p[0], p[1], p[2]);
        ball.userData.spin.rotation.x -= dt*30;
        if (S.t >= D.t1){ ring.position.set(D.bounce.x, 0.016, D.bounce.z); ring.material.opacity = Math.max(0, 0.9 - (S.t - D.t1)*1.2); }
        if (S.t >= end){
          if (D.hit){
            sfx('stumps'); S.balls++; S.wkts++; S.over.push('W');
            commentary(S.swingAt === null ? 'Left it and lost the off stump. BOWLED.' : 'Beaten all ends up. BOWLED!', 'out');
            updateHud(); S.state = 'result'; S.wait = 2; S.stumpsHit = D.st; S.after = S.wkts >= 3 ? gameOver : () => nextBall();
            if (S.swingAt === null) showMeter(0.3, L.win, true);
          } else {
            S.balls++; S.over.push(0); updateHud();
            commentary(S.swingAt === null ? (Math.abs(D.st ? D.st.x : 1) > 0.3 ? 'Well left outside off. Dot ball.' : 'Shoulders arms. Just over the top. Dot ball.') : 'Played and missed! Dot ball.', 'dot');
            if (S.swingAt === null) ui.meter.classList.remove('show');
            S.state = 'result'; S.wait = 1.4; S.after = () => nextBall();
          }
        }
      }
    } else if (S.state === 'hit'){
      const F = S.fly, dtt = dt * Math.max(L.ts, 0.85);
      if (!F.done){
        F.v.y -= G*dtt; F.p.addScaledVector(F.v, dtt);
        if (F.p.y < PITCH.ballR){ F.p.y = PITCH.ballR; if (F.v.y < -1.5) F.v.y = -F.v.y*0.42; else F.v.y = 0; const sp = Math.hypot(F.v.x, F.v.z); if (F.v.y === 0 && sp > 0){ const ns = Math.max(0, sp - F.roll*dtt); F.v.x *= ns/sp; F.v.z *= ns/sp; } }
        F.t += dtt;
        const r = Math.hypot(F.p.x, F.p.z);
        if ((S.res.runs === 4 && r > 57.5) || (S.res.runs === 6 && (F.p.y < 4 && r > 64 || F.t > 3.2)) || (S.res.runs < 4 && Math.hypot(F.v.x, F.v.z) < 0.4) || F.t > 4.5){ F.done = true; settle(S.res); }
      }
      ball.position.copy(F.p); ball.userData.spin.rotation.x -= dt*20;
      trailPts.push(F.p.clone()); if (trailPts.length > 60) trailPts.shift(); trail.geometry.setFromPoints(trailPts);
      bt.apply(FO);
      if (S.res.runs >= 4) camFollow = F.p;
    } else if (S.state === 'result'){
      S.wait -= dt;
      if (S.stumpsHit){ const q = clamp(2 - S.wait, 0, 1); const hs = S.stumpsHit.x > 0.05 ? 2 : S.stumpsHit.x < -0.05 ? 0 : 1; P.bat.stumps.forEach((s,i) => s.rotation.x = i===hs ? smooth(q)*0.6 : 0); P.bat.bails.forEach((b,i) => { const s = q*0.7, h0 = b.userData.home, dir = i ? 1 : -1; b.position.set(h0.x + dir*0.8*s, Math.max(0.01, h0.y + 3*s - 4.9*s*s), h0.z + 2*s); b.rotation.set(s*12*dir, s*5, s*8); }); }
      if (S.fly && S.res && S.res.runs >= 4) camFollow = S.fly.p;
      if (S.wait <= 0){ S.stumpsHit = null; S.fly = null; const f = S.after; S.after = null; f && f(); }
    }
    if (burst.material.opacity > 0){ burst.userData.t += dt; const arr = burst.geometry.attributes.position.array; burst.userData.v.forEach((v,i) => { arr[i*3] = v.x*burst.userData.t; arr[i*3+1] = v.y*burst.userData.t; arr[i*3+2] = v.z*burst.userData.t; }); burst.geometry.attributes.position.needsUpdate = true; burst.material.opacity = Math.max(0, 1 - burst.userData.t*2.2); }
    // camera
    if (S.state !== 'menu' && S.state !== 'over'){
      if (camFollow){ v3.copy(camFollow); camTgt.lerp(v3, 0.08); camPos.lerp(new THREE.Vector3(camFollow.x*0.35 + 0.6, 3.4 + camFollow.y*0.25, 15.5 + Math.min(0, camFollow.z)*0.15), 0.04); }
      else { camPos.lerp(CAM.pos, 0.08); camTgt.lerp(CAM.tgt, 0.1); }
    }
    camera.position.lerp(camPos, 0.12);
    camera.lookAt(camTgt);
    sun.position.set(-8, 14, 7 + camTgt.z*0.3); sun.target.position.set(camTgt.x*0.3, 0, camTgt.z*0.3);
  }});
  showBest(); updateHud(); setLamp(0x333333);
  if (/[?&]debug/.test(location.search)) window.__vxg = {S, swing, level:() => level};
}

/* =========================================================
   BOOT — each 3D piece starts when it nears the screen
   ========================================================= */
function lazy(sel, fn, margin){
  const el = $(sel); if (!el) return;
  let done = false; const run = () => { if (done) return; done = true; try{ fn(); }catch(e){ console.error(e); } };
  if (!('IntersectionObserver' in window)) return run();
  const io = new IntersectionObserver(es => { if (es.some(e => e.isIntersecting)){ io.disconnect(); run(); } }, {rootMargin:(margin||900)+'px 0px'});
  io.observe(el);
}
lazy('#delivery', initStory, 1400);
lazy('#lab-delivery', initSim);
lazy('#lab-stance', initStance);
lazy('#ground', initFac);
lazy('#play', initGame);
const kit3d = $('#kitTo3d');
if (kit3d) kit3d.addEventListener('click', () => { const s = $('#stHeight'), h = $('#hgt'); if (s && h){ s.value = clamp(+h.value, 105, 190); s.dispatchEvent(new Event('input')); } });

})();
