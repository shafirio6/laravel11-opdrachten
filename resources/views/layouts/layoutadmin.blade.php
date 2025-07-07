@include('layouts.base.start')


@include('layouts.base.navbar')


<!-- strat wrapper -->
<div class="h-screen flex flex-row flex-wrap">

    @include('layouts.base.sidebar')

    <!-- strat content -->
    <div class="bg-gray-100 flex-1 p-6 md:mt-16">
            @yield('topmenu')
            @yield('content')
    </div>
    <!-- end content -->

</div>
<!-- end wrapper -->



@include('layouts.base.end')
