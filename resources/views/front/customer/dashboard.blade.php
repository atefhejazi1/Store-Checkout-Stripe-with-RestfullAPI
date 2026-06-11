<x-front-layout title="My Dashboard — {{ config('app.name') }}">

{{-- Page header --}}
<div class="page-header">
    <div class="container">
        <h1 class="page-header-title">My Dashboard</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item active">My Dashboard</li>
            </ol>
        </nav>
    </div>
</div>

<section style="padding:3rem 0 4rem;background:#f8fafc;min-height:60vh;">
<div class="container">

    {{-- Welcome banner --}}
    <div class="cd-welcome">
        <div class="cd-welcome-info">
            <div class="cd-welcome-label">Welcome back</div>
            <h2 class="cd-welcome-name">{{ $user->name }}</h2>
            <div class="cd-welcome-meta">
                <i class="lni lni-calendar me-1"></i> Member since {{ $user->created_at->format('F Y') }}
                &nbsp;·&nbsp;
                <i class="lni lni-envelope me-1"></i> {{ $user->email }}
            </div>
        </div>
        <div class="cd-welcome-actions">
            <a href="{{ route('products.index') }}" class="cd-btn-primary">
                <i class="lni lni-shop"></i> Browse Shop
            </a>
            <a href="{{ route('cart.index') }}" class="cd-btn-ghost">
                <i class="lni lni-cart"></i> My Cart
            </a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="cd-btn-logout">
                    <i class="lni lni-exit"></i> Sign Out
                </button>
            </form>
        </div>
    </div>

    {{-- Stat cards --}}
    <div class="row g-3 mb-3">
        @php
        $statCards = [
            ['label' => 'Total Orders',  'value' => $stats['total'],      'icon' => 'lni-package',          'accent' => '#6366f1', 'tint' => '#eef2ff'],
            ['label' => 'Pending',       'value' => $stats['pending'],     'icon' => 'lni-timer',            'accent' => '#f59e0b', 'tint' => '#fef3c7'],
            ['label' => 'Processing',    'value' => $stats['processing'],  'icon' => 'lni-reload',           'accent' => '#0167f3', 'tint' => '#eff6ff'],
            ['label' => 'Delivered',     'value' => $stats['delivered'],   'icon' => 'lni-checkmark-circle', 'accent' => '#10b981', 'tint' => '#ecfdf5'],
        ];
        @endphp
        @foreach($statCards as $card)
        <div class="col-6 col-lg-3">
            <div class="cd-stat">
                <div class="cd-stat-icon" style="background:{{ $card['tint'] }};">
                    <i class="lni {{ $card['icon'] }}" style="color:{{ $card['accent'] }};"></i>
                </div>
                <div class="cd-stat-value">{{ $card['value'] }}</div>
                <div class="cd-stat-label">{{ $card['label'] }}</div>
            </div>
        </div>
        @endforeach
    </div>

    {{-- Total spent wide card --}}
    <div class="cd-spent mb-4">
        <div class="cd-spent-icon">
            <i class="lni lni-dollar" style="color:#10b981;font-size:1.3rem;"></i>
        </div>
        <div>
            <div class="cd-spent-label">Total Spent</div>
            <div class="cd-spent-value">${{ number_format($stats['spent'], 2) }}</div>
        </div>
        <div class="ms-auto">
            <span style="font-size:.72rem;color:#94a3b8;">Across {{ $stats['total'] }} order{{ $stats['total'] !== 1 ? 's' : '' }}</span>
        </div>
    </div>

    {{-- Orders table --}}
    <div class="cd-table-card">
        <div class="cd-table-head">
            <h3 class="cd-table-title">
                <i class="lni lni-list me-2" style="color:#0167f3;"></i> Recent Orders
            </h3>
            <span class="cd-table-count">{{ $recentOrders->count() }} record{{ $recentOrders->count() !== 1 ? 's' : '' }}</span>
        </div>

        @if($recentOrders->isEmpty())
        <div class="cd-empty">
            <div class="cd-empty-icon">
                <i class="lni lni-package"></i>
            </div>
            <p class="cd-empty-text">You haven't placed any orders yet.</p>
            <a href="{{ route('products.index') }}" class="cd-btn-primary">
                <i class="lni lni-shop me-1"></i> Start Shopping
            </a>
        </div>
        @else
        <div class="table-responsive">
            <table class="cd-table">
                <thead>
                    <tr>
                        <th>Order #</th>
                        <th>Date</th>
                        <th>Items</th>
                        <th>Status</th>
                        <th>Payment</th>
                        <th style="text-align:right;">Total</th>
                        <th style="text-align:right;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recentOrders as $order)
                    @php
                        $sc = match($order->status) {
                            'pending'    => ['#fef3c7','#92400e','#f59e0b'],
                            'processing' => ['#dbeafe','#1e40af','#3b82f6'],
                            'delivered'  => ['#dcfce7','#14532d','#22c55e'],
                            'completed'  => ['#dcfce7','#14532d','#22c55e'],
                            'cancelled'  => ['#fee2e2','#7f1d1d','#ef4444'],
                            default      => ['#f1f5f9','#475569','#94a3b8'],
                        };
                        $pc = $order->payment_status === 'paid'
                            ? ['#dcfce7','#14532d']
                            : ['#fff7ed','#9a3412'];
                        $total = $order->items->sum(fn($i) => $i->price * $i->quantity);
                    @endphp
                    <tr class="cd-row">
                        <td><span class="cd-order-num">#{{ $order->number }}</span></td>
                        <td><span class="cd-muted">{{ $order->created_at->format('d M Y') }}</span></td>
                        <td><span class="cd-muted">{{ $order->items->count() }} item{{ $order->items->count() !== 1 ? 's' : '' }}</span></td>
                        <td>
                            <span class="cd-badge" style="background:{{ $sc[0] }};color:{{ $sc[1] }};">
                                <span class="cd-badge-dot" style="background:{{ $sc[2] }};"></span>
                                {{ ucfirst($order->status) }}
                            </span>
                        </td>
                        <td>
                            <span class="cd-badge" style="background:{{ $pc[0] }};color:{{ $pc[1] }};">
                                {{ ucfirst($order->payment_status) }}
                            </span>
                        </td>
                        <td style="text-align:right;">
                            <span class="cd-total">${{ number_format($total, 2) }}</span>
                        </td>
                        <td style="text-align:right;">
                            @if($order->payment_status === 'pending')
                                <a href="{{ route('orders.payments.create', $order->id) }}" class="cd-action-pay">Pay Now</a>
                            @else
                                <a href="{{ route('orders.confirmation', $order->id) }}" class="cd-action-view">View</a>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif
    </div>

</div>
</section>

<style>
/* ── Welcome banner ── */
.cd-welcome {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 1.5rem;
    background: linear-gradient(135deg, #0f172a 0%, #1e3a5f 60%, #0f2d4f 100%);
    border-radius: 18px;
    padding: 2rem 2.5rem;
    margin-bottom: 2rem;
    flex-wrap: wrap;
}
.cd-welcome-label {
    font-size:.72rem;font-weight:600;text-transform:uppercase;
    letter-spacing:.1em;color:rgba(255,255,255,.45);margin-bottom:.35rem;
}
.cd-welcome-name {
    font-size:1.65rem;font-weight:800;color:#fff;margin:0 0 .45rem;
}
.cd-welcome-meta {
    font-size:.78rem;color:rgba(255,255,255,.45);
}
.cd-welcome-meta i { opacity:.7; }
.cd-welcome-actions { display:flex;gap:.75rem;flex-shrink:0;flex-wrap:wrap; }
.cd-btn-primary {
    display:inline-flex;align-items:center;gap:.45rem;
    background:#0167f3;color:#fff;text-decoration:none;
    padding:.65rem 1.3rem;border-radius:10px;
    font-size:.82rem;font-weight:600;
    transition:background .2s,transform .15s;
}
.cd-btn-primary:hover { background:#0052cc;color:#fff;transform:translateY(-1px); }
.cd-btn-ghost {
    display:inline-flex;align-items:center;gap:.45rem;
    background:rgba(255,255,255,.1);color:#fff;text-decoration:none;
    border:1px solid rgba(255,255,255,.14);
    padding:.65rem 1.3rem;border-radius:10px;
    font-size:.82rem;font-weight:600;
    transition:background .2s;
}
.cd-btn-ghost:hover { background:rgba(255,255,255,.18);color:#fff; }
.cd-btn-logout {
    display:inline-flex;align-items:center;gap:.45rem;
    background:rgba(239,68,68,.15);color:#fca5a5;
    border:1px solid rgba(239,68,68,.25);
    padding:.65rem 1.3rem;border-radius:10px;
    font-size:.82rem;font-weight:600;cursor:pointer;
    transition:background .2s,color .2s;
}
.cd-btn-logout:hover { background:rgba(239,68,68,.28);color:#fff; }

/* ── Stat cards ── */
.cd-stat {
    background:#fff;border-radius:16px;
    border:1px solid #f1f5f9;
    box-shadow:0 1px 8px rgba(0,0,0,.05);
    padding:1.5rem;
}
.cd-stat-icon {
    width:44px;height:44px;border-radius:11px;
    display:flex;align-items:center;justify-content:center;
    margin-bottom:1rem;font-size:1.2rem;
}
.cd-stat-value {
    font-size:2rem;font-weight:800;color:#0f172a;
    line-height:1;margin-bottom:.35rem;
}
.cd-stat-label { font-size:.78rem;color:#64748b;font-weight:500; }

/* ── Total spent ── */
.cd-spent {
    background:#fff;border-radius:16px;
    border:1px solid #f1f5f9;box-shadow:0 1px 8px rgba(0,0,0,.05);
    padding:1.25rem 1.75rem;
    display:flex;align-items:center;gap:1rem;
}
.cd-spent-icon {
    width:50px;height:50px;border-radius:13px;
    background:#ecfdf5;
    display:flex;align-items:center;justify-content:center;flex-shrink:0;
}
.cd-spent-label {
    font-size:.72rem;color:#64748b;font-weight:600;
    text-transform:uppercase;letter-spacing:.06em;margin-bottom:.2rem;
}
.cd-spent-value { font-size:1.55rem;font-weight:800;color:#0f172a; }

/* ── Orders table card ── */
.cd-table-card {
    background:#fff;border-radius:18px;
    border:1px solid #f1f5f9;
    box-shadow:0 1px 8px rgba(0,0,0,.05);
    overflow:hidden;
}
.cd-table-head {
    padding:1.4rem 1.75rem;
    border-bottom:1px solid #f1f5f9;
    display:flex;align-items:center;justify-content:space-between;
}
.cd-table-title {
    font-size:1rem;font-weight:700;color:#0f172a;margin:0;
    display:flex;align-items:center;
}
.cd-table-count { font-size:.75rem;color:#94a3b8; }

/* Table ── */
.cd-table { width:100%;border-collapse:collapse; }
.cd-table thead tr { background:#f8fafc;border-bottom:1px solid #f1f5f9; }
.cd-table th {
    padding:.85rem 1.25rem;
    font-size:.68rem;font-weight:700;color:#94a3b8;
    text-transform:uppercase;letter-spacing:.07em;
    white-space:nowrap;
}
.cd-row { border-bottom:1px solid #f8fafc;transition:background .12s; }
.cd-row:hover { background:#fafbff; }
.cd-row:last-child { border-bottom:none; }
.cd-row td { padding:.95rem 1.25rem;vertical-align:middle; }
.cd-order-num { font-size:.83rem;font-weight:700;color:#0f172a; }
.cd-muted { font-size:.8rem;color:#64748b; }
.cd-badge {
    display:inline-flex;align-items:center;gap:.3rem;
    font-size:.68rem;font-weight:700;
    padding:.3rem .8rem;border-radius:100px;
    text-transform:capitalize;letter-spacing:.03em;
    white-space:nowrap;
}
.cd-badge-dot {
    width:5px;height:5px;border-radius:50%;flex-shrink:0;
}
.cd-total { font-size:.88rem;font-weight:700;color:#0f172a; }
.cd-action-pay {
    background:#0167f3;color:#fff;text-decoration:none;
    font-size:.72rem;font-weight:600;
    padding:.35rem 1rem;border-radius:8px;
    transition:background .2s;white-space:nowrap;
}
.cd-action-pay:hover { background:#0052cc;color:#fff; }
.cd-action-view {
    background:#f1f5f9;color:#475569;text-decoration:none;
    font-size:.72rem;font-weight:600;
    padding:.35rem 1rem;border-radius:8px;
    transition:background .2s;white-space:nowrap;
}
.cd-action-view:hover { background:#e2e8f0;color:#1e293b; }

/* ── Empty state ── */
.cd-empty {
    text-align:center;padding:4rem 2rem;
    display:flex;flex-direction:column;align-items:center;gap:1rem;
}
.cd-empty-icon {
    width:72px;height:72px;border-radius:50%;
    background:#f8fafc;
    display:flex;align-items:center;justify-content:center;
    font-size:1.8rem;color:#cbd5e1;
}
.cd-empty-text { font-size:.9rem;color:#64748b;margin:0; }

/* ── Responsive ── */
@media (max-width:768px) {
    .cd-welcome { padding:1.5rem; }
    .cd-welcome-name { font-size:1.3rem; }
    .cd-welcome-actions { width:100%; }
    .cd-btn-primary, .cd-btn-ghost { flex:1;justify-content:center; }
}
</style>

</x-front-layout>
