<div x-data="qrScanner()" x-init="init()" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-lg p-6 m-4 max-w-md w-full">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold">{{ __('app.scan_qr_code') }}</h3>
            <button wire:click="$dispatch('close-scanner')" class="text-gray-400 hover:text-gray-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <div class="space-y-4">
            <div x-show="!isScanning">
                <button
                    @click="startScanning()"
                    class="w-full px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                >
                    {{ __('app.scan_qr_code') }}
                </button>
            </div>

            <div x-show="isScanning" class="space-y-4">
                <div class="relative">
                    <video x-ref="video" class="w-full h-48 bg-gray-100 rounded-lg object-cover"></video>
                    <div class="absolute inset-0 border-2 border-indigo-500 rounded-lg pointer-events-none">
                        <div class="absolute top-4 left-4 w-6 h-6 border-l-4 border-t-4 border-indigo-500"></div>
                        <div class="absolute top-4 right-4 w-6 h-6 border-r-4 border-t-4 border-indigo-500"></div>
                        <div class="absolute bottom-4 left-4 w-6 h-6 border-l-4 border-b-4 border-indigo-500"></div>
                        <div class="absolute bottom-4 right-4 w-6 h-6 border-r-4 border-b-4 border-indigo-500"></div>
                    </div>
                </div>

                <button
                    @click="stopScanning()"
                    class="w-full px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500"
                >
                    Arrêter
                </button>
            </div>

            <div class="text-center">
                <p class="text-gray-600 mb-4 text-sm">{{ __('app.point_camera') }}</p>
                <div class="relative">
                    <input
                        type="text"
                        x-model="manualCode"
                        @keyup.enter="goToArtwork(manualCode)"
                        placeholder="{{ __('app.manual_code') }}"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500"
                    >
                    <button
                        @click="goToArtwork(manualCode)"
                        x-show="manualCode.length > 0"
                        class="absolute right-2 top-2 text-indigo-600 hover:text-indigo-800"
                    >
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </button>
                </div>
            </div>

            <div x-show="error" x-text="error" class="text-red-600 text-sm text-center"></div>
        </div>
    </div>

    <script>
        function qrScanner() {
            return {
                isScanning: false,
                scanner: null,
                manualCode: '',
                error: '',

                init() {
                    // Initialize component
                },

                async startScanning() {
                    try {
                        this.error = '';
                        this.isScanning = true;

                        const QrScanner = (await import('qr-scanner')).default;

                        this.scanner = new QrScanner(
                            this.$refs.video,
                            result => this.onScanSuccess(result.data),
                            {
                                highlightScanRegion: true,
                                highlightCodeOutline: true,
                            }
                        );

                        await this.scanner.start();
                    } catch (err) {
                        this.error = 'Erreur: ' + err.message;
                        this.isScanning = false;
                    }
                },

                stopScanning() {
                    if (this.scanner) {
                        this.scanner.stop();
                        this.scanner.destroy();
                        this.scanner = null;
                    }
                    this.isScanning = false;
                },

                onScanSuccess(result) {
                    this.stopScanning();

                    // Extract QR code from URL or use as is
                    let qrCode = result;
                    const urlMatch = result.match(/\/artwork\/([^\/\?]+)/);
                    if (urlMatch) {
                        qrCode = urlMatch[1];
                    }

                    this.goToArtwork(qrCode);
                },

                goToArtwork(code) {
                    if (code) {
                        window.location.href = '/artwork/' + encodeURIComponent(code.trim());
                    }
                }
            }
        }
    </script>
</div>
