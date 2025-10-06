<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visite Virtuelle 3D - Musée Numérique</title>
    <script src="https://aframe.io/releases/1.4.0/aframe.min.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/supermedium/superframe@master/components/environment/dist/aframe-environment-component.min.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/supermedium/superframe@master/components/look-at/dist/aframe-look-at-component.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        body {
            margin: 0;
            font-family: 'Inter', sans-serif;
            background: #000;
        }

        .vr-ui {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            background: linear-gradient(180deg, rgba(0,0,0,0.8) 0%, rgba(0,0,0,0) 100%);
            padding: 20px;
            color: white;
        }

        .vr-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            max-width: 1200px;
            margin: 0 auto;
        }

        .vr-title {
            font-size: 1.5rem;
            font-weight: 300;
            letter-spacing: 0.025em;
        }

        .vr-controls {
            display: flex;
            gap: 15px;
            align-items: center;
        }

        .vr-btn {
            background: rgba(255,255,255,0.1);
            border: 1px solid rgba(255,255,255,0.2);
            color: white;
            padding: 8px 16px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 0.875rem;
            font-weight: 300;
            letter-spacing: 0.025em;
            transition: all 0.3s ease;
        }

        .vr-btn:hover {
            background: rgba(255,255,255,0.2);
            border-color: rgba(255,255,255,0.4);
        }

        .artwork-info {
            position: fixed;
            bottom: 20px;
            left: 20px;
            right: 20px;
            background: rgba(0,0,0,0.8);
            backdrop-filter: blur(10px);
            padding: 20px;
            border-radius: 8px;
            color: white;
            transform: translateY(100%);
            transition: transform 0.3s ease;
            z-index: 1000;
        }

        .artwork-info.active {
            transform: translateY(0);
        }

        .artwork-title {
            font-size: 1.25rem;
            font-weight: 500;
            margin-bottom: 5px;
        }

        .artwork-artist {
            font-size: 1rem;
            font-weight: 300;
            color: #ccc;
            margin-bottom: 10px;
        }

        .artwork-description {
            font-size: 0.875rem;
            font-weight: 300;
            line-height: 1.5;
            color: #e0e0e0;
        }

        .audio-controls {
            margin-top: 15px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .audio-btn {
            background: rgba(255,255,255,0.1);
            border: 1px solid rgba(255,255,255,0.2);
            color: white;
            padding: 6px 12px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 0.75rem;
            font-weight: 300;
        }

        .loading-screen {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: #000;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            color: white;
            z-index: 2000;
            transition: opacity 0.5s ease;
        }

        .loading-screen.hidden {
            opacity: 0;
            pointer-events: none;
        }

        .loader {
            width: 50px;
            height: 50px;
            border: 2px solid rgba(255,255,255,0.1);
            border-top: 2px solid white;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin-bottom: 20px;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        @media (max-width: 768px) {
            .vr-header {
                flex-direction: column;
                gap: 10px;
            }

            .vr-controls {
                flex-wrap: wrap;
                justify-content: center;
            }

            .artwork-info {
                bottom: 10px;
                left: 10px;
                right: 10px;
                padding: 15px;
            }
        }
    </style>
</head>
<body>
    <div class="loading-screen" id="loadingScreen">
        <div class="loader"></div>
        <p style="font-weight: 300; letter-spacing: 0.025em;">Chargement de l'expérience 3D...</p>
    </div>

    <div class="vr-ui">
        <div class="vr-header">
            <h1 class="vr-title">Visite Virtuelle 3D</h1>
            <div class="vr-controls">
                <button class="vr-btn" onclick="resetView()">Réinitialiser</button>
                <button class="vr-btn" onclick="toggleFullscreen()">Plein écran</button>
                <button class="vr-btn" onclick="window.location.href='{{ route('gallery') }}'">Retour</button>
            </div>
        </div>
    </div>

    <div class="artwork-info" id="artworkInfo">
        <div class="artwork-title" id="artworkTitle"></div>
        <div class="artwork-artist" id="artworkArtist"></div>
        <div class="artwork-description" id="artworkDescription"></div>
        <div class="audio-controls" id="audioControls" style="display: none;">
            <button class="audio-btn" onclick="playAudio()">▶ Écouter</button>
            <button class="audio-btn" onclick="stopAudio()">⏹ Arrêter</button>
        </div>
    </div>

    <a-scene
        embedded
        style="height: 100vh; width: 100vw;"
        vr-mode-ui="enabled: true"
        environment="preset: gallery; groundColor: #2a2a2a; grid: 1x1; gridColor: #444444; lighting: distant; shadow: true"
        cursor="rayOrigin: mouse"
        raycaster="objects: .clickable">

        <a-assets>
            @foreach($artworks as $artwork)
                @if($artwork['image_path'])
                    <img id="artwork{{ $artwork['id'] }}" src="{{ $artwork['image_path'] }}" crossorigin="anonymous">
                @endif
                @if($artwork['audio_path'])
                    <audio id="audio{{ $artwork['id'] }}" src="{{ $artwork['audio_path'] }}" preload="auto"></audio>
                @endif
            @endforeach
        </a-assets>

        <!-- Éclairage -->
        <a-light type="ambient" color="#404040" intensity="0.4"></a-light>
        <a-light type="directional" position="5 10 5" color="#ffffff" intensity="0.8" shadow="cast: true"></a-light>
        <a-light type="point" position="0 4 0" color="#ffffff" intensity="0.5"></a-light>

        <!-- Sol et murs -->
        <a-plane position="0 0 0" rotation="-90 0 0" width="50" height="50" color="#2a2a2a" shadow="receive: true"></a-plane>

        <!-- Murs de la galerie -->
        <a-plane position="0 5 -12" rotation="0 0 0" width="50" height="10" color="#f8f8f8"></a-plane>
        <a-plane position="25 5 0" rotation="0 -90 0" width="25" height="10" color="#f8f8f8"></a-plane>
        <a-plane position="-25 5 0" rotation="0 90 0" width="25" height="10" color="#f8f8f8"></a-plane>

        <!-- Caméra avec contrôles -->
        <a-entity id="cameraRig" position="0 1.6 5">
            <a-camera
                look-controls="pointerLockEnabled: true"
                wasd-controls="acceleration: 30"
                universal-controls>
            </a-camera>
        </a-entity>

        <!-- Œuvres d'art disposées en galerie -->
        @php
            $positions = [
                ['x' => -8, 'z' => -10, 'rotation' => '0 0 0'],
                ['x' => -3, 'z' => -10, 'rotation' => '0 0 0'],
                ['x' => 2, 'z' => -10, 'rotation' => '0 0 0'],
                ['x' => 7, 'z' => -10, 'rotation' => '0 0 0'],
                ['x' => 20, 'z' => -8, 'rotation' => '0 -90 0'],
                ['x' => 20, 'z' => -3, 'rotation' => '0 -90 0'],
                ['x' => 20, 'z' => 2, 'rotation' => '0 -90 0'],
                ['x' => 20, 'z' => 7, 'rotation' => '0 -90 0'],
                ['x' => -20, 'z' => -8, 'rotation' => '0 90 0'],
                ['x' => -20, 'z' => -3, 'rotation' => '0 90 0'],
                ['x' => -20, 'z' => 2, 'rotation' => '0 90 0'],
                ['x' => -20, 'z' => 7, 'rotation' => '0 90 0'],
            ];
        @endphp

        @foreach($artworks as $index => $artwork)
            @if($artwork['image_path'] && isset($positions[$index]))
                @php $pos = $positions[$index]; @endphp

                <!-- Cadre de l'œuvre -->
                <a-entity position="{{ $pos['x'] }} 3 {{ $pos['z'] }}" rotation="{{ $pos['rotation'] }}">
                    <!-- Cadre décoratif -->
                    <a-box
                        position="0 0 0.05"
                        width="2.2"
                        height="2.7"
                        depth="0.1"
                        color="#8B4513"
                        shadow="cast: true">
                    </a-box>

                    <!-- Image de l'œuvre -->
                    <a-plane
                        position="0 0 0.11"
                        width="2"
                        height="2.5"
                        src="#artwork{{ $artwork['id'] }}"
                        class="clickable"
                        animation__mouseenter="property: scale; to: 1.05 1.05 1; startEvents: mouseenter; dur: 200"
                        animation__mouseleave="property: scale; to: 1 1 1; startEvents: mouseleave; dur: 200"
                        data-artwork='@json($artwork)'>
                    </a-plane>

                    <!-- Éclairage spot pour l'œuvre -->
                    <a-light
                        type="spot"
                        position="0 1 1"
                        color="#ffffff"
                        intensity="0.6"
                        angle="30"
                        penumbra="0.3"
                        shadow="cast: true">
                    </a-light>

                    <!-- Plaque descriptive -->
                    <a-plane
                        position="0 -1.5 0.11"
                        width="1.8"
                        height="0.3"
                        color="#f8f8f8"
                        text="value: {{ $artwork['title'] }}\nArtiste: {{ $artwork['artist'] }}; align: center; color: #333; font: roboto; width: 8">
                    </a-plane>

                    @if($artwork['is_featured'])
                        <!-- Indicateur œuvre mise en avant -->
                        <a-ring
                            position="1.3 1.3 0.12"
                            radius-inner="0.05"
                            radius-outer="0.1"
                            color="gold"
                            animation="property: rotation; to: 0 0 360; dur: 3000; loop: true">
                        </a-ring>
                    @endif
                </a-entity>
            @endif
        @endforeach

        <!-- Éléments décoratifs de la galerie -->
        <a-cylinder position="5 0.5 5" radius="0.3" height="1" color="#4a4a4a"></a-cylinder>
        <a-sphere position="5 1.2 5" radius="0.2" color="#8B4513"></a-sphere>

        <a-cylinder position="-5 0.5 5" radius="0.3" height="1" color="#4a4a4a"></a-cylinder>
        <a-sphere position="-5 1.2 5" radius="0.2" color="#8B4513"></a-sphere>

        <!-- Panneau d'information central -->
        <a-entity position="0 2 0">
            <a-plane
                position="0 0 0"
                width="3"
                height="1.5"
                color="#1a1a1a"
                text="value: MUSÉE NUMÉRIQUE\nCollection d'Art Contemporain\n\nUtilisez WASD pour vous déplacer\nCliquez sur les œuvres pour plus d'informations; align: center; color: white; font: roboto; width: 8">
            </a-plane>
        </a-entity>
    </a-scene>

    <script>
        let currentAudio = null;

        // Masquer l'écran de chargement après le chargement de la scène
        document.querySelector('a-scene').addEventListener('loaded', function() {
            setTimeout(() => {
                document.getElementById('loadingScreen').classList.add('hidden');
            }, 1000);
        });

        // Gestion des clics sur les œuvres
        document.querySelectorAll('.clickable').forEach(element => {
            element.addEventListener('click', function() {
                const artworkData = JSON.parse(this.getAttribute('data-artwork'));
                showArtworkInfo(artworkData);
            });
        });

        function showArtworkInfo(artwork) {
            const info = document.getElementById('artworkInfo');
            const title = document.getElementById('artworkTitle');
            const artist = document.getElementById('artworkArtist');
            const description = document.getElementById('artworkDescription');
            const audioControls = document.getElementById('audioControls');

            title.textContent = artwork.title;
            artist.textContent = `Par ${artwork.artist}`;
            description.textContent = artwork.description || 'Description non disponible.';

            if (artwork.audio_path) {
                audioControls.style.display = 'flex';
                audioControls.setAttribute('data-audio-id', `audio${artwork.id}`);
            } else {
                audioControls.style.display = 'none';
            }

            info.classList.add('active');

            // Masquer automatiquement après 10 secondes
            setTimeout(() => {
                info.classList.remove('active');
            }, 10000);
        }

        function playAudio() {
            const audioControls = document.getElementById('audioControls');
            const audioId = audioControls.getAttribute('data-audio-id');
            const audioElement = document.getElementById(audioId);

            if (currentAudio && currentAudio !== audioElement) {
                currentAudio.pause();
                currentAudio.currentTime = 0;
            }

            if (audioElement) {
                audioElement.play();
                currentAudio = audioElement;
            }
        }

        function stopAudio() {
            if (currentAudio) {
                currentAudio.pause();
                currentAudio.currentTime = 0;
                currentAudio = null;
            }
        }

        function resetView() {
            const cameraRig = document.getElementById('cameraRig');
            cameraRig.setAttribute('position', '0 1.6 5');
            cameraRig.setAttribute('rotation', '0 0 0');
        }

        function toggleFullscreen() {
            if (!document.fullscreenElement) {
                document.documentElement.requestFullscreen();
            } else {
                document.exitFullscreen();
            }
        }

        // Masquer les infos de l'œuvre quand on clique ailleurs
        document.addEventListener('click', function(e) {
            if (!e.target.closest('#artworkInfo') && !e.target.closest('.clickable')) {
                document.getElementById('artworkInfo').classList.remove('active');
            }
        });

        // Contrôles clavier supplémentaires
        document.addEventListener('keydown', function(e) {
            switch(e.key) {
                case 'Escape':
                    document.getElementById('artworkInfo').classList.remove('active');
                    break;
                case 'r':
                case 'R':
                    resetView();
                    break;
                case 'f':
                case 'F':
                    toggleFullscreen();
                    break;
            }
        });
    </script>
</body>
</html>