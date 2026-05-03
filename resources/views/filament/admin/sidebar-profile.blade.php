<div class="px-6 py-8">
    <!-- Glassmorphism Card (Kotak Pembungkus Premium) -->
    <div style="background-color: #0f172a; border: 1px solid rgba(59, 130, 246, 0.3); border-radius: 2rem; padding: 1.5rem; display: flex; flex-direction: column; align-items: center; box-shadow: 0 20px 50px rgba(0,0,0,0.5);">
        
        <!-- Avatar Section -->
        <div style="margin-bottom: 1rem; position: relative;">
            <div style="width: 80px; height: 80px; border-radius: 50%; overflow: hidden; border: 2px solid #3b82f6; padding: 2px; background: #020617;">
                <img 
                    src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&color=fff&background=1e293b" 
                    alt="Avatar" 
                    style="width: 100%; height: 100%; border-radius: 50%; object-fit: cover;"
                >
            </div>
        </div>

        <!-- Info Section (Warna Kuning Emas & Biru Muda) -->
        <div class="text-center">
            <h3 style="color: #fbbf24 !important; font-size: 1.25rem !important; font-weight: 900 !important; margin: 0; text-align: center;">
                {{ auth()->user()->name }}
            </h3>
            <p style="color: #94a3b8 !important; font-size: 11px !important; font-weight: 700 !important; text-transform: uppercase; letter-spacing: 1px; margin-top: 4px; text-align: center;">
                {{ auth()->user()->email }}
            </p>
        </div>

        <!-- Role Badge -->
        <div style="margin-top: 1.25rem; width: 100%;">
            <div style="background: rgba(59, 130, 246, 0.1); border: 1px solid rgba(59, 130, 246, 0.3); padding: 6px; border-radius: 12px; text-align: center;">
                <span style="color: #60a5fa !important; font-size: 10px !important; font-weight: 900 !important; text-transform: uppercase; letter-spacing: 2px;">
                    {{ auth()->user()->role ?? 'Superadmin' }}
                </span>
            </div>
        </div>
    </div>
</div>
