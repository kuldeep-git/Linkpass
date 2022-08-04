<div class="pt-4 align-items-center" >
    <!-- Mask -->
    <span class="mask bg-gradient-default opacity-8"></span>
    <!-- Header container -->
    <div class="container-fluid d-flex align-items-center">
        <div class="row">
            <div class="col-md-12 {{ $class ?? '' }}">
                <h4 class="">{{ $title }}</h4>
                @if (isset($description) && $description)
                    <p class="mt-0 mb-3">{{ $description }}</p>
                @endif
            </div>
        </div>
    </div>
</div>