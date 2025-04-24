import * as THREE from 'https://cdn.jsdelivr.net/npm/three@0.150/build/three.module.js';
import { vertexShader, fragmentShader } from '../js/shader.js';

let scene, camera, renderer, particleSystem, clock;

function init() {
    scene = new THREE.Scene();
    camera = new THREE.PerspectiveCamera(75, window.innerWidth / window.innerHeight, 0.1, 1000);
    camera.position.z = 50;

    renderer = new THREE.WebGLRenderer({ antialias: true });
    renderer.setSize(window.innerWidth, window.innerHeight);
    document.body.appendChild(renderer.domElement);

    clock = new THREE.Clock();

    // Particle Geometry
    const particles = 5000;
    let geometry = new THREE.BufferGeometry();
    let positions = new Float32Array(particles * 3);
    let speeds = new Float32Array(particles);

    for (let i = 0; i < particles; i++) {
        let x = (Math.random() - 0.5) * 100;
        let y = Math.sin(i * 0.05) * 10;
        let z = (Math.random() - 0.5) * 50;

        positions[i * 3] = x;
        positions[i * 3 + 1] = y;
        positions[i * 3 + 2] = z;

        speeds[i] = Math.random() * 2 + 1; // Speed variation
    }

    geometry.setAttribute('position', new THREE.BufferAttribute(positions, 4));
    geometry.setAttribute('speed', new THREE.BufferAttribute(speeds, 1));

    // Shader Material
    let material = new THREE.ShaderMaterial({
        uniforms: {
            u_time: { value: 0.0 },
            u_color: { value: new THREE.Color(0x00ffff) } // Neon Cyan
        },
        vertexShader,
        fragmentShader,
        transparent: true
    });

    particleSystem = new THREE.Points(geometry, material);
    scene.add(particleSystem);

    window.addEventListener("resize", onResize);
    animate();
}

function animate() {
    requestAnimationFrame(animate);
    particleSystem.material.uniforms.u_time.value = clock.getElapsedTime();
    renderer.render(scene, camera);
}

function onResize() {
    camera.aspect = window.innerWidth / window.innerHeight;
    camera.updateProjectionMatrix();
    renderer.setSize(window.innerWidth, window.innerHeight);
}

init();
