<x-front-layout title="Categories">

    <!-- Page Header -->
    <div class="page-header">
        <div class="container">
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                <h1 class="page-header-title">All Categories</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item active">Categories</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <section class="categories-section" style="padding-top:3rem;">
        <div class="container">

            @if($categories->count())
            <div class="row g-3">
                @foreach($categories as $index => $category)
                <div class="col-lg-3 col-md-4 col-6">
                    <a href="{{ route('products.index', ['category_id' => $category->id]) }}" class="category-card">
                        @if($category->image)
                            <img class="category-card-img" src="{{ $category->image_url }}" alt="{{ $category->name }}">
                        @else
                            <div class="category-placeholder cat-c-{{ $index % 8 }}">
                                {{ strtoupper(substr($category->name, 0, 2)) }}
                            </div>
                        @endif
                        <div class="category-card-body">
                            <div class="category-card-name">{{ $category->name }}</div>
                            <div class="category-card-count">{{ $category->products_count }} {{ Str::plural('product', $category->products_count) }}</div>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>
            @else
            <div class="text-center py-5">
                <p style="color:var(--color-muted);">No categories available yet.</p>
                <a href="{{ route('home') }}" class="btn-store-outline mt-3">Back to Home</a>
            </div>
            @endif

        </div>
    </section>

</x-front-layout>
