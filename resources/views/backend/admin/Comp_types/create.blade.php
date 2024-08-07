@include('backend.includes.loginheader')
@include('backend.includes.nav')
@include('backend.includes.sidebar')


   <a href="{{ url()->previous() }}" class="h4 text-primary" style="margin-left: 20%;"><i class="fa-solid fa-circle-left text-info"></i></a>


<div class="content-wrapper">



{{-- for add level button --}}
<!-- HTML !-->


<!-- With actions -->

<div class="page-wrapper   p-b-100 font-robo " style="margin-top:50px;">
    <div class="wrapper wrapper--w680">
        <div class="card card-1">
            <div class="card-heading2"></div>
            <div class="card-body">
                <h2 class="title">Add Competition Type</h2>
                <form method="POST" action="{{url('admin-create-compType')}}" enctype="multipart/form-data">
                    @csrf


                    <div class="col-12 ">
                        <label for="" class="mb-2">Competition Type Name</label>
                        <input name="name" class="effect-10 rounded" type="text" placeholder="Competition type">
                        <span class="focus-bg"></span>
                    </div>
                    @if ($errors->has('name'))
                        <span class="text-danger text-left">{{ $errors->first('name') }}</span>
                    @endif

                    <div class="col-12 mt-2">
                        <label for="" class="mb-2">Description</label>
                        <textarea name="description" placeholder="Description.."></textarea>

                        @if ($errors->has('description'))
                        <span class="text-danger text-left">{{ $errors->first('description') }}</span>
                    @endif
                    </div>



                    <div class="col-12">

<label for="" class="mb-2">Select comp Type icon</label>
                        <div class="file">
                            <label for="inputTag">
                                Choose Icon<br />
                                <i class="fa-solid fa-image"></i>
                                <input id="inputTag" type="file" name="icon" class="image" />
                                <br />
                                <span id="imageName"></span>
                            </label>
                        </div>

                    </div>
                    @if ($errors->has('icon'))
                        <span class="text-danger text-left">{{ $errors->first('icon') }}</span>
                    @endif

                    <div style="align-item:center;justify-item:center" >
                         <img id="blah" class="rounded-circle mt-2" src="#" height="100px" width="100px" style="margin-left: 40%;"/>
                    </div>

                    <div class="p-t-10">
                        <button class="btn btn--radius btn--green" type="submit" name="submit">Add</button>
                    </div>
                    <div class="p-t-10">
                        <button class="btn btn-secondary" type="reset" name="reset"
                            style=" float: right;">Reset</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
</div>




<!-- Jquery JS-->
<script src="{{ asset('backend/sportsForm/vendor/jquery/jquery.min.js') }}"></script>
<!-- Vendor JS-->
<script src="{{ asset('backend/sportsForm/vendor/select2/select2.min.js') }}"></script>
<script src="{{ asset('backend/sportsForm/vendor/datepicker/moment.min.js') }}"></script>
<script src="{{ asset('backend/sportsForm/vendor/datepicker/daterangepicker.js') }}"></script>

<!-- Main JS-->
<script src="{{asset('backend/sportsForm/js/global.js')}}"></script>

@include('backend.includes.footer')

<script>
    let input = document.getElementById("inputTag");
    let imageName = document.getElementById("imageName")

    input.addEventListener("change", () => {
        let inputImage = document.querySelector("input[type=file]").files[0];

        imageName.innerText = inputImage.name;
    })
</script>


{{--               --}}

<script>

inputTag.onchange = evt => {
  const [file] = inputTag.files
  if (file) {
    blah.src = URL.createObjectURL(file)
  }
}
</script>


