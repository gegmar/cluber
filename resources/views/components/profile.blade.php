@auth
<div class="sidebar-header d-flex align-items-center"><a href="#">
        <div class="avatar"><img src="/img/avatar_default.png" alt="..." class="img-fluid rounded-circle"></div>
    </a>
    <div class="title">
        <h1 class="h4">{{ auth()->user()->name }}</h1>
        <p>{{ auth()->user()->email }}</p>
    </div>
</div>
@endauth