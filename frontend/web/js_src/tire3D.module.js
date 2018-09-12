window.THREE = require('three');
require('three-projector-renderer')(THREE);
require('three-gltf2-loader')(THREE);

var Detector = require('three/examples/js/Detector.js');
require('three/examples/js/renderers/CanvasRenderer.js');

var TextureLoader = new THREE.TextureLoader();


module.exports = (function () {

    var CANVAS_WIDTH = 350;
    var CANVAST_HEIGHT = 900;

    var camera, scene, renderer;

    var textlabels = [];

    var loader = new THREE.GLTFLoader();

    var canvas_el;

    var scroll_rotate_target = 0;

    function init() {

        canvas_el = document.getElementById('main_tire_canvas');

        if (Detector.webgl) {
            renderer = new THREE.WebGLRenderer({
                antialias: true,
                canvas: canvas_el,
                alpha: true
            });
        }
        else {
            renderer = new THREE.CanvasRenderer({
                antialias: true,
                canvas: canvas_el,
                alpha: true
            });
        }


        createScene(function () {
            addShips();
            bindEvents();
            animate();
        });

    };

    function createScene(callback) {

        renderer.setSize(CANVAS_WIDTH, CANVAST_HEIGHT);
        var aspect_ratio = (CANVAS_WIDTH / CANVAST_HEIGHT);

        scene = new THREE.Scene();

        camera = new THREE.PerspectiveCamera(70, aspect_ratio, 1, 10000);
        camera.position.set(0, -65, 0);
        camera.lookAt(0, 0, 0);
        scene.add(camera);

        scene.add(new THREE.AmbientLight(0xffffff, 8));


        var dirLight = new THREE.PointLight(0xffffff, 10, 100);//, 300, Math.PI / 2, 1,2);
        dirLight.position.set(0, -65, 35);
        dirLight.lookAt(0, 0, 0);
        dirLight.castShadow = true;
        dirLight.shadow.camera.near = 1;
        dirLight.shadow.camera.far = 10000;
        dirLight.shadow.camera.fov = 70;

        scene.add(dirLight);


        var material = new THREE.MeshPhongMaterial({
            color: 0x4c4c4c,
            specular: 0x666666,
            shininess: 20,
            emissiveIntensity: 1,
            // roughness: 0.7,
            // metalness: 0.5,
            overdraw: 1,
            normalScale: (new THREE.Vector2(1, 1)).multiplyScalar(3),
            normalMapType: THREE.ObjectSpaceNormalMap
        });

        loadTextureToMaterial('/Michelin2018/assets/img/diff.png', material, 'map');
        // loadTextureToMaterial('/Michelin2018/assets/img/dis.png', material, 'displaceMap');
        loadTextureToMaterial('/Michelin2018/assets/img/normal.png', material, 'normalMap');
        loadTextureToMaterial('/Michelin2018/assets/img/spec.png', material, 'specularMap');


        var tire_object;

        loader.load('/Michelin2018/assets/models/tire.glb',
            function (gltf) {
                scene.add(gltf.scene);

                tire_object = scene.getObjectByName("Tire");
                tire_object.traverse(function (child) {
                    if (child.isMesh) {
                        child.castShadow = true;
                        child.receiveShadow = true;
                        child.material = material;
                    }
                });
                scene.add(tire_object);

                if (typeof callback === 'function') {
                    callback();
                }

            }
        );

    }

    function bindEvents() {

        var tire_object = scene.getObjectByName("Tire");

        var isDragging = false;

        var previousMousePositionY = 0;


        $('.main_tire').on('mousedown', function (e) {
            isDragging = true;
        }).on('mousemove', function (e) {

            e.offsetY = e.pageY - $(canvas_el).offset().top;

            var deltaMoveY = e.offsetY - previousMousePositionY;

            if (isDragging) {

                var deltaRotationQuaternion = new THREE.Quaternion()
                    .setFromEuler(new THREE.Euler(toRadians(deltaMoveY * 0.2), 0, 0));

                tire_object.quaternion.multiplyQuaternions(deltaRotationQuaternion, tire_object.quaternion);
            }

            previousMousePositionY = e.offsetY;
        }).on('wheel', function (e) {

            if (e.originalEvent.deltaY > 0) {
                scroll_rotate_target = 50;
            }
            else if (e.originalEvent.deltaY < 0) {
                scroll_rotate_target = -50;
            }

        });

        $(document).on('mouseup', function () {
            isDragging = false;
        });

    }

    function addShips() {

        var ship_object;
        var tire_object = scene.getObjectByName("Tire");

        var material = new THREE.MeshBasicMaterial({
            color: 0xffff00, side: THREE.DoubleSide, transparent: true, opacity: 0
        });

        for (var i = 0; i <= 91; i++) {

            var id = i;

            if (i < 10) {
                id = "00" + i;
            } else if (i < 100) {
                id = "0" + i;
            }

            ship_object = scene.getObjectByName("Cube" + id);
            ship_object.traverse(function (child) {
                if (child.isMesh) {
                    child.castShadow = true;
                    child.receiveShadow = true;
                    child.material = material;
                }
            });


            var text = createTextLabel(i);
            text.setHTML('<span>ship ' + id + '</span>');
            text.setParent(ship_object);

            textlabels.push(text);

            $("#main_tire_canvas").after(text.element);


            tire_object.add(ship_object);
        }
    }

    function animate() {

        requestAnimationFrame(animate);

        render();
    }

    function render() {

        renderer.render(scene, camera);

        for (var i = 0; i < textlabels.length; i++) {
            textlabels[i].updatePosition();
        }

        rotateWheel();

    }


    function rotateWheel() {

        if (scroll_rotate_target === 0) {
            return 0;
        }


        var direction = +10;

        if (scroll_rotate_target < 0) {
            direction = -10;
        }
        scroll_rotate_target -= direction;

        var deltaRotationQuaternion = new THREE.Quaternion()
            .setFromEuler(new THREE.Euler(toRadians(direction * 0.2), 0, 0));
        var tire_object = scene.getObjectByName("Tire");

        tire_object.quaternion.multiplyQuaternions(deltaRotationQuaternion, tire_object.quaternion);

    }

    function createTextLabel(city_id) {

        var div = document.createElement('div');
        div.className = 'text-label';
        div.style.position = 'absolute';
        div.style.zIndex = '2';
        div.style.width = 100;
        div.style.height = 100;
        div.innerHTML = "";
        div.style.top = -1000;
        div.style.left = -1000;
        div.style.marginTop = parseInt($("#main_tire_canvas").css('marginTop')) - 10 + "px"; // 10px - is half of tire stud
        div.dataset.cityId = city_id;

        return {
            element: div,
            parent: false,
            position: new THREE.Vector3(0, 0, 0),
            setHTML: function (html) {
                this.element.innerHTML = html;
            },
            setParent: function (threejsobj) {
                this.parent = threejsobj;
            },
            updatePosition: function () {
                if (parent) {
                    var vector = new THREE.Vector3();
                    this.position.copy(vector.applyMatrix4(this.parent.matrixWorld));
                    if (vector.z < -18 || vector.z > 18 || vector.y > 10) {
                        $(div).removeClass('show')
                    }
                    else {
                        $(div).addClass('show')
                    }

                    if (vector.z < -10 || vector.z > 10) {
                        $(div).addClass('marker_only')
                    }
                    else {
                        $(div).removeClass('marker_only')
                    }

                }

                var coords2d = this.get2DCoords(this.position, camera);
                this.element.style.left = coords2d.x + 'px';
                this.element.style.top = coords2d.y + 'px';
            },
            get2DCoords: function (position, camera) {
                var vector = position.project(camera);
                vector.x = (vector.x + 1.03) / 2 * renderer.domElement.clientWidth;
                vector.y = -(vector.y - 1) / 2 * renderer.domElement.clientHeight;
                return vector;
            }
        };
    }

    function loadTextureToMaterial(url, material, type) {
        TextureLoader.load(url, function (texture) {
            texture.minFilter = THREE.LinearFilter;
            texture.wrapT = THREE.RepeatWrapping;
            texture.repeat.y = -1;
            material[type] = texture;
            material.needsUpdate = true;
        });
    }

    function toRadians(angle) {
        return angle * (Math.PI / 180);
    }

    function toDegrees(angle) {
        return angle * (180 / Math.PI);
    }

    return {
        init: init
    }

})();