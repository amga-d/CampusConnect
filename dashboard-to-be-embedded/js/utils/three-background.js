import * as THREE from 'three';

export function initBackground() {
  const scene = new THREE.Scene();
  const camera = new THREE.PerspectiveCamera(75, window.innerWidth / window.innerHeight, 0.1, 1000);
  const renderer = new THREE.WebGLRenderer({ alpha: true });
  
  renderer.setSize(window.innerWidth, window.innerHeight);
  renderer.setClearColor(0x000000, 0);
  document.querySelector('.background-canvas').appendChild(renderer.domElement);
  
  const geometry = new THREE.IcosahedronGeometry(1, 1);
  const material = new THREE.MeshPhongMaterial({
    color: 0x6366F1,
    wireframe: true,
    transparent: true,
    opacity: 0.3
  });
  
  const sphere = new THREE.Mesh(geometry, material);
  scene.add(sphere);
  
  const light = new THREE.DirectionalLight(0xffffff, 1);
  light.position.set(1, 1, 1);
  scene.add(light);
  
  camera.position.z = 5;
  
  function animate() {
    requestAnimationFrame(animate);
    sphere.rotation.x += 0.001;
    sphere.rotation.y += 0.001;
    renderer.render(scene, camera);
  }
  
  animate();
  
  window.addEventListener('resize', () => {
    camera.aspect = window.innerWidth / window.innerHeight;
    camera.updateProjectionMatrix();
    renderer.setSize(window.innerWidth, window.innerHeight);
  });
}