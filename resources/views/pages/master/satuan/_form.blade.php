{!! Form::model($column, [
    'url'     => $url,
    'method'    => $method,
    'id'        => 'form-action'
]) !!}
    <div class="card-body p-1">
        <div class="form-group mb-1 text-sm">
            <label for="name" class="mb-0 font-weight-normal">Nama</label>
            <input type="text" name="name" id="name" class="form-control form-control-sm" value="{{ old('name') ?? $column->name }}">
        </div>
    </div>

    <div class="card-footer p-1">
        <div class="d-flex justify-content-center">
            @if ($column->id)
                <button type="submit" class="btn btn-warning btn-submit btn-xs py-0 px-1 mr-1">UPDATE</button>
            @else
                <button type="submit" class="btn btn-primary btn-submit btn-xs py-0 px-1">SAVE</button>
                <button type="reset" class="btn btn-warning btn-reset btn-xs py-0 px-1 mx-1">RESET</button>
            @endif
            <button type="reset" class="btn btn-danger btn-back btn-xs py-0 px-1">BACK</button>
        </div>
    </div>
{!! Form::close() !!}
