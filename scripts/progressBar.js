window.onscroll = function() {
    let scrollTop = document.documentElement.scrollTop || document.body.scrollTop;
    let scrollHeight = document.documentElement.scrollHeight - document.documentElement.clientHeight;
    let scrollPercent = (scrollTop / scrollHeight) * 100;
  
    document.getElementById("progressBar").style.width = Math.min(scrollPercent, 100) + "%";
  };