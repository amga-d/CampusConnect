import { gsap } from 'gsap';

export function fadeInUp(element, delay = 0) {
  gsap.from(element, {
    y: 20,
    opacity: 0,
    duration: 0.6,
    delay,
    ease: "power2.out"
  });
}

export function pulseAnimation(element) {
  gsap.to(element, {
    scale: 1.05,
    duration: 0.3,
    yoyo: true,
    repeat: 1,
    ease: "power2.inOut"
  });
}

export function staggerChildren(parent, childSelector, staggerTime = 0.1) {
  const children = parent.querySelectorAll(childSelector);
  gsap.from(children, {
    y: 20,
    opacity: 0,
    duration: 0.5,
    stagger: staggerTime,
    ease: "power2.out"
  });
}