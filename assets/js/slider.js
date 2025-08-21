(function(){
  function initSimpleSlider(selector, intervalMs){
    const slider = document.querySelector(selector);
    if(!slider) return;
    const slides = Array.from(slider.querySelectorAll('.slide'));
    if(slides.length === 0) return;

    let current = 0;
    const prevBtn = slider.querySelector('.slider-prev');
    const nextBtn = slider.querySelector('.slider-next');

    // Dots
    let dotsWrap = slider.querySelector('.slider-dots');
    if(!dotsWrap){
      dotsWrap = document.createElement('div');
      dotsWrap.className = 'slider-dots';
      slider.appendChild(dotsWrap);
    }
    const dots = slides.map((_s, i) => {
      const b = document.createElement('button');
      b.type = 'button';
      b.className = 'dot';
      b.setAttribute('aria-label', 'Slide ' + (i+1));
      b.addEventListener('click', () => show(i));
      dotsWrap.appendChild(b);
      return b;
    });

    function show(i){
      current = (i + slides.length) % slides.length;
      slides.forEach((s, idx) => s.classList.toggle('active', idx === current));
      dots.forEach((d, idx) => d.classList.toggle('active', idx === current));
    }

    function next(){ show(current + 1); }
    function prev(){ show(current - 1); }

    prevBtn && prevBtn.addEventListener('click', prev);
    nextBtn && nextBtn.addEventListener('click', next);

    let timer = null;
    function start(){
      if(intervalMs && intervalMs > 0){
        stop();
        timer = setInterval(next, intervalMs);
      }
    }
    function stop(){ if(timer) { clearInterval(timer); timer = null; } }

    slider.addEventListener('mouseenter', stop);
    slider.addEventListener('mouseleave', start);

    // Initialize
    show(0);
    start();
  }

  window.initSimpleSlider = initSimpleSlider;
})();

// Search overlay
window.addEventListener('DOMContentLoaded', function(){
  var openBtn = document.getElementById('btnOpenSearch');
  var closeBtn = document.getElementById('btnCloseSearch');
  var overlay = document.getElementById('searchOverlay');
  var input = document.getElementById('searchInput');
  if(openBtn && overlay){
    openBtn.addEventListener('click', function(){
      overlay.classList.add('active');
      setTimeout(function(){ input && input.focus(); }, 320);
    });
  }
  if(closeBtn && overlay){
    closeBtn.addEventListener('click', function(){ overlay.classList.remove('active'); });
  }
  if(overlay){
    overlay.addEventListener('click', function(e){
      if(e.target === overlay){ overlay.classList.remove('active'); }
    });
    document.addEventListener('keydown', function(e){
      if(e.key === 'Escape'){ overlay.classList.remove('active'); }
    });
  }
});


