{!! Form::model($column, [
    'url'     => $url,
    'method'    => $method,
    'id'        => 'form-action'
]) !!}
    <div class="card-body p-1">
        <div class="form-group">
            <label for="user" class="mb-0 font-weight-normal text-sm">User</label>
            <select class="form-control form-control-sm select2" name="user" id="user">
                <option value=""></option>
                @foreach ($users as $user)
                    <option value="{{ $user->id }}">{{ ucwords($user->name) }} </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="navigations" class="mb-0 font-weight-normal text-sm">Navigation</label>
            <select multiple class="form-control form-control-sm select2" name="navigations[]" id="navigations">
                @foreach ($navigations as $navigation)
                    <option value="{{ $navigation->permissions->first()['id'] }}">
                        @isset($navigation->parent['name'])
                            {{ $navigation->parent['name'].' '.$navigation->name }}
                        @else
                            {{ $navigation->name }}
                        @endisset
                    </option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="card-footer p-1">
        <div class="d-flex justify-content-center">
            <button type="submit" class="btn btn-primary btn-xs py-0 px-1">SAVE</button>
            <button type="button" class="btn btn-back btn-danger btn-xs py-0 px-1 ml-1">BACK</button>
        </div>
    </div>
{!! Form::close() !!}
