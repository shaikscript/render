const tb=document.getElementById('themeBtn')||document.getElementById('themeBtnG');
tb&&tb.addEventListener('click',()=>{const t=document.documentElement.dataset.bsTheme==='dark'?'light':'dark';document.documentElement.dataset.bsTheme=t;localStorage.setItem('theme',t)});
