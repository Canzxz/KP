<div class="px-6 py-8">
    <!-- Glassmorphism Card (Theme Aware) -->
    <div class="profile-card">
        
        <!-- Avatar Section -->
        <div style="margin-bottom: 1rem; position: relative;">
            <div class="avatar-wrapper">
                <img 
                    src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&color=fff&background=1e293b" 
                    alt="Avatar" 
                    style="width: 100%; height: 100%; border-radius: 50%; object-fit: cover;"
                >
            </div>
        </div>

        <!-- Info Section -->
        <div class="text-center">
            <h3 class="profile-name">
                {{ auth()->user()->name }}
            </h3>
            <p class="profile-email">
                {{ auth()->user()->email }}
            </p>
        </div>

        <!-- Role Badge -->
        <div style="margin-top: 1rem; width: 100%;">
            <div class="role-badge">
                <span class="role-text">
                    {{ auth()->user()->role ?? 'Superadmin' }}
                </span>
            </div>
        </div>

        <!-- THEME TOGGLE BUTTON -->
        <button 
            onclick="toggleTheme()" 
            class="theme-toggle-btn"
            id="theme-toggle-component"
        >
            {{-- Default state (will be overwritten by JS immediately) --}}
            <div style="display:flex; align-items:center; justify-content:center; gap:8px;">
                <span id="theme-icon">🌙</span>
                <span id="theme-text">MODE GELAP</span>
            </div>
        </button>
    </div>
</div>

<style>
    .profile-card {
        background-color: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 2rem;
        padding: 1.5rem;
        display: flex;
        flex-direction: column;
        align-items: center;
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease;
    }
    .dark .profile-card {
        background-color: #0f172a;
        border: 1px solid rgba(59, 130, 246, 0.3);
        box-shadow: 0 20px 50px rgba(0,0,0,0.5);
    }
    .avatar-wrapper {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        overflow: hidden;
        border: 2px solid #3b82f6;
        padding: 2px;
        background: #f1f5f9;
    }
    .dark .avatar-wrapper {
        background: #020617;
    }
    .profile-name {
        color: #1e293b !important;
        font-size: 1.25rem !important;
        font-weight: 800 !important;
        margin: 0;
    }
    .dark .profile-name {
        color: #fbbf24 !important;
    }
    .profile-email {
        color: #64748b !important;
        font-size: 11px !important;
        font-weight: 600 !important;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-top: 4px;
    }
    .dark .profile-email {
        color: #94a3b8 !important;
    }
    .role-badge {
        background: rgba(59, 130, 246, 0.05);
        border: 1px solid #e2e8f0;
        padding: 6px;
        border-radius: 12px;
        text-align: center;
    }
    .dark .role-badge {
        background: rgba(59, 130, 246, 0.1);
        border: 1px solid rgba(59, 130, 246, 0.3);
    }
    .role-text {
        color: #3b82f6 !important;
        font-size: 10px !important;
        font-weight: 800 !important;
        text-transform: uppercase;
        letter-spacing: 1px;
    }
    .dark .role-text {
        color: #60a5fa !important;
    }
    .theme-toggle-btn {
        margin-top: 1.5rem;
        width: 100%;
        padding: 10px;
        border-radius: 12px;
        font-size: 10px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 1px;
        background: #334155; /* Soft Slate Blue - Tidak terlalu kontras */
        color: #ffffff !important;
        border: none;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    }
    .dark .theme-toggle-btn {
        background: #d97706; /* Warm Amber - Lebih elegan, tidak neon */
        color: #ffffff !important;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
    }
</style>

<script>
    function updateThemeUI() {
        const isDark = document.documentElement.classList.contains('dark');
        const icon = document.getElementById('theme-icon');
        const text = document.getElementById('theme-text');
        
        if (isDark) {
            icon.innerText = '☀️';
            text.innerText = 'MODE TERANG';
        } else {
            icon.innerText = '🌙';
            text.innerText = 'MODE GELAP';
        }
    }

    function toggleTheme() {
        const html = document.documentElement;
        const currentIsDark = html.classList.contains('dark');
        const newTheme = currentIsDark ? 'light' : 'dark';
        
        localStorage.setItem('theme', newTheme);
        
        if (newTheme === 'dark') {
            html.classList.add('dark');
        } else {
            html.classList.remove('dark');
        }
        
        updateThemeUI();
        window.dispatchEvent(new CustomEvent('theme-changed', { detail: newTheme }));
    }

    // Initialize UI on load
    document.addEventListener('DOMContentLoaded', updateThemeUI);
    // Extra insurance for Livewire/Filament page loads
    setTimeout(updateThemeUI, 100);
</script>
