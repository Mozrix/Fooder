@extends('layouts.admin')

@section('content')
<div class="card">
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px; flex-wrap:wrap; gap:12px;">
        <form method="get" style="display:flex; gap:10px; align-items:center;">
            <input class="input" name="q" placeholder="Cari nama atau email..." value="{{ request('q') }}" style="min-width:240px; margin:0;">
            @if($type === 'users')
                <select name="role" class="input" style="margin:0;" onchange="this.form.submit()">
                    <option value="">Semua Role</option>
                    <option value="admin" {{ request('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="seller" {{ request('role') === 'seller' ? 'selected' : '' }}>Seller</option>
                    <option value="customer" {{ request('role') === 'customer' ? 'selected' : '' }}>Customer</option>
                </select>
            @endif
            <button class="btn" type="submit">Cari</button>
            @if(request('q') || request('role'))
                <a href="{{ route('admin.'.$type) }}" style="color:var(--m); text-decoration:none; font-size:13px;">Reset</a>
            @endif
        </form>

        <a class="btn" href="{{ route('admin.'.$type.'.create') }}">+ Tambah {{ $title }}</a>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                @if($type === 'users')
                    <th>Email</th>
                    <th>Role</th>
                @else
                    <th>Jumlah Produk</th>
                @endif
                <th>Tanggal Terdaftar</th>
                <th style="text-align:right;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($items as $i => $item)
                <tr>
                    <td>{{ $items->firstItem() + $i }}</td>
                    <td style="font-weight:600;">
                        {{ $type === 'users' ? $item->nama : $item->nama_kategori }}
                    </td>
                    @if($type === 'users')
                        <td>{{ $item->email }}</td>
                        <td>
                            <span class="badge" style="background: {{ $item->role === 'admin' ? '#fee2e2; color:#b91c1c' : ($item->role === 'seller' ? '#fef3c7; color:#b45309' : '#e0f2fe; color:#0369a1') }}; font-weight:600; text-transform:capitalize;">
                                {{ $item->role }}
                            </span>
                        </td>
                    @else
                        <td>
                            <span class="badge" style="background:#f1f5f9; color:#475569;">
                                {{ $item->produk_count ?? 0 }} Produk
                            </span>
                        </td>
                    @endif
                    <td>{{ $item->created_at?->format('d M Y, H:i') ?? '-' }}</td>
                    <td style="text-align:right;">
                        <a href="{{ route('admin.'.$type.'.edit', $item) }}" class="btn" style="background:#f1f5f9; color:#334155; padding:6px 12px; font-size:13px; margin-right:4px;">Edit</a>
                        <form style="display:inline" method="post" action="{{ route('admin.'.$type.'.destroy', $item) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                            @csrf
                            @method('DELETE')
                            <button class="danger" style="cursor:pointer; font-size:13px; padding:6px 10px; border-radius:8px;">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" style="text-align:center; padding:30px; color:var(--m);">
                        Tidak ada data ditemukan.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div style="margin-top:20px;">
        {{ $items->links() }}
    </div>
</div>
@endsection
