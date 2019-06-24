<section class="content-header">
        <h1>
          {{(isset($_ch)) ? $_ch : "No Header"}}
          {{-- <small>Preview page</small> --}}
        </h1>
        @include('layout._breadcrumbs')
</section>