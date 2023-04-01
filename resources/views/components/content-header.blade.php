<div>
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">{{ $title }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ URL::to('home') }}">{{ __('Dashboard') }}</a></li>
                        <li class="breadcrumb-item active">{{ $lvl1 }}</li>
                        <li class="breadcrumb-item active">{{ $lvl2 }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
</div>