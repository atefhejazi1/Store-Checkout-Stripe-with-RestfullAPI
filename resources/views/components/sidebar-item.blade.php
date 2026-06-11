@props(['href', 'icon', 'label'])

<div class="menu-item">
    <a class="menu-link {{ request()->url() === $href ? 'active' : '' }}" href="{{ $href }}">
        <span class="menu-icon">
            <i class="bi {{ $icon }} fs-4"></i>
        </span>
        <span class="menu-title">{{ $label }}</span>
    </a>
</div>
