export function registerControllers(Alpine) {
    // ── SCANNER MODAL COMPONENT ─────────────────────────────────────────────
    Alpine.data('scannerComponent', (targetEvent) => ({
        isOpen: false,
        scanner: null,
        hasFlashlight: false,
        isFlashlightOn: false,
        barcodeBuffer: '',
        lastKeystrokeTime: 0,
        
        openScanner() {
            this.isOpen = true;
            setTimeout(() => {
                this.initScanner();
            }, 100);
        },
        
        closeScanner() {
            this.isOpen = false;
            if (this.scanner) {
                this.scanner.stop().then(() => {
                    this.scanner.clear();
                }).catch(err => console.error("Failed to stop scanner", err));
            }
        },
        
        initScanner() {
            // Using the globally exposed Html5Qrcode
            this.scanner = new window.Html5Qrcode("reader");
            const config = { fps: 10, qrbox: { width: 250, height: 250 } };
            
            this.scanner.start(
                { facingMode: "environment" },
                config,
                (decodedText, decodedResult) => {
                    this.processBarcode(decodedText);
                    this.closeScanner();
                },
                (errorMessage) => {
                    // ignore parse errors
                }
            ).then(() => {
                const track = this.scanner.getRunningTrackCameraCapabilities();
                if (track && track.hasTorch()) {
                    this.hasFlashlight = true;
                }
            }).catch(err => {
                alert("Camera access failed. Please ensure you have granted permission.");
                this.closeScanner();
            });
        },
        
        toggleFlashlight() {
            if (this.scanner && this.hasFlashlight) {
                this.isFlashlightOn = !this.isFlashlightOn;
                this.scanner.applyVideoConstraints({
                    advanced: [{ torch: this.isFlashlightOn }]
                });
            }
        },
        
        handleGlobalKeydown(e) {
            if (e.target.tagName === 'INPUT' || e.target.tagName === 'TEXTAREA' || e.target.tagName === 'SELECT') {
                return;
            }
            
            const currentTime = Date.now();
            if (currentTime - this.lastKeystrokeTime > 50) {
                this.barcodeBuffer = '';
            }
            this.lastKeystrokeTime = currentTime;
            
            if (e.key === 'Enter') {
                if (this.barcodeBuffer.length > 2) {
                    e.preventDefault();
                    this.processBarcode(this.barcodeBuffer);
                    this.barcodeBuffer = '';
                }
            } else if (e.key.length === 1) {
                this.barcodeBuffer += e.key;
            }
        },
        
        processBarcode(barcode) {
            window.dispatchEvent(new CustomEvent(targetEvent, { detail: { sku: barcode.trim() }}));
        }
    }));

    // ── SCAN IN CONTROLLER ──────────────────────────────────────────────────
    Alpine.data('scanInController', () => ({
        skuInput: '',
        product: null,
        qtyToAdd: 1,
        loading: false,
        submitting: false,
        error: '',
        scanLogs: [],
        logIdCounter: 1,

        init() {
            window.addEventListener('barcode-scanned', (e) => {
                this.skuInput = e.detail.sku;
                this.lookupProduct();
            });
        },

        async lookupProduct() {
            if (!this.skuInput.trim()) return;
            this.loading = true;
            this.error = '';
            this.product = null;
            
            try {
                const res = await fetch(`/admin/api/scan/${this.skuInput}`);
                const data = await res.json();
                
                if (data.success) {
                    this.product = data.product;
                    this.qtyToAdd = 1;
                    setTimeout(() => document.querySelector('input[type="number"]').focus(), 100);
                } else {
                    this.error = data.message;
                }
            } catch (err) {
                this.error = "Failed to connect to server.";
            } finally {
                this.loading = false;
                this.skuInput = '';
            }
        },

        async restock() {
            if (!this.product || this.qtyToAdd < 1) return;
            this.submitting = true;
            this.error = '';

            try {
                const res = await fetch(`/admin/inventory/scan-in`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        product_id: this.product.id,
                        quantity: this.qtyToAdd
                    })
                });
                
                const data = await res.json();
                if (data.success) {
                    this.product.stock = data.new_stock;
                    
                    this.scanLogs.push({
                        id: this.logIdCounter++,
                        qty: this.qtyToAdd,
                        name: this.product.name,
                        time: new Date().toLocaleTimeString()
                    });
                    
                    this.product = null;
                    this.qtyToAdd = 1;
                    
                    document.querySelector('input[type="text"]').focus();
                } else {
                    this.error = data.message || "Failed to update stock.";
                }
            } catch (err) {
                this.error = "Network error. Please try again.";
            } finally {
                this.submitting = false;
            }
        }
    }));

    // ── POS CONTROLLER ──────────────────────────────────────────────────────
    Alpine.data('posController', () => ({
        skuInput: '',
        cart: [],
        loading: false,
        submitting: false,
        error: '',
        checkoutSuccess: false,

        init() {
            window.addEventListener('barcode-scanned', (e) => {
                this.skuInput = e.detail.sku;
                this.lookupProduct();
            });
        },
        
        fmt(val) {
            return 'RM ' + Number(val).toLocaleString('en-MY', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
        },

        totalItems() {
            return this.cart.reduce((acc, item) => acc + parseInt(item.quantity), 0);
        },
        
        totalRevenue() {
            return this.cart.reduce((acc, item) => acc + (parseFloat(item.price) * parseInt(item.quantity)), 0);
        },

        async lookupProduct() {
            if (!this.skuInput.trim()) return;
            this.loading = true;
            this.error = '';
            this.checkoutSuccess = false;
            
            try {
                const res = await fetch(`/admin/api/scan/${this.skuInput}`);
                const data = await res.json();
                
                if (data.success) {
                    const product = data.product;
                    if (product.stock < 1) {
                        this.error = "Out of Stock!";
                    } else {
                        const existing = this.cart.find(i => i.id === product.id);
                        if (existing) {
                            if (existing.quantity < product.stock) {
                                existing.quantity++;
                            } else {
                                this.error = "Max stock reached for this item.";
                            }
                        } else {
                            this.cart.unshift({
                                id: product.id,
                                sku: product.sku,
                                name: product.name,
                                price: product.retail_price,
                                maxStock: product.stock,
                                quantity: 1,
                                image_url: product.image_url
                            });
                        }
                    }
                } else {
                    this.error = data.message;
                }
            } catch (err) {
                this.error = "Failed to connect to server.";
            } finally {
                this.loading = false;
                this.skuInput = '';
                setTimeout(() => document.querySelector('input[type="text"]').focus(), 100);
            }
        },

        updateQty(index, change) {
            const item = this.cart[index];
            const newQty = item.quantity + change;
            if (newQty > 0 && newQty <= item.maxStock) {
                item.quantity = newQty;
            }
        },
        
        validateQty(index) {
            const item = this.cart[index];
            if (item.quantity < 1) item.quantity = 1;
            if (item.quantity > item.maxStock) item.quantity = item.maxStock;
        },
        
        removeItem(index) {
            this.cart.splice(index, 1);
        },

        async checkout() {
            if (this.cart.length === 0) return;
            this.submitting = true;
            this.error = '';
            this.checkoutSuccess = false;

            try {
                const payload = {
                    items: this.cart.map(i => ({ id: i.id, quantity: i.quantity }))
                };
                
                const res = await fetch(`/admin/sales/pos`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify(payload)
                });
                
                const data = await res.json();
                if (data.success) {
                    this.cart = [];
                    this.checkoutSuccess = true;
                    setTimeout(() => this.checkoutSuccess = false, 3000);
                    document.querySelector('input[type="text"]').focus();
                } else {
                    this.error = data.message || "Checkout failed.";
                }
            } catch (err) {
                this.error = "Network error. Please try again.";
            } finally {
                this.submitting = false;
            }
        }
    }));
}
