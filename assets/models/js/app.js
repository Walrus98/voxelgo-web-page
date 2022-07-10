import * as THREE from 'three';

import { OrbitControls } from 'https://unpkg.com/three@0.141.0/examples/jsm/controls/OrbitControls.js';
import { RoomEnvironment } from 'https://unpkg.com/three@0.141.0/examples/jsm/environments/RoomEnvironment.js';
import { DRACOLoader } from 'https://unpkg.com/three@0.141.0/examples/jsm/loaders/DRACOLoader.js';
import { GLTFLoader } from 'https://unpkg.com/three@0.141.0/examples/jsm/loaders/GLTFLoader.js';

const urlParams = new URLSearchParams(location.search);
const modelName = urlParams.get('model');
const displayMode = urlParams.get('mode');

let request = new XMLHttpRequest();
request.open("GET", "http://localhost/VoxelGO/backend/api.php?endpoint=models/get&name=" + modelName, false);
request.send(null);
let response = JSON.parse(request.responseText);

let config = response.property;

let model, mixer;

const clock = new THREE.Clock();
const container = document.getElementById('container');

const renderer = new THREE.WebGLRenderer({ antialias: true });
renderer.setPixelRatio(window.devicePixelRatio);
renderer.setSize(window.innerWidth, window.innerHeight);
renderer.outputEncoding = THREE.sRGBEncoding;
container.appendChild(renderer.domElement);

const pmremGenerator = new THREE.PMREMGenerator(renderer);
const scene = new THREE.Scene();
const backgroundColor = displayMode == 'dark' ? '#1D1E20' : '#F8F9FA';
scene.background = new THREE.Color(backgroundColor);
scene.environment = pmremGenerator.fromScene(new RoomEnvironment(), 0.04).texture;

const camera = new THREE.PerspectiveCamera(40, window.innerWidth / window.innerHeight, 1, 1000);
camera.position.set(config.cameraPosition.x, config.cameraPosition.y, config.cameraPosition.z);

const controls = new OrbitControls(camera, renderer.domElement);
controls.target.set(0, 0, 0);
controls.enablePan = false;
controls.enableDamping = true;
controls.autoRotate = true;
controls.minDistance = config.controlsMinDistance;
controls.maxDistance = config.controlsMaxDistance;
controls.update();

const dracoLoader = new DRACOLoader();
dracoLoader.setDecoderPath('libs/draco/gltf/');

const loader = new GLTFLoader();
loader.setDRACOLoader(dracoLoader);
loader.load(config.modelSource, (gltf) => {

    model = gltf.scene;
    model.position.set(config.modelPosition.x, config.modelPosition.y, config.modelPosition.z);
    model.scale.set(config.modelScale.x, config.modelScale.y, config.modelScale.z);
    scene.add(model);

    if (config.modelAnimated) {
        mixer = new THREE.AnimationMixer(model);
        mixer.clipAction(gltf.animations[config.modelAnimation]).play();
    }

    // let modelObj = {
    //     name: "modelName",
    //     modelSource: "assets/models/ghasklle/ghasklle.gltf",
    //     modelAnimation: 0,
    //     modelScale: model.scale,
    //     cameraPosition: camera.position,
    //     sceneBackground: scene.background,
    //     controlsPosition: controls.target,
    //     controlsMinDistance: 1.5,
    //     controlsMaxDistance: 5
    // };

    // let modelObjs = [modelObj, modelObj];

    // console.log(JSON.stringify(modelObjs));

    animate();
});

function animate() {

    if (config.modelAnimated) {
        const delta = clock.getDelta();
        mixer.update(delta);
    }

    controls.update();
    renderer.render(scene, camera);

    requestAnimationFrame(animate);
}

window.onresize = () => {
    camera.aspect = window.innerWidth / window.innerHeight;
    camera.updateProjectionMatrix();

    renderer.setSize(window.innerWidth, window.innerHeight);
};

window.modelRotation = () => {
    controls.autoRotate = !controls.autoRotate;
    controls.update(); 
}