<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>{{$data['title']}}</title>


  <meta name="csrf-token" content="{{ csrf_token() }}">
  <!-- Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

  <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/css/toastr.css" rel="stylesheet" />

  <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/js/toastr.js"></script>

  <link rel="stylesheet" href="{{asset('tree.css')}}">
  <script src="{{asset('tree.js')}}"></script>
</head>

<body class="container-fluid ">
  <div class="row">
    <div class="col-lg-3">
      <h2 class="text-center">Input Data</h2>
      <form action="javascript:void(0)" id="form-tambah" method="post">
        <div class="form-group">
          <label>Nama</label>
          <input type="text" required class="form-control" name="nama">

        </div>
        <div class="form-group">
          <label>Jenis Kelamin</label>
          <select required class="custom-select" name="jenis_kelamin">
            <option selected disabled>Open this select menu</option>
            <option value="laki-laki">Laki-Laki</option>
            <option value="perempuan">Perempuan</option>
          </select>
        </div>

        <div class="form-group">
          <label>Anak Dari</label>
          <select required class="custom-select" name="anak_dari">
            <option selected disabled>Open this select menu</option>
            <option value="0">Tidak Ada</option>
            @foreach ($data['silsilah'] AS $key => $value)
            <option value="{{$value->id}}">{{$value->nama}}</option>
            @endforeach
          </select>
        </div>
        <div class="text-center" id="is_loading" style="display: none;">
          <div class="spinner-border" role="status">
            <span class="sr-only">Loading...</span>
          </div>
        </div>
        <button type="submit" id="btn_submit" class="btn btn-primary ">Submit</button>
      </form>
    </div>
    <div class="col-lg-9">
      <h2 class="text-center">Visualisasi</h2>



      <div class="body genealogy-body genealogy-scroll">
        <div class="genealogy-tree">

          @foreach($data['level_1'] AS $key => $value)
          <ul class="active">
            <li>
              <a href="javascript:void(0);">
                <div class="member-view-box">
                  <div class="member-image">
                    <div class="member-details">
                      <h3 class=" text-red @if($value->jenis_kelamin == 'laki-laki') text-blue @endif ">{{$value->nama}}</h3>
                    </div>
                  </div>
                </div>
              </a>
              <ul class="active">
                @foreach($data['level_2'] AS $k => $anak)
                <li>
                  <a href="javascript:void(0);">
                    <div class="member-view-box">
                      <div class="member-image">

                        <div class="member-details">
                          <h3 class=" text-red @if($anak->jenis_kelamin == 'laki-laki') text-blue @endif ">{{$anak->nama}}</h3>
                        </div>
                      </div>
                    </div>
                  </a>
                  <ul class="active">
                    @foreach($data['level_3'] AS $x => $cucu)
                    @if($cucu->id_ayah == $anak->id)
                    <li>
                      <a href="javascript:void(0);">
                        <div class="member-view-box">
                          <div class="member-image">

                            <div class="member-details">
                              <h3 class=" text-red @if($cucu->jenis_kelamin == 'laki-laki') text-blue @endif "> {{$cucu->nama}}</h3>
                            </div>
                          </div>
                        </div>
                      </a>
                    </li>
                    @endif
                    @endforeach
                  </ul>
                </li>
                @endforeach
              </ul>
            </li>
          </ul>


          @endforeach

        </div>
      </div>

    </div>
  </div>


  <script>
    $('#form-tambah').submit(function(e) {
      loading()
      e.preventDefault();
      var data = new FormData(this);

      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });

      $.ajax({
        type: "POST",
        url: "{{url('insert')}}",
        data: data,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function(response) {
          if (response.status == 200) {
            toastr.success(response.message);
            location.reload();
          } else {
            toastr.warning(response.message);
          }
          not_loading()

        },
        error: function(response) {
          toastr.warning(response.message);
          not_loading()
        }
      });
    });

    function loading() {
      $('#is_loading').show();
      $('#btn_submit').hide();
    }

    function not_loading() {
      $('#is_loading').hide();
      $('#btn_submit').show();
    }
  </script>
</body>

</html>