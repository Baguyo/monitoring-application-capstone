@extends('admin.layouts.app')

@section('content')
    <div class="container-fluid p-3">
        
      @pageHeader
        ADMIN | Scan
      @endpageHeader  

        <hr>

        <div id="qr-reader" style="width: 600px" class="mx-auto"></div>


        <script src="https://unpkg.com/html5-qrcode@2.0.9/dist/html5-qrcode.min.js"></script>

        {{-- FOUND MODAL --}}
        <div class="modal found-modal" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title">STUDENT INFORMATION</h5>
                  <button type="button" class="md-close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                
                    <div class="container">
                      <div class="row">
                        <div class="col-lg-6 text-center">
                            <h1>image</h1>
                            <img src="" alt="" class="student-image">
                        </div>
                        <div class="col-lg-6">
                            <h3 class="name"></h3>
                            <h3 class="section"></h3>
                        </div>
                      </div>
                    </div>

                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-primary">Save changes</button>
                  <button type="button" class="btn btn-secondary md-close" data-dismiss="modal">Close</button>
                </div>
              </div>
            </div>
        </div>


        {{-- NOT FOUND MODAL --}}
        <div class="modal nf-modal" tabindex="-1" role="dialog" style="z-index: 999999999;">
            <div class="modal-dialog modal-lg" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title">STUDENT INFORMATION</h5>
                  <button type="button" class="md-close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                        <h1>NOT FOUND</h1>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-primary">Save changes</button>
                  <button type="button" class="btn btn-secondary md-close" data-dismiss="modal">Close</button>
                </div>
              </div>
            </div>
        </div>
        
    
<script>


    var previousCode;
    function onScanSuccess(decodedText, decodedResult) {

        if(previousCode !== decodedText){
            previousCode = decodedText;        
            // console.log(`Code scanned = ${decodedText}`, decodedResult);
            var url = '{{ route('admin.scanCode') }}';
            console.log(decodedText);

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            // alert(decodedText);
            $.ajax({
                type: "POST",
                url: url,
                data: {'code':decodedText},
                success: function (response) {
                  // alert(response);
                    if(typeof(response) === 'object'){
                        // alert(response.student.user.name)

                        $('.student-image').attr('src', " {{ Storage::url('defaults/userdefault.png') }} ");
                        
                        

                        /**
                         * 
                         * DISPLAY THE USER IMAGE
                         * 
                        */

                        $('.name').html( "Name: " + response.student.user.name);
                        $('.section').html( "Section: " + response.student.section.name);
                        
                        $('.found-modal').modal('show');
                        $('#qr-reader').hide();
                        
                        setTimeout(() => {
                            $('.found-modal').modal('hide');
                            $('#qr-reader').show();
                        }, 2000);
                    }else{
                        $('.nf-modal').modal('show');
                        $('#qr-reader').hide();
                        setTimeout(() => {
                            $('.nf-modal').modal('hide');
                            $('#qr-reader').show();
                        }, 2000);
                        
                    }
                }
            });
        }
        
    }
    var html5QrcodeScanner = new Html5QrcodeScanner(
        "qr-reader", { fps: 10, qrbox: 250 });
    html5QrcodeScanner.render(onScanSuccess);

    
</script>

    </div>

@endsection