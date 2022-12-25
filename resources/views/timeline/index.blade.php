@extends('templates.default')

@section('content')
    <div class="row">
        <div class="col-lg-6">
           <form action="post" action="">
            <div class="form-group">
                <textarea class="form-control" placeholder="Что нового" name="" id="" cols="30" rows="10"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Опубликовать</button>
           </form>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-5">
            
        </div>
    </div>
@endsection
