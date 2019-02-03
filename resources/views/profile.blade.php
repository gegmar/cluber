@extends('layouts.common')

@section('title', 'Ticketshop')

@section('page-title', __('ticketshop.my_profile'))

@section('nav-link', route('profile.show'))

@section('content')
<!---  Breadcrumb -->
<div class="breadcrumb-holder container-fluid">
    <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('ts.events') }}">{{__('ticketshop.back_to_events')}}</a></li>
        <li class="breadcrumb-item active">{{__('ticketshop.my_profile')}}</li>
    </ul>
</div>
<section>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-4">
                <div class="card card-profile">
                    <div class="card-header"></div>
                    <div class="card-body text-center"><img src="/img/avatar_default.png" class="card-profile-img">
                        <h3 class="mb-3">{{ Auth::user()->name }}</h3>
                    </div>
                </div>
                <form class="card" action="{{ route('profile.update') }}" method="POST">
                    @csrf
                    <div class="card-header">
                        <h3 class="card-title">{{__('ticketshop.my_profile')}}</h3>
                    </div>
                    <div class="card-body">
                        @csrf
                        <div class="form-group">
                            <label class="form-label">{{__('ticketshop.name')}}</label>
                            <input name="name" placeholder="{{ Auth::user()->name }}" class="form-control">
                        </div>
                        <div class="form-group">
                            <label class="form-label">{{__('ticketshop.password')}}</label>
                            <input type="password" name="password" placeholder="*******" class="form-control">
                        </div>
                        <div class="form-group">
                            <label class="form-label">{{__('ticketshop.password_confirmation')}}</label>
                            <input type="password" name="password_confirmation" placeholder="*******" class="form-control">
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <button class="btn btn-primary">{{__('ticketshop.save')}}</button>
                    </div>
                </form>
            </div>
            {{--
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <h3>My Tickets</h3>
                    </div>
                    <div class="list-group card-list-group">
                        <div class="list-group-item py-5">
                            <div class="media">
                                <div style="background-image: url(img/avatar-7.jpg)" class="media-object avatar avatar-md mr-3"></div>
                                <div class="media-body">
                                    <div class="media-heading"><small class="float-right">10 min</small>
                                        <h5>Nathan Andrews</h5>
                                    </div>
                                    <div class="text-muted text-small">One morning, when Gregor Samsa woke from
                                        troubled dreams, he found himself transformed in his bed into a horrible
                                        vermin. He lay on his armour-like back, and if he lifted his head a little he
                                        could see his brown belly, slightly domed and divided by arches into stiff
                                        sections</div>
                                    <div class="media-list">
                                        <div class="media mt-4">
                                            <div style="background-image: url(img/avatar-3.jpg)" class="media-object avatar mr-3"></div>
                                            <div class="media-body text-muted text-small"><strong class="text-dark">Serenity
                                                    Mitchelle: </strong>The bedding was hardly able to cover it and
                                                seemed ready to slide off any moment. His many legs, pitifully thin
                                                compared with the size of the rest of him, waved about helplessly as he
                                                looked. &quot;What's happened to me?&quot; he thought. It wasn't a
                                                dream.</div>
                                        </div>
                                        <div class="media mt-4">
                                            <div style="background-image: url(img/avatar-1.jpg)" class="media-object avatar mr-3"></div>
                                            <div class="media-body text-muted text-small"><strong class="text-dark">Tony
                                                    O'Brian: </strong>His room, a proper human room although a little
                                                too small, lay peacefully between its four familiar walls. A collection
                                                of textile samples lay spread out on the table.</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="list-group-item py-5">
                            <div class="media">
                                <div style="background-image: url(img/avatar-7.jpg)" class="media-object avatar avatar-md mr-3"></div>
                                <div class="media-body">
                                    <div class="media-heading"><small class="float-right text-muted">12 min</small>
                                        <h5>Nathan Andrews</h5>
                                    </div>
                                    <div class="text-muted text-small">Samsa was a travelling salesman - and above it
                                        there hung a picture that he had recently cut out of an illustrated magazine
                                        and housed in a nice, gilded frame.</div>
                                </div>
                            </div>
                        </div>
                        <div class="list-group-item py-5">
                            <div class="media">
                                <div style="background-image: url(img/avatar-7.jpg)" class="media-object avatar avatar-md mr-3"></div>
                                <div class="media-body">
                                    <div class="media-heading"><small class="float-right text-muted">34 min</small>
                                        <h5>Nathan Andrews</h5>
                                    </div>
                                    <div class="text-muted text-small">He must have tried it a hundred times, shut his
                                        eyes so that he wouldn't have to look at the floundering legs, and only stopped
                                        when he began to feel a mild, dull pain there that he had never felt before.</div>
                                    <div class="media-list">
                                        <div class="media mt-4">
                                            <div style="background-image: url(img/avatar-6.jpg)" class="media-object avatar mr-3"></div>
                                            <div class="media-body text-muted text-small"><strong class="text-dark">Javier
                                                    Gregory: </strong>One morning, when Gregor Samsa woke from troubled
                                                dreams, he found himself transformed in his bed into a horrible vermin.
                                                He lay on his armour-like back, and if he lifted his head a little he
                                                could see his brown belly, slightly domed and divided by arches into
                                                stiff sections</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            --}}
        </div>
    </div>
</section>
@endsection

@section('custom-js')
<script type="text/javascript">
    $(document).ready(function() {

    });
</script>
@endsection