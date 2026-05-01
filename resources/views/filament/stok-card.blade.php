<x-filament::page>

    {{-- SEARCH BAR --}}
    <form method="GET" style="margin-bottom: 1.5rem;">
        <div style="max-width: 28rem; position: relative;">
            <svg xmlns="http://www.w3.org/2000/svg" style="width: 1.25rem; height: 1.25rem; position: absolute; left: 0.75rem; top: 50%; transform: translateY(-50%); color: #94a3b8;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
            <input
                type="text"
                name="search"
                value="{{ request('search') }}"
                placeholder="Cari produk berdasarkan nama..."
                style="width: 100%; border-radius: 0.75rem; border: 1px solid rgba(255,255,255,0.08); background: rgba(255,255,255,0.03); backdrop-filter: blur(4px); padding: 0.75rem 1rem 0.75rem 2.5rem; font-size: 0.875rem; color: white; outline: none; transition: all 0.3s ease;"
                onfocus="this.style.borderColor='rgba(17,82,212,0.5)'; this.style.boxShadow='0 0 0 3px rgba(17,82,212,0.15)';"
                onblur="this.style.borderColor='rgba(255,255,255,0.08)'; this.style.boxShadow='none';"
            >
        </div>
    </form>

    {{-- GRID PRODUK --}}
    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(220px, 1fr)); gap: 1rem;">

        @forelse ($produks as $produk)
            <div class="stok-card-premium" style="background: rgba(255,255,255,0.03); backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.05); border-radius: 1rem; padding: 0.75rem; transition: all 0.3s ease;">
                {{-- GAMBAR --}}
                <div style="width: 100%; aspect-ratio: 1; border-radius: 0.75rem; overflow: hidden; background: #1e2433; margin-bottom: 0.75rem;">
                    @if($produk->gambar)
                        <img
                            src="{{ asset('storage/'.$produk->gambar) }}"
                            alt="{{ $produk->nama_produk }}"
                            style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.5s ease;"
                        >
                    @else
                        <div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; color: #475569;">
                            <svg xmlns="http://www.w3.org/2000/svg" style="width: 2.5rem; height: 2.5rem;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                    @endif
                </div>

                {{-- INFO --}}
                <h3 style="font-weight: 600; font-size: 0.875rem; color: white; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ $produk->nama_produk }}</h3>
                <p style="font-size: 0.75rem; color: #94a3b8; margin-bottom: 0.5rem;">{{ $produk->satuan }}</p>

                <div style="display: flex; align-items: center; justify-content: space-between;">
                    <span style="font-weight: 700; font-size: 0.875rem; color: #1152d4;">
                        Rp {{ number_format($produk->harga, 0, ',', '.') }}
                    </span>
                    @if($produk->stok == 0)
                        <span style="display: inline-block; padding: 0.125rem 0.5rem; border-radius: 9999px; font-size: 0.625rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; background: rgba(239, 68, 68, 0.15); color: #ef4444;">Habis</span>
                    @elseif($produk->stok < 5)
                        <span style="display: inline-block; padding: 0.125rem 0.5rem; border-radius: 9999px; font-size: 0.625rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; background: rgba(249, 115, 22, 0.15); color: #f97316;">{{ $produk->stok }} sisa</span>
                    @else
                        <span style="display: inline-block; padding: 0.125rem 0.5rem; border-radius: 9999px; font-size: 0.625rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; background: rgba(34, 197, 94, 0.15); color: #22c55e;">{{ $produk->stok }} sisa</span>
                    @endif
                </div>
            </div>

        @empty
            <div style="grid-column: 1 / -1; text-align: center; padding: 3rem 0;">
                <svg xmlns="http://www.w3.org/2000/svg" style="width: 3rem; height: 3rem; margin: 0 auto 0.75rem; color: #475569;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                </svg>
                <p style="font-size: 0.875rem; color: #64748b;">Produk tidak ditemukan.</p>
            </div>
        @endforelse

    </div>

</x-filament::page>
