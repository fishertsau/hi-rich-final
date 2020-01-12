function initTns(){
  var slider = tns({
    container: '.my-slider',
    items: 1,
    slideBy: 'page',
    navPosition: 'bottom',
    speed: 300,
    autoplay: true,
    autoplayButtonOutput: false,
    mouseDrag: true,
    controlsContainer: "#customize-controls",
  });
}
var wEl = document.body;

// todo: remove this
function initTabEvent(){
  const list = document.querySelectorAll('a[tab-title]');
  if(list){
    list.forEach(function(item){
      item.addEventListener('click', function(cel){
        cel.target.nextElementSibling.classList.toggle('is-open')
        wEl.addEventListener('click',function(wel) {
          toggleIsOpen(wel, cel);
        }, false);
      })  
    });
  }
}

function toggleIsOpen(wel, cel){
  if(!wel.target.isEqualNode(cel.target)){
    cel.target.nextElementSibling.classList.remove('is-open')
    wEl.removeEventListener('click', toggleIsOpen, false)
  }
}

initTabEvent();