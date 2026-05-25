<div class="container-fluid">
    @php
        $settings = setting();
    @endphp
    <div class="row">
        <div class="col-12">
            <footer
                class="footer-area d-sm-flex justify-content-center align-items-center justify-content-between">
                <div class="copywrite-text">
                    <p class="font-13">{{$settings->copy_right}}</p>
                </div>
            </footer>
        </div>
    </div>
</div>