@extends('admin.layouts.app')

@section('content')
    <div class="container-fluid p-3">

        @pageHeader
            ADMIN | Scan
        @endpageHeader

        <hr>
        {{-- style="width: 600px; transform: scaleX(-1)" --}}


        <div class=" mb-2 bg-white shadow rounded">
            <div class="container-fluid p-5">
                <h1>Student Information</h1>
                <hr>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="img-found">

                        </div>
                    </div>
                    <div class="col-lg-6">
                        <h3 class="name"></h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="scanner-container">
          <button class="btn btn-info switch-camera-mirror">
            Mirror Camera</button>
          <div id="qr-reader" style="width: 600px; " class="mx-auto"></div>
        </div>
        

    </div>


    <script type="module">

    const switchCameraMirror = $('.switch-camera-mirror');
    switchCameraMirror.click(function (e) { 
      // console.log($('#qr-reader').attr('style').lenght);
      // console.log($('#qr-reader').inlineStyle('transform'));
      var el = $('#qr-reader[style*="transform"]');
      if(el.length){
        $('#qr-reader').css('transform', '');
      }else{
        $('#qr-reader').css('transform', 'scaleX(-1)');
      }
    });


    var previousCode;
    function onScanSuccess(decodedText, decodedResult) {

        if(previousCode !== decodedText){
            previousCode = decodedText;        
            // console.log(`Code scanned = ${decodedText}`, decodedResult);
            var url = '{{ route('admin.scanCode') }}';
            

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
                        
                        if(!response.student.user.img_path){
                          // $('.student-image').attr('src', " {{ Storage::url('defaults/logo.jpg') }} ");
                          $('.img-found').html(`<img src={{ Storage::url('defaults/logo.jpg') }} alt="">`);
                        }else{
                        $('.img-found').html(`<img src={{ Storage::url('${response.student.user.img_path}') }} alt="">`);
                        }

                        $('.name').html( "Name: " + response.student.user.name);
                        var exist_student = new Audio(` {{ Storage::url('sounds/success.mp3') }} `);
                        exist_student.play();
                    }else{
                          $('.img-found').html(`<h3>Not found</h3>`);
                          $('.name').html( "Not found");
                          var not_found = new Audio(` {{ Storage::url('sounds/wrong.mp3') }} `);
                          not_found.play();
                    }
                }
            });
        }
        
    }
    var html5QrcodeScanner = new Html5QrcodeScanner(
        "qr-reader", { fps: 10, qrbox: 250 });
    html5QrcodeScanner.render(onScanSuccess);

    
</script>



@endsection
