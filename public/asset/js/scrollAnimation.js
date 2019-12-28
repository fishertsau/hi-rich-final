// native smooth scrolling for Chrome, Firefox & Opera
// @see: https://caniuse.com/#feat=css-scroll-behavior
const nativeSmoothScrollTo = function(elem, isPaddingHeader = false) {
    isPaddingHeader ? elem.offsetTop + 83 : elem.offsetTop;
    const moveTo = isPaddingHeader ? elem.getBoundingClientRect().top - 83 : elem.getBoundingClientRect().top;
    window.scroll({
        behavior: 'smooth',
        left: 0,
        top: moveTo + window.pageYOffset
    });
};

// polyfilled smooth scrolling for IE, Edge & Safari
const smoothScrollTo = function(to, duration) {
    const element = document.scrollingElement || document.documentElement,
        start = element.scrollTop,
        change = to - start,
        startDate = +new Date();

    // t = current time
    // b = start value
    // c = change in value
    // d = duration
    const easeInOutQuad = function(t, b, c, d) {
        t /= d/2;
        if (t < 1) return c/2*t*t + b;
        t--;
        return -c/2 * (t*(t-2) - 1) + b;
    };

    const animateScroll = function(_) {
        const currentDate = +new Date();
        const currentTime = currentDate - startDate;
        element.scrollTop = parseInt(easeInOutQuad(currentTime, start, change, duration));
        if(currentTime < duration) {
            requestAnimationFrame(animateScroll);
        }
        else {
            element.scrollTop = to;
        }
    };
    animateScroll();
};

// detect support for the behavior property in ScrollOptions
const supportsNativeSmoothScroll = 'scrollBehavior' in document.documentElement.style;

// smooth scrolling stub
const scrollToElem = function (elemSelector, isPaddingHeader = false) {
    if (!elemSelector) {
        return;
    }

    const elem = document.querySelector(elemSelector);
    const moveTo = isPaddingHeader ? elem.offsetTop - 83 : elem.offsetTop;
    if (elem) {
        if (supportsNativeSmoothScroll) {
            nativeSmoothScrollTo(elem, isPaddingHeader);
        } else {
            smoothScrollTo(moveTo, 600);
        }
    }
};


const mobileTabScrollToElem = function (elemSelector, isPaddingHeader = false) {
    if (!elemSelector) {
        return;
    }

    const elem = document.querySelector(elemSelector);
}

function addButtonEvent(){
    if(!(document.body.scrollHeight > window.outerHeight)){
        document.querySelector('.btn-go-bottom').style.display = "none"
        return;
    }
    window.onscroll = function (e) {
        // 當頁面的滾動條滾動時執行
       if(window.pageYOffset + window.outerHeight > document.querySelector('footer').offsetTop){
            showBtn(false)
       }else{
            showBtn(true)
       }
    }
}

var isShowBtn = true;
function showBtn(isShow){
    if(isShow === isShowBtn){
        return;
    }
    isShowBtn = isShow;
    if(isShow){
        
        document.querySelector('.btn-go-bottom').classList.remove('ishide')
    }else {
        document.querySelector('.btn-go-bottom').classList.add('ishide')
    }
}

var goBottom = function(){
    scrollToElem('footer');
}

var goTop = function(){
    scrollToElem('body');
}


addButtonEvent();
// use scrollToElem('footer') 滑到底部