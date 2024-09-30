{{-- Boostrap footer --}}
<footer class="py-4">
    <div class="container w-100 d-flex align-items-center justify-content-center" style="max-width: 100%;">
        <div class="row d-flex justify-content-between align-items-center py-4 w-100">
            <div class="col-md col-sm-6">
                <ul class="d-flex gap-3 mb-0">
                    @if($company_facebook)
                        <li><a href="{{ $company_facebook }}" target="_blank" class="text-white fs-20"><i class="la la-facebook"></i></a></li>
                    @endif

                    @if($company_twitter)
                        <li><a href="{{ $company_twitter }}" target="_blank"  class="text-white fs-20"><i class="la la-twitter"></i></a></li>
                    @endif

                    @if($company_instagram)
                        <li><a href="{{ $company_instagram }}" target="_blank" class="text-white fs-20"><i class="la la-instagram"></i></a></li>
                    @endif

                    @if($company_youtube)
                        <li><a href="{{ $company_youtube }}" target="_blank" class="text-white fs-20"><i class="la la-youtube"></i></a></li>
                    @endif

                    @if($company_linkedin)
                        <li><a href="{{ $company_linkedin }}" target="_blank" class="text-white fs-20"><i class="la la-linkedin"></i></a></li>
                    @endif
                </ul>
            </div>
            <div class="col-md col-sm-6">
                <div class="cp d-flex justify-content-end">
                    <span>
                        {{ $company_name ?? env('APP_NAME') }}
                        © {{ date('Y') }} All Right Reserved 
                    </span>
                </div>
            </div>
        </div>
    </div>
</footer>
