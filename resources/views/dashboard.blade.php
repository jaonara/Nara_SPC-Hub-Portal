<x-app-layout>
    <x-slot name="header">
        <h2 class="dashboard-header-title">Dashboard</h2>
    </x-slot>

    <div class="dashboard-page">
        <div class="dashboard-content">
            <div class="dashboard-hero spc-campus-dashboard">
                <div class="dashboard-hero-content">
                    <p class="dashboard-hero-label">SPC Hub</p>
                    <h1 class="dashboard-hero-title">Welcome, {{ Auth::user()->name }}</h1>
                    <p class="dashboard-hero-text">Manage your marketplace activity and student profile in one place.</p>
                </div>
            </div>

            <div class="dashboard-actions">
                <a href="{{ route('products.index') }}" class="dashboard-card group">
                    <p class="dashboard-card-label">Marketplace</p>
                    <h2 class="dashboard-card-title">Buy &amp; Sell</h2>
                    <p class="dashboard-card-text">Browse items posted by the SPC community.</p>
                    <span class="dashboard-card-link">Browse listings &rarr;</span>
                </a>

                <a href="{{ route('products.create') }}" class="dashboard-card-dark group">
                    <p class="dashboard-card-label">Marketplace</p>
                    <h2 class="dashboard-card-title">Post an item</h2>
                    <p class="dashboard-card-text">List something for other students to discover.</p>
                    <span class="dashboard-card-link">Create listing &rarr;</span>
                </a>

                <a href="{{ route('lost-found.index') }}" class="dashboard-card dashboard-card-lost-found group">
                    <p class="dashboard-card-label">Community board</p>
                    <h2 class="dashboard-card-title">Lost &amp; Found</h2>
                    <p class="dashboard-card-text">Report missing items or help return what you found.</p>
                    <span class="dashboard-card-link dashboard-card-link-accent">View reports &rarr;</span>
                </a>
            </div>

            <section class="dashboard-profile">
                <div class="dashboard-profile-header">
                    <div>
                        <p class="dashboard-profile-label">Account</p>
                        <h2 class="dashboard-profile-title">Student information</h2>
                    </div>
                    <a href="{{ route('profile.edit') }}" class="dashboard-profile-link">Edit profile &rarr;</a>
                </div>

                <dl class="dashboard-profile-grid">
                    <div class="dashboard-profile-item"><dt>Student ID</dt><dd>{{ Auth::user()->student_id ?: 'Not provided' }}</dd></div>
                    <div class="dashboard-profile-item"><dt>Course</dt><dd>{{ Auth::user()->course ?: 'Not provided' }}</dd></div>
                    <div class="dashboard-profile-item"><dt>Year level</dt><dd>{{ Auth::user()->year_level ?: 'Not provided' }}</dd></div>
                    <div class="dashboard-profile-item"><dt>Contact number</dt><dd>{{ Auth::user()->contact_number ?: 'Not provided' }}</dd></div>
                </dl>
            </section>
        </div>
    </div>
</x-app-layout>