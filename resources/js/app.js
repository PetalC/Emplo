import {Alpine, Livewire} from '../../vendor/livewire/livewire/dist/livewire.esm';
import ToastComponent from '../../vendor/usernotnull/tall-toasts/resources/js/tall-toasts';
import Splide from '@splidejs/splide';
window.Splide = Splide;

Alpine.plugin(ToastComponent);

Alpine.directive('clipboard', (el) => {
    let text = el.textContent;

    el.addEventListener('click', () => {
        navigator.clipboard.writeText(text);
        el.innerText = 'Copied!';
        setTimeout(() => {
            el.innerText = text;
        }, 500);
    });
});

Livewire.start();

const EasingFunctions = {
    // no easing, no acceleration
    linear: t => t,
    // accelerating from zero velocity
    easeInQuad: t => t*t,
    // decelerating to zero velocity
    easeOutQuad: t => t*(2-t),
    // acceleration until halfway, then deceleration
    easeInOutQuad: t => t<.5 ? 2*t*t : -1+(4-2*t)*t,
    // accelerating from zero velocity
    easeInCubic: t => t*t*t,
    // decelerating to zero velocity
    easeOutCubic: t => (--t)*t*t+1,
    // acceleration until halfway, then deceleration
    easeInOutCubic: t => t<.5 ? 4*t*t*t : (t-1)*(2*t-2)*(2*t-2)+1,
    // accelerating from zero velocity
    easeInQuart: t => t*t*t*t,
    // decelerating to zero velocity
    easeOutQuart: t => 1-(--t)*t*t*t,
    // acceleration until halfway, then deceleration
    easeInOutQuart: t => t<.5 ? 8*t*t*t*t : 1-8*(--t)*t*t*t,
    // accelerating from zero velocity
    easeInQuint: t => t*t*t*t*t,
    // decelerating to zero velocity
    easeOutQuint: t => 1+(--t)*t*t*t*t,
    // acceleration until halfway, then deceleration
    easeInOutQuint: t => t<.5 ? 16*t*t*t*t*t : 1+16*(--t)*t*t*t*t
}

const requestAnimationFrame = window.requestAnimationFrame ||
    window.webkitRequestAnimationFrame ||
    window.mozRequestAnimationFrame ||
    window.oRequestAnimationFrame ||
    window.msRequestAnimationFrame;

window.smoothScrollTo = function(to) {
    const start = window.scrollY || window.pageYOffset
    const time = Date.now()
    const duration = Math.abs(start - to) / 3;

    (function step() {
        var dx = Math.min(1, (Date.now() - time) / duration)
        var pos = start + (to - start) * EasingFunctions.linear(dx)

        window.scrollTo(0, pos);

        if (dx < 1) {
            requestAnimationFrame(step)
        }
    })()
}
