(function(){var el=document.getElementById('intro');
  var rm=window.matchMedia&&matchMedia('(prefers-reduced-motion: reduce)').matches;
  window.__vxIntro=!rm;
  if(window.__vxIntro){el.hidden=false;document.documentElement.style.overflow='hidden'}
})();
